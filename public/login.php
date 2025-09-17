<?php
// public/login.php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$email || !$pass) {
        $error = "Please provide email and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user) {
            $error = "No account found with this email.";
        } else if (empty($user['password'])) {
            $error = "No password set for this account. Use Forgot Password.";
        } else if (!password_verify($pass, $user['password'])) {
            $error = "Invalid credentials.";
        } else if ((int)$user['status'] !== 1) {
            $error = "Your account is inactive.";
        } else {
            session_regenerate_id(true);
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_last_name']  = $user['last_name'];
            $_SESSION['user_name'] = trim($user['first_name'] . ' ' . $user['last_name']);
            $_SESSION['success'] = "Welcome back, " . htmlspecialchars($_SESSION['user_first_name']);
            header("Location: " . ($BASE_URL ?? '/') . "/public/index-final.php");
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login — WORKSMART</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../assets/css/login-page.css">
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png">
</head>
<body>

  <div class="login-card">
    <h3 class="mb-3 text-center">Login to Read Full Newsletters</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required 
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="forgot_password.php">Forgot password?</a>
      </div>

      <button class="btn btn-brand w-100 mb-3">Login</button>

      <div class="text-muted small text-center">
        Don't have an account? 
        <a href="#" data-bs-toggle="modal" data-bs-target="#subscribeModal" style="color:var(--brand1)">Subscribe</a>
      </div>
    </form>
  </div>

  <!-- Subscribe Modal -->
  <div class="modal fade" id="subscribeModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header">
          <h5 class="modal-title text-white">Subscribe</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="subscribeForm" action="<?= htmlspecialchars(($BASE_URL ?? '') . '/public/subscribe.php') ?>" method="post">
            <div class="mb-3"><input name="first_name" class="form-control" placeholder="First Name" required></div>
            <div class="mb-3"><input name="last_name" class="form-control" placeholder="Last Name" required></div>
            <div class="mb-3"><input name="email" type="email" placeholder="Email" class="form-control" required></div>
            <div class="mb-3"><input name="mobile" type="text" placeholder="Mobile" class="form-control" required></div>
            <div class="mb-3"><input name="linkedin_url" type="url" placeholder="LinkedIn Profile URL" class="form-control" required></div>
            <button type="submit" class="btn btn-brand w-100">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <?php if (!empty($_SESSION['success'])): ?>
    <script>
      Swal.fire({ icon: 'success', title: '<?= addslashes($_SESSION['success']) ?>', timer: 2500, showConfirmButton:false });
    </script>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <script>
      Swal.fire({ icon: 'error', title: '<?= addslashes($_SESSION['error']) ?>' });
    </script>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

</body>
</html>
