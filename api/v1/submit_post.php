<?php

header('Content-Type: application/json');  

require_once '../../important/config.php';

class PostAPI
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function submitPost(array $postData): array
    {
        $username = $postData['username'];
        $password = $postData['password'];

        $content = $postData['content'] ?? null; 


        $siteEmbedUrl = $postData['site_embed_url'] ?? null;

        $imageUrl = isset($_FILES['image']) ? $this-> HandleImageUpload() : null; 
        
        $youtubeVideoUrl = $postData['youtube_video_url'] ?? null;

        $community = $postData['community'] ?? null;
        

        $authResponse = $this->authenticateUser($username, $password);

        if ($authResponse['status'] !== 'success') {
            return $authResponse;  
        }

        if (empty($username)) {
            return $this->response('error', 'Username required.');
        }

        if ($content == null && $imageUrl == null) {
            return $this->response('error', 'content or an image is required.');
        }

        $mentionedUsernames = $this->getMentionedUsernames($content);

        try {
            $stmt = $this->pdo->prepare("INSERT INTO posts 
                                            (username, content, site_embed_url, image_url, youtube_video_url, community, plus_one_usernames, plus_one_count) 
                                            VALUES 
                                            (:username, :content, :site_embed_url, :image_url, :youtube_video_url, :community, :plus_one_usernames, :plus_one_count)");

            $stmt->execute([
                'username' => $username,
                'content' => $content,
                'site_embed_url' => $siteEmbedUrl,
                'image_url' => $imageUrl,
                'youtube_video_url' => $youtubeVideoUrl,
                'community' => $community,
                'plus_one_usernames' => '',
                'plus_one_count' => 0, 
            ]);

            $postId = $this->pdo->lastInsertId();

            foreach ($mentionedUsernames as $mentionedUsername) {
                $this->sendNotification($mentionedUsername, $username, $postId);
            }

            return $this->response('success', 'Post created successfully', [
                'id' => $postId,
                'username' => $username,
                'content' => $content,
                'plus_one_count' => 0,
                'plus_one_usernames' => [],
                'site_embed_url' => $siteEmbedUrl,
                'image_url' => $imageUrl,
                'youtube_video_url' => $youtubeVideoUrl,
                'community' => $community,
                'created_at' => date('Y-m-d H:i:s'),
                'comment' => []
            ]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function authenticateUser(string $username, string $password): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return $this->response('error', 'Invalid username or password.');
            }

            return $this->response('success', 'User authenticated');
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function getMentionedUsernames(string $content): array
    {
        preg_match_all('/\+([a-zA-Z0-9_]+)/', $content, $matches);
        return $matches[1]; 
    }

    private function sendNotification(string $mentionedUsername, string $authorUsername, int $postId): void
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE username = :username");
            $stmt->execute(['username' => $mentionedUsername]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $stmt = $this->pdo->prepare("INSERT INTO notifications (receiver, sender, post_id, content, status) 
                                             VALUES (:receiver, :sender, :post_id, :content, 'unread')");
                $stmt->execute([
                    'receiver' => $mentionedUsername,
                    'sender' => $authorUsername,
                    'post_id' => $postId,
                    'content' => "You were mentioned in a post by $authorUsername.",
                ]);
            }
        } catch (PDOException $e) {

        }
    }

    private function HandleImageUpload(): ?string
    {
        if (!isset($_FILES['image'])) {
            return null;
        }

        $file = $_FILES['image'];
        $originalExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $targetDirectory = '../../assets/user_images/';
        $siteUrl = "http://" . $_SERVER['HTTP_HOST'];

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic', 'heif', 'avif'];
        if (!in_array($originalExtension, $validExtensions)) {
            return null;
        }

        $generateFileName = function($ext) {
            return uniqid() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
        };

        // we we have to convert some formats, webps as well since some browsers have issues
        // and they're annoying to save
        // jpegs are fine, and gifs cannot really be converted 

        $savePngAndReturnUrl = function($img) use ($targetDirectory, $siteUrl) {
            $pngName = uniqid() . '_' . bin2hex(random_bytes(5)) . '.png';
            $pngPath = $targetDirectory . $pngName;
            if (imagepng($img, $pngPath)) {
                imagedestroy($img);
                return $siteUrl . '/assets/user_images/' . $pngName;
            } else {
                error_log("Failed to save PNG file at $pngPath");
                imagedestroy($img);
                return null;
            }
        };
        
        if ($originalExtension === 'webp') {
            if (function_exists('imagecreatefromwebp')) {
                $img = imagecreatefromwebp($file['tmp_name']);
                if ($img) {
                    return $savePngAndReturnUrl($img);
                } else {
                    error_log("Failed to create image resource from WebP file: " . $file['tmp_name']);
                    return null;
                }
            } else {
                error_log("Function imagecreatefromwebp does not exist. Cannot convert WebP.");
                return null;
            }
        }

        if ($originalExtension === 'avif') {
            if (function_exists('imagecreatefromavif')) {
                $img = imagecreatefromavif($file['tmp_name']);
                if ($img) {
                    return $savePngAndReturnUrl($img);
                } else {
                    error_log("Failed to create image resource from AVIF file: " . $file['tmp_name']);
                    return null;
                }
            } else {
                error_log("Function imagecreatefromavif does not exist. Cannot convert AVIF.");
                return null;
            }
        }

        if ($originalExtension === 'heic' || $originalExtension === 'heif') {
            if (class_exists('Imagick')) {
                try {
                    $imagick = new Imagick($file['tmp_name']);
                    $imagick->setImageFormat('png');
                    $pngName = $generateFileName('png');
                    $pngPath = $targetDirectory . $pngName;
                    if ($imagick->writeImage($pngPath)) {
                        $imagick->clear();
                        $imagick->destroy();
                        return $siteUrl . '/assets/user_images/' . $pngName;
                    } else {
                        error_log("Failed to save PNG from HEIC using Imagick.");
                        return null;
                    }
                } catch (Exception $e) {
                    error_log("Imagick error converting HEIC: " . $e->getMessage());
                    return null;
                }
            } else {
                error_log("Imagick class not available - cannot convert HEIC/HEIF.");
                return null;
            }
        }

        $fileName = $generateFileName($originalExtension);
        $targetFile = $targetDirectory . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $siteUrl . '/assets/user_images/' . $fileName;
        } else {
            error_log("Failed to move uploaded file to $targetFile");
            return null;
        }
    }

    private function response(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}

$requestData = $_POST;

$authAPI = new PostAPI($pdo);
$response = $authAPI->submitPost($requestData);

echo json_encode($response);

