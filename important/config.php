<?php

define('TIMEZONE', 'America/New_York');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

$host = $_SERVER['HTTP_HOST'];

define('SITE_URL', $protocol . '://' . $host);

define('DB_HOST', 'localhost');
define('DB_NAME', 'loogle_plus');
define('DB_USER', 'root');
define('DB_PASS', 'nicknick');

define('REQUIRE_CODE_FOR_REGISTRATION', true);

date_default_timezone_set(TIMEZONE);

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>