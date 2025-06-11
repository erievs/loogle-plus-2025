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
        $fileName = uniqid() . '_' . bin2hex(random_bytes(5)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        $targetDirectory = '../../assets/user_images/';
        $targetFile = $targetDirectory . $fileName;

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            return null;
        }

        $siteUrl = "http://" . $_SERVER['HTTP_HOST'];  
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $siteUrl . '/assets//user_images/' . $fileName;
        }
        
        return null;
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

