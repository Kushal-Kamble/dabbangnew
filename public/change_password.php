<?php
// public/change_password.php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['user_logged_in'])) {
    $_SESSION['error'] = "Please login to change your password.";
    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];
$msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $conf = $_POST['confirm_password'] ?? '';

    if (!$old || !$new || !$conf) {
        $msg = ['type'=>'error','text'=>'Please fill all fields.'];
    } elseif ($new !== $conf) {
        $msg = ['type'=>'error','text'=>'New password and confirmation do not match.'];
    } else {
        $stmt = $conn->prepare("SELECT password FROM subscribers WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($old, $user['password'])) {
            $msg = ['type'=>'error','text'=>'Old password is incorrect.'];
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            $up = $conn->prepare("UPDATE subscribers SET password = ? WHERE id = ?");
            $up->bind_param("si", $hash, $userId);
            if ($up->execute()) {
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
    :root { --brand1:#f5945c; --brand2:#fec76f; }
    body {
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      background:linear-gradient(135deg,var(--brand1),var(--brand2));
    }
    .change-card {
      max-width:450px; width:100%; background:#fff; padding:30px;
      border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15);
      animation:fadeIn .6s ease;
    }
    .change-card h4 { color:var(--brand1); font-weight:600; }
    .btn-brand {
      background:var(--brand1); border:none; color:#fff; font-weight:600; width:100%;
    }
    .btn-brand:hover { background:var(--brand2); color:#212529; }
    @keyframes fadeIn {
      from{opacity:0;transform:translateY(20px);}
      to{opacity:1;transform:translateY(0);}
    }
  </style>
</head>
<body>
  <div class="change-card">
    <h4 class="mb-3 text-center">🔑 Change Password</h4>

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
      <button class="btn btn-brand mb-2">Change Password</button>
      <a href="login.php" class="btn btn-link w-100 text-center">Back to Login</a>
    </form>
  </div>

  <?php if (!empty($msg)): ?>
  <script>
    Swal.fire({
      icon: '<?= $msg['type']==='success' ? 'success' : 'error' ?>',
      title: '<?= addslashes($msg['text']) ?>',
      confirmButtonColor: '#f5945c'
    }).then(() => {
  <?php if ($msg['type']==='success'): ?>
    window.location.href = 'login.php';
  <?php endif; ?>
});
</script>;
  </script>
  <?php endif; ?>
</body>
</html>
