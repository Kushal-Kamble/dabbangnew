<?php
// public/subscribe.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../inc/mailer.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function generateRandomPassword($length = 10) {
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

// Basic validations
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
if (!preg_match('/^[0-9\+\-\s]{7,15}$/', $mobile)) {
    $_SESSION['error'] = "Invalid mobile number.";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}
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

// Generate password
$plainPass = generateRandomPassword(10);
$hashPass  = password_hash($plainPass, PASSWORD_BCRYPT);
$status    = 1;

// Insert subscriber
$stmt = $conn->prepare("INSERT INTO subscribers (first_name, last_name, email, mobile, linkedin_url, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    $_SESSION['error'] = "DB error (prepare).";
    header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
    exit;
}
$stmt->bind_param("ssssssi", $first_name, $last_name, $email, $mobile, $linkedin_url, $hashPass, $status);

if ($stmt->execute()) {
    // Email subject
    $subject = "🎉 Welcome {$first_name}, Your Subscription is Active!";

    // Plain text
    $plainText = "Hi {$first_name} {$last_name},\n\n"
        . "Thanks for subscribing to WORKSMART Newsletter!\n\n"
        . "Login details:\n"
        . "Email: {$email}\n"
        . "Password: {$plainPass}\n\n"
        . "Login: " . rtrim($BASE_URL, '/') . "/public/login.php\n\n"
        . "For your security, please change your password after logging in.\n\n"
        . "— WORKSMART Team";

    // HTML template (table-based)
   // Hybrid Modern Email HTML
$html = "
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
</head>
<body style='margin:0;padding:0;background:linear-gradient(135deg,#fff7f2,#ffe4d0);'>
  <table cellpadding='0' cellspacing='0' border='0' width='100%'>
    <tr>
      <td align='center' style='padding:40px 15px;'>
        <table cellpadding='0' cellspacing='0' border='0' width='600' style='background:#fffaf6;border-radius:16px;overflow:hidden;font-family:Arial,sans-serif;box-shadow:0 8px 25px rgba(0,0,0,0.12);border:1px solid #ffd6b0;'>
          
          <!-- Header -->
          <tr>
            <td style='background:linear-gradient(45deg,#f5945c,#fec76f);padding:24px;text-align:center;'>
              <h2 style='margin:0;font-size:22px;color:#fff;'>Welcome to WORKSMART Newsletter 🎉</h2>
            </td>
          </tr>
          
          <!-- Body -->
          <tr>
            <td style='padding:36px;color:#333;font-size:15px;line-height:1.6;'>
              <p style='margin:0 0 12px;font-size:17px;'>Hi <strong>".htmlspecialchars($first_name)." ".htmlspecialchars($last_name)."</strong>,</p>
              <p style='margin:0 0 20px;color:#555;'>
                Thank you for subscribing to <strong>WORKSMART Newsletter</strong>! 🚀<br>
                Here are your login details:
              </p>
              
              <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin-bottom:20px;'>
                <tr>
                  <td style='background:#fef4e7;padding:12px 18px;border-radius:8px;font-size:15px;color:#444;border:1px solid #ffd2a6;'>
                    <strong>Email:</strong> ".htmlspecialchars($email)."
                  </td>
                </tr>
                <tr><td style='height:10px;'></td></tr>
                <tr>
                  <td style='background:#fef4e7;padding:12px 18px;border-radius:8px;font-size:15px;color:#444;border:1px solid #ffd2a6;'>
                    <strong>Password:</strong> <span style='color:#f5945c;font-weight:bold;'>".htmlspecialchars($plainPass)."</span>
                  </td>
                </tr>
              </table>
              
              <p style='text-align:center;margin:20px 0;'>
                <a href='".htmlspecialchars(rtrim($BASE_URL,'/').'/public/login.php')."' 
                   style='background:#f5945c;color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:bold;font-size:15px;display:inline-block;'>
                  Login Now
                </a>
              </p>
              
              <p style='font-size:13px;color:#777;margin-top:18px;text-align:center;'>
                For your security, please change your password after logging in.
              </p>
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style='background:#fff2e5;padding:12px;text-align:center;color:#777;font-size:12px;border-top:1px solid #ffd2a6;'>
              © ".date('Y')." WORKSMART Newsletter | Stay Connected 🚀
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>";


    $alt = $plainText;
    $sent = false;

    // Try using custom mailer if available
    if (function_exists('sendMailHTML')) {
        $sent = sendMailHTML($email, $first_name . ' ' . $last_name, $subject, $html, $alt);
    }

    // Fallback: PHP mail
    if (!$sent) {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: WORKSMART Newsletter <newsletter@worksmart.com>\r\n";
        @mail($email, $subject, $html, $headers);
    }

    $_SESSION['success'] = "Subscription successful! Check your email for login details.";
} else {
    $_SESSION['error'] = "Subscription failed. Please try again later.";
}

$stmt->close();
header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
exit;
