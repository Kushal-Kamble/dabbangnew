<?php
require_once __DIR__ . '/../config.php';

$email = trim($_GET['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid request.";
    exit;
}

$stmt = $conn->prepare("UPDATE subscribers SET status=0 WHERE email=?");
$stmt->bind_param('s', $email);
$stmt->execute();

echo "<p>You have been unsubscribed: " . htmlspecialchars($email) . "</p>";
echo "<p><a href='" . htmlspecialchars($BASE_URL . "/public/index.php") . "'>Return to site</a></p>";
