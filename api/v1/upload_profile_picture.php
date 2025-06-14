<?php

header('Content-Type: application/json');
require_once '../../important/config.php'; 

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (!$username || !$password) {
    echo response('error', 'Missing username or password.');
    exit;
}

if (!AuthenticateUser($pdo, $username, $password)) {
    echo response('error', 'Invalid credentials.');
    exit;
}

$result = SaveProfilePicture($username);

if (isset($result['error'])) {
    echo response('error', $result['error']);
    exit;
}

$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/assets/profile_pictures/' . basename($result['path']);

echo response('success', 'Profile picture updated.', [
    'url' => $imgUrl
]);

// Stuff

function response($status, $message, $data = []) {
    return json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
}

function AuthenticateUser(PDO $pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT password FROM accounts WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }

    return true;
}

function SaveProfilePicture($username) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'No valid image uploaded.'];
    }

    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $validExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    if (!in_array($ext, $validExts)) {
        return ['error' => 'Unsupported file type.'];
    }

    $usernameSafe = preg_replace('/[^a-zA-Z0-9_\-]/', '', $username);
    $filename = $usernameSafe . '.' . $ext;
    $targetDir = '../../assets/profile_pictures/';
    $targetPath = $targetDir . $filename;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }


    foreach ($validExts as $existingExt) {
        $existingPath = $targetDir . $usernameSafe . '.' . $existingExt;
        if (file_exists($existingPath)) {
            unlink($existingPath);
        }
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'path' => $targetPath];
    }

    return ['error' => 'X`'];
}


