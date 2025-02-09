<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../important/config.php';  

if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($username) || empty($password)) {
        header('Location: ../account/login.php?error=' . urlencode('Username and password are required.'));
        exit();
    }

    try {

        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");
            setcookie('password', $password, time() + (30 * 24 * 60 * 60), "/");

            header('Location: ../index.php');
            exit();
        } else {

            header('Location: ../account/login.php?error=' . urlencode('Invalid username or password.'));
            exit();
        }
    } catch (PDOException $e) {

        header('Location: ../account/login.php?error=' . urlencode('Database error: ' . $e->getMessage()));
        exit();
    }
}

?>s