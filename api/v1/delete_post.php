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

        $authResponse = $this-> AuthenticateUser($username, $password);
       
        if ($authResponse['status'] !== 'success') {
            return $authResponse;  
        }

        try {

            $stmt = $this->pdo->prepare("SELECT image_url FROM posts WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $imageUrl = $stmt->fetchColumn();

            if($imageUrl != null) {
                $this -> HandleImageDeleting($imageUrl);
            }

            $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->execute([':id' => $id]);


            return $this->response('success', 'Deleted post!');

        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function AuthenticateUser(string $username, string $password): array
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

    private function HandleImageDeleting(string $imageUrl)
    {

        $documentRoot = $_SERVER['DOCUMENT_ROOT']; 
        
        // there is 100% a better way of doing this but am lazy
        
        // but it works, so we do it, since image url is also going to be like "http://yap.com//yap/image.png"
        // so there will always be three slashes up to the real path we can just delete the first three by splitting into parts
        // and limiting the exploding (if you're reading this and know a better way create a pull requst)

        $parts = explode('/', $imageUrl, 4); 
        $relativePath = isset($parts[3]) ? '/' . $parts[3] : '';

        error_log($relativePath);

        $filePath = $documentRoot . $relativePath;

        error_log("Image to delete: " . $filePath);

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return null;
            } else {
                error_log("Failed to delete file " . $filePath);
                return;
            }
        } else {
            error_log("Image does not exist " . $filePath);
            return;
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

