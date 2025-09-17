<?php
// public/forgot_password.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../inc/mailer.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function generateRandomPassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pass = '';
    for ($i = 0; $i < $length; $i++) $pass .= $chars[random_int(0, strlen($chars)-1)];
    return $pass;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Enter a valid email.";
        header("Location: forgot_password.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM subscribers WHERE email = ? AND status = 1 LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $_SESSION['error'] = "No active account found with this email.";
        header("Location: forgot_password.php");
        exit;
    }

    $newPass = generateRandomPassword(10);
    $hash = password_hash($newPass, PASSWORD_BCRYPT);

    $up = $conn->prepare("UPDATE subscribers SET password = ? WHERE id = ?");
    $up->bind_param("si", $hash, $user['id']);
    $ok = $up->execute();
    $up->close();

    if ($ok) {
        $subject = "🔐 WORKSMART — Your New Password";
        $loginUrl = rtrim($BASE_URL, '/') . "/public/login.php";

        // Modern Email HTML
        $html = "
        <div style='font-family:Arial,sans-serif;background:#fef9f6;padding:40px;text-align:center;'>
          <div style='max-width:480px;margin:auto;background:#fff;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,0.1);overflow:hidden;'>
            <div style='background:linear-gradient(45deg,#f5945c,#fec76f);padding:20px;'>
              <h2 style='color:#fff;margin:0;'>Password Reset</h2>
            </div>
            <div style='padding:30px;'>
              <p style='font-size:16px;color:#333;'>Hi <strong>{$user['first_name']}</strong>,</p>
              <p style='font-size:15px;color:#555;'>Your password has been reset. Use the temporary password below to log in. For security, please change your password after logging in.</p>
              <div style='margin:20px 0;padding:12px 20px;background:#fef4e7;border-radius:6px;font-size:18px;font-weight:bold;color:#f5945c;display:inline-block;'>{$newPass}</div>
              <p><a href='{$loginUrl}' style='display:inline-block;margin-top:15px;padding:12px 22px;background:#f5945c;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;'>Login Now</a></p>
            </div>
            <div style='background:#fef4e7;padding:10px;font-size:12px;color:#777;'>© " . date('Y') . " WORKSMART. All rights reserved.</div>
          </div>
        </div>";

        $alt = "Your new password: {$newPass}\nLogin: {$loginUrl}";
        $sent = false;
        if (function_exists('sendMailHTML')) {
            $sent = sendMailHTML($email, "{$user['first_name']} {$user['last_name']}", $subject, $html, $alt);
        }
        if (!$sent) {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";
            $headers .= "From: newsletter@worksmart.com\r\n";
            @mail($email, $subject, $html, $headers);
        }

        $_SESSION['success'] = "A new password was sent to your email.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Could not reset password. Try again later.";
        header("Location: forgot_password.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root { --brand1:#f5945c; --brand2:#fec76f; }
    body {
      min-height:100vh; display:flex; align-items:center; justify-content:center;
      background:linear-gradient(135deg,var(--brand1),var(--brand2));
    }
    .forgot-card {
      max-width:450px; width:100%; background:#fff; padding:30px;
      border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15);
      animation:fadeIn .6s ease;
    }
    .forgot-card h4 { color:var(--brand1); font-weight:600; }
    .btn-brand {
      background:var(--brand1); border:none; color:#fff; font-weight:600; width:100%;
    }
    .btn-brand:hover { background:var(--brand2); color:#212529; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
  </style>
</head>
<body>
  <div class="forgot-card">
    <h4 class="mb-2 text-center">Forgot Password</h4>
    <p class="text-muted text-center mb-4">Enter your email. We’ll send a new temporary password.</p>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
      </div>
      <button class="btn btn-brand mb-2">Reset Password</button>
      <a href="login.php" class="btn btn-link w-100 text-center">Back to Login</a>
    </form>
  </div>
</body>
</html>
