<?php
// change_password.php
session_start();
require_once __DIR__ . '/../config.php';

// Check login
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_pass = $_POST['old_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($old_pass) || empty($new_pass) || empty($confirm)) {
        $msg = "<p style='color:red;'>⚠️ All fields are required.</p>";
    } elseif ($new_pass !== $confirm) {
        $msg = "<p style='color:red;'>❌ New passwords do not match.</p>";
    } else {
        // Fetch current admin
        $id = $_SESSION['admin_id'];
        $stmt = $conn->prepare("SELECT password FROM admins WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $hash = $stmt->get_result()->fetch_assoc()['password'];

        if (!password_verify($old_pass, $hash)) {
            $msg = "<p style='color:red;'>❌ Old password is incorrect.</p>";
        } else {
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE admins SET password=? WHERE id=?");
            $update->bind_param('si', $new_hash, $id);
            if ($update->execute()) {
                $msg = "<p style='color:green;'>✅ Password updated successfully.</p>";
            } else {
                $msg = "<p style='color:red;'>❌ Error updating password.</p>";
            }
            $update->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:500px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Change Password
        </div>
        <div class="card-body">
            <?= $msg ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Old Password</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-success w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
