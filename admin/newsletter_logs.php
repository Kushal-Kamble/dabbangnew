<?php
// admin/newsletter_logs.php
session_start();
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once "../config.php";

if (empty($_GET['id'])) { die("Invalid id"); }
$id = (int)$_GET['id'];

$nl = $conn->query("SELECT * FROM newsletter_master WHERE id=$id")->fetch_assoc();
$logs = $conn->query("SELECT * FROM newsletter_logs WHERE newsletter_id=$id ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Newsletter Logs</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php include "../inc/header.php"; ?>
<div class="container py-4">
  <h4 class="mb-3">Logs — <?= htmlspecialchars($nl['title'] ?? 'Newsletter #'.$id) ?></h4>
  <a class="btn btn-outline-secondary mb-3" href="newsletters.php">← Back</a>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-striped">
          <thead class="table-dark">
            <tr><th>ID</th><th>Email</th><th>Status</th><th>Error</th><th>Sent At</th></tr>
          </thead>
          <tbody>
            <?php while($r=$logs->fetch_assoc()): ?>
              <tr>
                <td><?= (int)$r['id'] ?></td>
                <td><?= htmlspecialchars($r['subscriber_email']) ?></td>
                <td><span class="badge bg-<?= $r['status']==='sent'?'success':'danger' ?>"><?= $r['status'] ?></span></td>
                <td><?= htmlspecialchars($r['error_msg'] ?? '') ?></td>
                <td><?= $r['sent_at'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include "../inc/footer.php"; ?>
</body>
</html>
