<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../important/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $registrationCode = isset($_POST['registration_code']) ? trim($_POST['registration_code']) : '';

    if (empty($username) || empty($password)) {
        header('Location: ../account/register.php?error=' . urlencode('Username and password are required.'));
        exit();
    }

    if (REQUIRE_CODE_FOR_REGISTRATION && empty($registrationCode)) {
        header('Location: ../account/register.php?error=' . urlencode('Registration code is required.'));
        exit();
    }

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            header('Location: ../account/register.php?error=' . urlencode('Username already exists.'));
            exit();
        }

        if (REQUIRE_CODE_FOR_REGISTRATION) {
            $stmt = $pdo->prepare("SELECT * FROM registration_codes WHERE code = :code AND is_used = FALSE");
            $stmt->execute(['code' => $registrationCode]);
            $validCode = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$validCode) {
                header('Location: ../account/register.php?error=' . urlencode('Invalid or used registration code.'));
                exit();
            }

            $stmt = $pdo->prepare("UPDATE registration_codes SET is_used = TRUE WHERE id = :id");
            $stmt->execute(['id' => $validCode['id']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO accounts (username, password, ip_address, user_status) 
                               VALUES (:username, :password, :ip_address, :user_status)");
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword,
            'ip_address' => $ipAddress,
            'user_status' => 'user',
        ]);

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");
        setcookie('password', $password, time() + (30 * 24 * 60 * 60), "/");

        header('Location: ../index.php');
        exit();

    } catch (PDOException $e) {
        header('Location: ../account/register.php?error=' . urlencode('Database error: ' . $e->getMessage()));
        exit();
    }
}
?>