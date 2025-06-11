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

    public function PlusOnePost(array $data): array
    {
        $username = $data['username'];
        $password = $data['password'];
        $postId = $data['post_id'];

        $authResponse = $this-> AuthenticateUser($username, $password);
        
        if ($authResponse['status'] !== 'success') {
            return $authResponse;
        }

        try {

            $stmt = $this->pdo->prepare("SELECT plus_one_usernames FROM posts WHERE id = :post_id");
            $stmt->execute(['post_id' => $postId]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$post) {
                return $this->response('error', 'Post not found.');
            }

            $plusOneUsernames = $post['plus_one_usernames'];

            if ($plusOneUsernames === null) {
                $plusOneUsernames = '';
            }

            $plusOneUsernamesArray = explode(',', $plusOneUsernames);
            $plusOneUsernamesArray = array_filter($plusOneUsernamesArray, 'strlen'); 

            if (in_array($username, $plusOneUsernamesArray)) {

                $plusOneUsernamesArray = array_filter($plusOneUsernamesArray, function($user) use ($username) {
                    return $user !== $username; 
                });
                $action = 'subtracted';
            } else {

                $plusOneUsernamesArray[] = $username; 
                $action = 'added';
            }

            $plusOneUsernames = implode(',', $plusOneUsernamesArray);

            $stmt = $this->pdo->prepare("UPDATE posts SET plus_one_usernames = :plus_one_usernames WHERE id = :post_id");
            $stmt->execute([
                'plus_one_usernames' => $plusOneUsernames,
                'post_id' => $postId
            ]);

            $plusOneCount = count($plusOneUsernamesArray);
            $plusOneCount = max(0, $plusOneCount); 

            return $this->response('success', "Plus one has been $action.", [
                'post_id' => $postId,
                'plus_one_count' => $plusOneCount,
                'plus_one_usernames' => $plusOneUsernames
            ]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    function AuthenticateUser(string $username, string $password): array
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
$response = $authAPI->PlusOnePost($requestData);

echo json_encode($response);

?>