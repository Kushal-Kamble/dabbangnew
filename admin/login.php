<?php
session_start();
require_once __DIR__ . '/../config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // ✅ full_name bhi select kiya
    $stmt = $conn->prepare("SELECT id, username, full_name, password FROM admins WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $db_username, $full_name, $hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $hash)) {
            // ✅ Sessions set
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $db_username;
            $_SESSION['admin_name'] = $full_name; // ✅ Yeh naam dashboard me use hoga

            $success = "Login successful! Redirecting...";

            echo "<script>
                    setTimeout(function(){
                        window.location.href = '" . $BASE_URL . "/admin/dashboard.php';
                    }, 1500);
                  </script>";
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    $stmt->close();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL . '/assets/css/styles.css') ?>">
<!-- Toastify CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style>
  body {
    background: #f5f7fb;
    font-family: 'Segoe UI', sans-serif;
  }
  .login-card {
    width: 380px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border: none;
  }
  .btn-primary {
    background-color: #fe9e43;
    border: none;
  }
  .btn-primary:hover {
    background-color: #e88c2d;
  }
  h4 {
    color: #212428;
    font-weight: 600;
  }
</style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card p-4 login-card">
  <h4 class="mb-3 text-center">🔐 Admin Login</h4>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input name="password" type="password" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Login</button>
  </form>
</div>

<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
<?php if ($error): ?>
Toastify({
  text: "<?= htmlspecialchars($error) ?>",
  duration: 3000,
  close: true,
  gravity: "top",
  position: "right",
  backgroundColor: "#e63946",
}).showToast();
<?php endif; ?>

<?php if ($success): ?>
Toastify({
  text: "<?= htmlspecialchars($success) ?>",
  duration: 2000,
  close: true,
  gravity: "top",
  position: "center",
  backgroundColor: "#0ec846ff",
}).showToast();
<?php endif; ?>
</script>

</body>
</html>
