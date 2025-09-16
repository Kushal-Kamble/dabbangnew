<?php
// public/subscribe.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../inc/mailer.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function generateRandomPassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pass = '';
    for ($i = 0; $i < $length; $i++) {
        $pass .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $pass;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . ($BASE_URL ?? '/'));
    exit;
}

$first_name   = trim($_POST['first_name'] ?? '');
$last_name    = trim($_POST['last_name'] ?? '');
$email        = trim($_POST['email'] ?? '');
$mobile       = trim($_POST['mobile'] ?? '');
$linkedin_url = trim($_POST['linkedin_url'] ?? '');

if (!$first_name || !$last_name || !$email || !$mobile || !$linkedin_url) {
    $_SESSION['error'] = "Please fill all fields.";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email address.";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}

// Simple phone validation (adjust if you want stricter)
if (!preg_match('/^[0-9\+\-\s]{7,15}$/', $mobile)) {
    $_SESSION['error'] = "Invalid mobile number.";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}

// Basic LinkedIn URL check
$u = parse_url($linkedin_url);
if (empty($u['host']) || strpos($linkedin_url, 'linkedin.com') === false) {
    $_SESSION['error'] = "Please provide a valid LinkedIn profile URL (e.g. https://www.linkedin.com/in/yourname).";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}

// Duplicate email check
$check = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    $_SESSION['error'] = "This email is already subscribed. Try login or use Forgot Password.";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}

// Generate password and hash
$plainPass = generateRandomPassword(10);
$hashPass  = password_hash($plainPass, PASSWORD_BCRYPT);
$status    = 1;

$stmt = $conn->prepare("INSERT INTO subscribers (first_name, last_name, email, mobile, linkedin_url, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    $_SESSION['error'] = "DB error (prepare).";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}
$stmt->bind_param("ssssssi", $first_name, $last_name, $email, $mobile, $linkedin_url, $hashPass, $status);

if ($stmt->execute()) {
    // Send welcome email with credentials (use sendMailHTML if configured)
    $subject = "🎉 Welcome to MITSDE — Your login details";
    $html = "
      <h2>Welcome {$first_name} {$last_name}</h2>
      <p>Thanks for subscribing to MITSDE newsletter.</p>
      <p><strong>Login details</strong></p>
      <ul>
        <li>Email: {$email}</li>
        <li>Password: {$plainPass}</li>
      </ul>
      <p>Login at: <a href='" . rtrim($BASE_URL, '/') . "/public/login.php'>" . rtrim($BASE_URL, '/') . "/public/login.php</a></p>
      <p>If you face issues, use Forgot Password on the login page.</p>
    ";
    $alt = "Welcome {$first_name} {$last_name}. Login: {$email} Password: {$plainPass}";
    $sent = false;
    if (function_exists('sendMailHTML')) {
        $sent = sendMailHTML($email, $first_name . ' ' . $last_name, $subject, $html, $alt);
    }
    if (!$sent) {
        // fallback to PHP mail (less reliable)
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: newsletter@mitsde.com\r\n";
        @mail($email, $subject, $html, $headers);
    }

    $_SESSION['success'] = "Subscription successful! Check your email for login details.";
} else {
    $_SESSION['error'] = "Subscription failed. Please try again later.";
}

$stmt->close();
header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
exit;
