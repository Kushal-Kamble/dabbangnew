<?php
// public/change_password.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../inc/mailer.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['user_logged_in'])) {
    $_SESSION['error'] = "Please login to change your password.";
    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];
$msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = trim($_POST['old_password'] ?? '');
    $new = trim($_POST['new_password'] ?? '');
    $conf = trim($_POST['confirm_password'] ?? '');

    if (!$old || !$new || !$conf) {
        $msg = ['type'=>'error','text'=>'Please fill all fields.'];
    } elseif ($new !== $conf) {
        $msg = ['type'=>'error','text'=>'New password and confirmation do not match.'];
    } else {
        // Fetch current user details
        $stmt = $conn->prepare("SELECT password, email, first_name, last_name FROM subscribers WHERE id=? AND status=1 LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($old, $user['password'])) {
            $msg = ['type'=>'error','text'=>'Old password is incorrect.'];
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            $up = $conn->prepare("UPDATE subscribers SET password=? WHERE id=?");
            $up->bind_param("si", $hash, $userId);
            if ($up->execute()) {
                // Email content
                $subject = "🔒 Password Changed Successfully";
                $loginUrl = rtrim($BASE_URL, '/') . "/public/login.php";
                $html = "
                <div style='font-family:Arial,sans-serif;background:#fef9f6;padding:40px;text-align:center;'>
                  <div style='max-width:480px;margin:auto;background:#fff;border-radius:12px;
                              box-shadow:0 6px 20px rgba(0,0,0,0.1);overflow:hidden;'>
                    <div style='background:linear-gradient(45deg,#f5945c,#fec76f);padding:20px;'>
                      <h2 style='color:#fff;margin:0;'>Password Changed</h2>
                    </div>
                    <div style='padding:30px;color:#444;font-size:15px;line-height:1.6;'>
                      <p>Hi <strong>{$user['first_name']} {$user['last_name']}</strong>,</p>
                      <p>Your password was successfully updated. If you did not perform this change, please contact support immediately.</p>
                      <div style='margin:20px 0;text-align:center;'>
                        <a href='{$loginUrl}' style='background:#f5945c;color:#fff;padding:12px 28px;border-radius:6px;
                                  text-decoration:none;font-weight:bold;'>Login</a>
                      </div>
                      <p style='font-size:12px;color:#777;'>© ".date('Y')." MITSDE Newsletter</p>
                    </div>
                  </div>
                </div>";

                // Try sending email via PHPMailer helper
                $sent = sendMailHTML($user['email'], "{$user['first_name']} {$user['last_name']}", $subject, $html);
                if (!$sent) {
                    // Fallback PHP mail()
                    $headers  = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                    $headers .= "From: newsletter@mitsde.com\r\n";
                    @mail($user['email'], $subject, $html, $headers);
                }

                $msg = ['type'=>'success','text'=>'Password changed successfully.'];
            } else {
                $msg = ['type'=>'error','text'=>'Could not update password. Try later.'];
            }
            $up->close();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background:linear-gradient(135deg,#fec76f,#f5945c);
      min-height:100vh;display:flex;align-items:center;justify-content:center;
    }
    .card {
      max-width:420px;width:100%;background:#fff;padding:2rem;border-radius:16px;
      box-shadow:0 10px 25px rgba(0,0,0,0.15);animation:fadeIn .6s ease;
    }
    .btn-brand {
      background:#f5945c;border:none;width:100%;font-weight:bold;transition:.3s;
    }
    .btn-brand:hover {background:#e68244;}
    @keyframes fadeIn {from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
  </style>
</head>
<body>
  <div class="card">
    <h3 class="text-center mb-4" style="color:#f5945c;">🔑 Change Password</h3>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Old Password</label>
        <input name="old_password" type="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input name="new_password" type="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input name="confirm_password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-brand">Change Password</button>
    </form>
  </div>

  <?php if (!empty($msg)): ?>
<script>
Swal.fire({
  icon: '<?= $msg['type']==='success' ? 'success' : 'error' ?>',
  title: '<?= addslashes($msg['text']) ?>',
  confirmButtonColor: '#f5945c',
  timer: <?= $msg['type']==='success' ? 2000 : 'null' ?>, // success pe auto close after 2s
  showConfirmButton: <?= $msg['type']==='success' ? 'false' : 'true' ?>
}).then(() => {
  <?php if ($msg['type']==='success'): ?>
    window.location.href = 'login.php';
  <?php endif; ?>
});
</script>
<?php endif; ?>

</body>
</html>
