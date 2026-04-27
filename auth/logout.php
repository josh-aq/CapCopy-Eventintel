<?php
require_once __DIR__ . '/../config/db.php';

// Clear all session data
$_SESSION = [];

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// Destroy the session
session_destroy();

// Redirect to login page
redirect_to('/html/index.php');
?>
