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

    public function EditPost(array $postData): array
    {
        $username = $postData['username'] ?? '';
        $password = $postData['password'] ?? '';
        $id = isset($postData['id']) ? (int)$postData['id'] : 0;
        $newContent = isset($postData['content']) ? trim($postData['content']) : '';

        if ($id <= 0) {
            return $this->response('error', 'Invalid post ID.');
        }

        if ($newContent === '') {
            return $this->response('error', 'Content cannot be empty.');
        }

        $authResponse = $this->AuthenticateUser($username, $password);
        if ($authResponse['status'] !== 'success') {
            return $authResponse;
        }

        try {

            $stmt = $this->pdo->prepare("SELECT username FROM posts WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $postOwner = $stmt->fetchColumn();

            if (!$postOwner) {
                return $this->response('error', 'Post not found.');
            }

            if ($postOwner !== $username) {
                return $this->response('error', 'You do not have permission to edit this post.');
            }

            $stmt = $this->pdo->prepare("UPDATE posts SET content = :content  WHERE id = :id");
            $stmt->execute([
                ':content' => $newContent,
                ':id' => $id
            ]);

            return $this->response('success', 'Post updated successfully.');

        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function AuthenticateUser(string $username, string $password): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT password FROM accounts WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $hash = $stmt->fetchColumn();

            if (!$hash || !password_verify($password, $hash)) {
                return $this->response('error', 'Invalid username or password.');
            }

            return $this->response('success', 'User authenticated');
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function response(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}

$requestData = $_POST;

$api = new PostAPI($pdo);

$response = $api->EditPost($requestData);

echo json_encode($response);
