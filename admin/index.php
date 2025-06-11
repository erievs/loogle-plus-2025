<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../assets/php/dependencies.php'; 
require_once '../important/config.php'; 

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
} elseif (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['password'] = $_COOKIE['password'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
} else {
    header('Location: ../account/login.php');
    exit();
}

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT user_status FROM accounts WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !in_array($user['user_status'], ['mod', 'admin'])) {
        header('Location: ../index.php?error=' . urlencode('Unauthorized access.'));
        exit();
    }

} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ban_user'])) {
        $banUsername = $_POST['ban_username'];
        $reason = $_POST['ban_reason'];
        $stmt = $pdo->prepare("UPDATE accounts SET ban_status = 'banned', ban_reason = :reason WHERE username = :username");
        $stmt->execute(['username' => $banUsername, 'reason' => $reason]);
    } elseif (isset($_POST['unban_user'])) {
        $unbanUsername = $_POST['unban_username'];
        $stmt = $pdo->prepare("UPDATE accounts SET ban_status = 'active', ban_reason = NULL WHERE username = :username");
        $stmt->execute(['username' => $unbanUsername]);
    } elseif (isset($_POST['create_code'])) {
        $accessCode = bin2hex(random_bytes(8));
        $stmt = $pdo->prepare("INSERT INTO registration_codes (code, created_by) VALUES (:code, :created_by)");
        $stmt->execute(['code' => $accessCode, 'created_by' => $username]);
    } elseif (isset($_POST['revoke_code'])) {
        $code = $_POST['revoke_code'];
        $stmt = $pdo->prepare("DELETE FROM registration_codes WHERE code = :code");
        $stmt->execute(['code' => $code]);
    }
}

$stmt = $pdo->query("SELECT username, ban_status, ban_reason FROM accounts");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT code, created_by, date_created FROM registration_codes");
$codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loogle Admin Panel</title>
</head>

<style>
.btn {
    margin-top: 10px;
}
</style>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Loogle Admin Panel</h1>

        <div class="card mt-4">
            <div class="card-header" style="margin-bottom: 10px; font-size: 20px;">Ban/Unban Users</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3" style="margin-bottom: 10px;">
                        <label for="ban_username" class="form-label">Username to Ban</label>
                        <input type="text" class="form-control" id="ban_username" name="ban_username" required>
                    </div>
                    <div class="mb-3">
                        <label for="ban_reason" class="form-label">Reason for Ban</label>
                        <input type="text" class="form-control" id="ban_reason" name="ban_reason" required>
                    </div>
                    <button type="submit" name="ban_user" class="btn btn-danger">Ban User</button>
                </form>
                <hr>
                <form method="POST">
                    <div class="mb-3">
                        <label for="unban_username" class="form-label">Username to Unban</label>
                        <input type="text" class="form-control" id="unban_username" name="unban_username" required>
                    </div>
                    <button type="submit" name="unban_user" class="btn btn-success">Unban User</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header" style="margin-bottom: 10px; font-size: 20px;">Create and Revoke Access Codes</div>
            <div class="card-body">
                <form method="POST">
                    <button type="submit" name="create_code" class="btn btn-primary">Generate New Access Code</button>
                </form>
                <hr>
                <form method="POST">
                    <div class="mb-3">
                        <label for="revoke_code" class="form-label">Access Code to Revoke</label>
                        <input type="text" class="form-control" id="revoke_code" name="revoke_code" required>
                    </div>
                    <button type="submit" name="revoke_code" class="btn btn-danger">Revoke Code</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header" style="margin-bottom: 10px; font-size: 20px;">Current Users</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['ban_status']); ?></td>
                            <td><?php echo htmlspecialchars($user['ban_reason'] ?: 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header" style="margin-bottom: 10px; font-size: 20px;">Access Codes</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Created By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($codes as $code): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($code['code']); ?></td>
                            <td><?php echo htmlspecialchars($code['created_by']); ?></td>
                            <td><?php echo htmlspecialchars($code['date_created']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
