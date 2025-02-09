<?php

header('Content-Type: application/json');

require_once '../../important/config.php';

class CommentAPI
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function submitComment(array $commentData): array
    {
        $postId = $commentData['post_id'];
        $username = $commentData['username'];
        $password = $commentData['password'];
        $content = $commentData['content'];

        $authResponse = $this->authenticateUser($username, $password);
        if ($authResponse['status'] !== 'success') {
            return $authResponse;
        }

        if (empty($postId) || empty($username) || empty($content)) {
            return $this->response('error', 'Post ID, username, and content are required.');
        }

        $mentionedUsernames = $this->getMentionedUsernames($content);

        try {

            $stmt = $this->pdo->prepare("INSERT INTO comments (post_id, username, content) 
                                         VALUES (:post_id, :username, :content)");
            $stmt->execute([
                'post_id' => $postId,
                'username' => $username,
                'content' => $content,
            ]);

            $commentId = $this->pdo->lastInsertId();

            foreach ($mentionedUsernames as $mentionedUsername) {
                $this->sendNotification($mentionedUsername, $username, $postId, $commentId);
            }

            return $this->response('success', 'Comment created successfully', [
                'id' => $commentId,
                'post_id' => $postId,
                'username' => $username,
                'content' => $content,
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

    private function sendNotification(string $mentionedUsername, string $authorUsername, int $postId, int $commentId): void
    {
        try {

            $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE username = :username");
            $stmt->execute(['username' => $mentionedUsername]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {

                $stmt = $this->pdo->prepare("INSERT INTO notifications (receiver, sender, post_id, comment_id, content, status) 
                                             VALUES (:receiver, :sender, :post_id, :comment_id, :content, 'unread')");
                $stmt->execute([
                    'receiver' => $mentionedUsername,
                    'sender' => $authorUsername,
                    'post_id' => $postId,
                    'comment_id' => $commentId,
                    'content' => "You were mentioned in a comment by $authorUsername.",
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

$commentAPI = new CommentAPI($pdo);
$response = $commentAPI->submitComment($requestData);

echo json_encode($response);

?>