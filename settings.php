<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!defined('DEPENDENCIES_INCLUDED')) {
    include './assets/php/dependencies.php';
    define('DEPENDENCIES_INCLUDED', true);
}

include './account/check_login.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_COOKIE['username']) ? $_COOKIE['username'] : 'Not logged in');
$password = isset($_SESSION['password']) ? $_SESSION['password'] : (isset($_COOKIE['password']) ? $_COOKIE['password'] : 'Not available');

?>
<!DOCTYPE html>

<!-- somepoint do settings saving on the database -->

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loogle+</title>
    <link href="/assets/css/2013settings.css" rel="stylesheet">
    <script src="/assets/js/2013settings.js"></script>
</head>

<body>

    <?php include './assets/php/header.php'; ?>

    <div class="main-wrapper">
        <div class="settings-container">
            <div class="settings-items">

                <div class="settings-item">
                    
                    <b class="settings-row-title">Site Settings</b>

                    <br>

                    <label id="item-check">
                        <input type="checkbox" id="hide-alerts-checkbox"> Hide Alerts
                    </label>

                </div>

            </div>
        </div>
    </div>

</body>

</html>