<?php

header('Content-Type: application/json');
require_once '../../important/config.php';

function AuthenticateUser(PDO $pdo, string $username, string $password): array
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return Response('error', 'Invalid username or password.');
        }

        return Response('success', 'User authenticated');
    } catch (PDOException $e) {
        return Response('error', 'Database error: ' . $e->getMessage());
    }
}

function GetMentionedUsernames(string $content): array
{
    preg_match_all('/\+([a-zA-Z0-9_]+)/', $content, $matches);
    return $matches[1]; 
}

function SendNotification(PDO $pdo, string $receiver, string $sender, int $postId, int $commentId, string $content): void
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->execute(['username' => $receiver]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $stmt = $pdo->prepare("INSERT INTO notifications (receiver, sender, post_id, content, status) 
                                  VALUES (:receiver, :sender, :post_id, :content, 'unread')");
            $stmt->execute([
                'receiver' => $receiver,
                'sender' => $sender,
                'post_id' => $postId,
                'content' => $content,
            ]);
            error_log("Notification inserted: receiver=$receiver, sender=$sender, postId=$postId, commentId=$commentId");
        } else {
            error_log("Notification failed: receiver account '$receiver' does not exist.");
        }

    } catch (PDOException $e) {
        error_log("Notification DB error: " . $e->getMessage());
    }
}


function GetPostAuthor(PDO $pdo, int $postId): ?string
{
    try {
        $stmt = $pdo->prepare("SELECT username FROM posts WHERE id = :postId");
        $stmt->execute(['postId' => $postId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['username'] : null;
    } catch (PDOException $e) {
        return null;
    }
}

function Response(string $status, string $message, array $data = []): array
{
    return [
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ];
}

function SubmitComment(PDO $pdo, array $commentData): array
{
    $postId = $commentData['post_id'];
    $username = $commentData['username'];
    $password = $commentData['password'];
    $content = $commentData['content'];

    $authResponse = AuthenticateUser($pdo, $username, $password);
    if ($authResponse['status'] !== 'success') {
        return $authResponse;
    }

    if (empty($postId) || empty($username) || empty($content)) {
        return Response('error', 'Post ID, username, and content are required.');
    }

    $mentionedUsernames = GetMentionedUsernames($content);

    try {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, username, content) 
                             VALUES (:post_id, :username, :content)");
        $stmt->execute([
            'post_id' => $postId,
            'username' => $username,
            'content' => $content,
        ]);

        $commentId = $pdo->lastInsertId();

    

        $postAuthor = GetPostAuthor($pdo, $postId);
        if ($postAuthor !== null && $postAuthor !== $username) { // to prevent a bunch of useless notifications
            SendNotification(
                $pdo,
                $postAuthor,
                $username,
                $postId,
                $commentId,
                "New comment on your post by $username."
            );

            error_log("Notification sent to post author: $postAuthor by commenter: $username");
        }

        foreach ($mentionedUsernames as $mentionedUsername) {

            SendNotification(
                $pdo,
                $mentionedUsername,
                $username,
                $postId,
                $commentId,
                "You were mentioned in a comment by $username."
            );
         
        }

        return Response('success', 'Comment created successfully', [
            'id' => $commentId,
            'post_id' => $postId,
            'username' => $username,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

    } catch (PDOException $e) {
        return Response('error', 'Database error: ' . $e->getMessage());
    }
}

$requestData = json_decode(file_get_contents('php://input'), true);

if ($requestData === null) {
    echo json_encode(Response('error', 'Invalid JSON or no data provided.'));
    exit();
}

$response = SubmitComment($pdo, $requestData);
echo json_encode($response);
?>