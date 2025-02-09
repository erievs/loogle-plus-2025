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
        $content = $postData['content'];
        $siteEmbedUrl = $postData['site_embed_url'] ?? null;
        $imageUrl = $postData['image_url'] ?? null;
        $youtubeVideoUrl = $postData['youtube_video_url'] ?? null;
        $community = $postData['community'] ?? null;

        $authResponse = $this->authenticateUser($username, $password);
        if ($authResponse['status'] !== 'success') {
            return $authResponse;  
        }

        if (empty($username) || empty($content)) {
            return $this->response('error', 'Username and content are required.');
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

    private function response(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}

$requestData = json_decode(file_get_contents('php://input'), true);

if ($requestData === null) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON or no data provided.',
    ]);
    exit();
}

$authAPI = new PostAPI($pdo);
$response = $authAPI->submitPost($requestData);

echo json_encode($response);

?>