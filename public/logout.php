<?php
// public/logout.php
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
session_start();
$_SESSION['success'] = "Logged out successfully.";
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../public/index-final.php'));
exit;
