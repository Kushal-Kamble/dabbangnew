<?php
// admin/create_admin.php
session_start();
require_once __DIR__ . '/../config.php';

// ==== Check if logged in admin is authorized ====
// Optional: If only the first admin can create others, check their role or ID.
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm)) {
        $msg = "<div class='alert alert-danger'>⚠️ All required fields must be filled.</div>";
    } elseif ($password !== $confirm) {
        $msg = "<div class='alert alert-danger'>❌ Passwords do not match.</div>";
    } else {
        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM admins WHERE username=?");
        $check->bind_param('s', $username);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>❌ Username already exists.</div>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admins (username, full_name, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $full_name, $hash);
            if ($stmt->execute()) {
                $msg = "<div class='alert alert-success'>✅ New admin created successfully: <strong>$username</strong></div>";
            } else {
                $msg = "<div class='alert alert-danger'>❌ Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:500px;">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      Create New Admin
    </div>
    <div class="card-body">
      <?= $msg ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="full_name" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
          <input type="password" name="confirm_password" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="btn btn-success w-100">Create Admin</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
