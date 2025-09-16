<?php
session_start();
require_once __DIR__ . '/../config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, full_name, password FROM admins WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $db_username, $full_name, $hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $hash)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $db_username;
            $_SESSION['admin_name'] = $full_name;

            $success = "✅ Login successful! Redirecting...";
            echo "<script>
                    setTimeout(function(){
                      window.location.href = '" . $BASE_URL . "/admin/dashboard.php';
                    },1500);
                  </script>";
        } else {
            $error = "❌ Invalid username or password";
        }
    } else {
        $error = "❌ Invalid username or password";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL . '/assets/css/styles.css') ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <style>
    body {
      background: linear-gradient(135deg,#f5f7fb,#fefffe);
      font-family: 'Segoe UI',sans-serif;
    }
    .login-wrapper {
      max-width:400px;
      margin:auto;
    }
    .brand-header {
      text-align:center;
      margin-bottom:20px;
    }
    .brand-header h2 {
      color:#fe9e43;
      font-weight:700;
    }
    .login-card {
      background:#ffffff;
      border-radius:18px;
      box-shadow:0 8px 25px rgba(0,0,0,0.08);
      padding:35px 30px;
    }
    .form-label {
      font-weight:500;
      color:#212428;
    }
    .form-control {
      border-radius:10px;
      padding:10px 12px;
    }
    .btn-login {
      background:#fe9e43;
      border:none;
      font-weight:600;
      border-radius:10px;
      transition:all .2s ease-in-out;
    }
    .btn-login:hover {
      background:#e88c2d;
      transform:scale(1.03);
      box-shadow:0 4px 12px rgba(0,0,0,0.15);
    }
    .footer-note {
      text-align:center;
      margin-top:20px;
      font-size:13px;
      color:#888;
    }
  </style>
</head>
<body class="d-flex align-items-center vh-100">

<div class="login-wrapper">
  <div class="brand-header">
    <h2>🔐 MITSDE Admin</h2>
    <p class="text-muted small">Secure access to your dashboard</p>
  </div>
  <div class="login-card">
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>
      <button type="submit" class="btn btn-login w-100 py-2">Login</button>
    </form>
  </div>
  <div class="footer-note">
    © <?= date('Y') ?> MITSDE Newsletter • Stay Secure
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
<?php if ($error): ?>
Toastify({
  text: "<?= htmlspecialchars($error) ?>",
  duration: 3000,
  gravity: "top",
  position: "right",
  backgroundColor: "#e63946",
  close: true
}).showToast();
<?php endif; ?>

<?php if ($success): ?>
Toastify({
  text: "<?= htmlspecialchars($success) ?>",
  duration: 2000,
  gravity: "top",
  position: "center",
  backgroundColor: "#0ec846ff",
  close: true
}).showToast();
<?php endif; ?>
</script>

</body>
</html>
