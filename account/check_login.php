<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

} 

elseif (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['password'] = $_COOKIE['password'];
} 
else {

    header('Location: ./account/login.php');
    exit();
}
?>