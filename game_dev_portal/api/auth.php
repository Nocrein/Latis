<?php
define('ADMIN_EMAIL', 'admin');
define('ADMIN_PASS_HASH', password_hash('admin123', PASSWORD_DEFAULT));

// For production: change these or load from env
function checkLogin($email, $password) {
    $storedEmail = getenv('ADMIN_EMAIL') ?: 'admin';
    $storedPass  = getenv('ADMIN_PASS')  ?: 'admin123';
    return ($email === $storedEmail && $password === $storedPass);
}

function requireLogin() {
    session_start();
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    return !empty($_SESSION['admin_logged_in']);
}
