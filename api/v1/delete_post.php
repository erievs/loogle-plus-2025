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

    public function DeletePost(array $postData): array
    {
        $username = $postData['username'];
        $password = $postData['password'];
        $id = $postData['id'];

        $authResponse = $this-> authenticateUser($username, $password);
        if ($authResponse['status'] !== 'success') {
            return $authResponse;  
        }

        try {

            $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->execute([':id' => $id]);

            return $this->response('success', 'Deleted post!');

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

    private function response(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status
        ];
    }
}

$requestData = $_POST;

$authAPI = new PostAPI($pdo);
$response = $authAPI-> DeletePost($requestData);

echo json_encode($response);

