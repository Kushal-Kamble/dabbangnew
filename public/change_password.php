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
    } else if ($new !== $conf) {
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
<html>
<head>
  <meta charset="utf-8">
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="p-4">
  <div class="container" style="max-width:540px;margin-top:50px;">
    <h4>Change Password</h4>

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
      <button class="btn btn-primary">Change Password</button>
    </form>
  </div>

  <?php if (!empty($msg)): ?>
    <script>
      Swal.fire({
        icon: '<?= $msg['type']==='success' ? 'success' : 'error' ?>',
        title: '<?= addslashes($msg['text']) ?>'
      });
    </script>
  <?php endif; ?>
</body>
</html>
