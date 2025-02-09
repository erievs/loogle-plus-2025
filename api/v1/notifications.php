<?php

header('Content-Type: application/json');

require_once '../../important/config.php';

class NotificationAPI
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getNotifications(string $username, string $request): array
    {
        switch ($request) {
            case 'unread_count':
                return $this->getUnreadCount($username);
            case 'unread_data':
                return $this->getUnreadNotifications($username);
            case 'all_count':
                return $this->getAllCount($username);
            case 'all_data':
                return $this->getAllNotifications($username);
            case 'read_notification':
                return $this->markNotificationAsRead($username, $_GET['id']);
            case 'read_all_notifications':
                return $this->markAllNotificationsAsRead($username);
            default:
                return $this->response('error', 'Invalid request type.');
        }
    }

    private function getUnreadCount(string $username): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifications WHERE receiver = :username AND status = 'unread'");
            $stmt->execute(['username' => $username]);
            $count = $stmt->fetchColumn();
            return $this->response('success', 'Unread count fetched successfully', ['count' => $count]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function getUnreadNotifications(string $username): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE receiver = :username AND status = 'unread'");
            $stmt->execute(['username' => $username]);
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->response('success', 'Unread notifications fetched successfully', ['notifications' => $notifications]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function getAllCount(string $username): array
    {
        try {
    
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifications WHERE receiver = :username AND status = 'unread'");
            $stmt->execute(['username' => $username]);
            $count = $stmt->fetchColumn();
            return $this->response('success', 'Unread count fetched successfully', ['count' => $count]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function getAllNotifications(string $username): array
    {
        try {
    
            $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE receiver = :username AND status = 'unread'");
            $stmt->execute(['username' => $username]);
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->response('success', 'Unread notifications fetched successfully', ['notifications' => $notifications]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function markNotificationAsRead(string $username, $notificationId): array
    {
        if (empty($notificationId)) {
            return $this->response('error', 'Notification ID is required.');
        }

        try {

            $stmt = $this->pdo->prepare("SELECT * FROM notifications WHERE id = :id AND receiver = :username");
            $stmt->execute(['id' => $notificationId, 'username' => $username]);
            $notification = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$notification) {
                return $this->response('error', 'Notification not found or does not belong to the user.');
            }

            $stmt = $this->pdo->prepare("UPDATE notifications SET status = 'read' WHERE id = :id");
            $stmt->execute(['id' => $notificationId]);

            return $this->response('success', 'Notification marked as read successfully.');
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function markAllNotificationsAsRead(string $username): array
    {
        try {

            $stmt = $this->pdo->prepare("UPDATE notifications SET status = 'read' WHERE receiver = :username AND status = 'unread'");
            $stmt->execute(['username' => $username]);

            return $this->response('success', 'All notifications marked as read successfully.');
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

$requestData = $_GET;
if (!isset($requestData['username']) || !isset($requestData['request'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
    exit();
}

$notificationAPI = new NotificationAPI($pdo);
$response = $notificationAPI->getNotifications($requestData['username'], $requestData['request']);

echo json_encode($response);

?>