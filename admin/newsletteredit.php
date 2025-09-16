<?php
// admin/newsletters.php
session_start();
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once "../config.php";

if (isset($_GET['del'])) {
  $id = (int)$_GET['del'];
  $conn->query("DELETE FROM newsletter_master WHERE id=$id");
  header("Location: newsletters.php?msg=deleted");
  exit;
}

$res = $conn->query("SELECT n.*, c.name AS category_name
                     FROM newsletter_master n
                     LEFT JOIN categories c ON n.category_id=c.id
                     ORDER BY n.id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Newsletters</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<?php include "../inc/header.php"; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">📬 Newsletters</h3>
    <a href="newsletter_add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Newsletter</a>
  </div>

  <?php if(!empty($_GET['msg']) && $_GET['msg']==='deleted'): ?>
    <div class="alert alert-success">Deleted.</div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th>Scheduled</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while($r=$res->fetch_assoc()): ?>
            <tr>
              <td><?= (int)$r['id'] ?></td>
              <td><?= htmlspecialchars($r['title']) ?></td>
              <td><?= htmlspecialchars($r['category_name'] ?? '-') ?></td>
              <td>
                <?php
                  $badge = 'secondary';
                  if ($r['sent_status']==='pending') $badge='warning';
                  if ($r['sent_status']==='sent') $badge='success';
                  if ($r['sent_status']==='failed') $badge='danger';
                ?>
                <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($r['sent_status']) ?></span>
              </td>
              <td><?= $r['scheduled_at'] ?: '-' ?></td>
              <td><?= $r['created_at'] ?></td>
              <td class="d-flex gap-2">
                <!-- Send button -->
                <?php if($r['sent_status']==='pending'): ?>
                  <a class="btn btn-sm btn-success" href="newsletter_send.php?id=<?= (int)$r['id'] ?>" 
                     onclick="return confirm('Send this newsletter now?');">
                    <i class="bi bi-send"></i>
                  </a>
                <?php endif; ?>

                <!-- 📝 Edit button -->
                <a class="btn btn-sm btn-outline-primary" href="newsletter_edit.php?id=<?= (int)$r['id'] ?>">
                  <i class="bi bi-pencil-square"></i>
                </a>

                <!-- Logs -->
                <a class="btn btn-sm btn-outline-secondary" href="newsletter_logs.php?id=<?= (int)$r['id'] ?>">
                  <i class="bi bi-clock-history"></i>
                </a>

                <!-- Delete -->
                <a class="btn btn-sm btn-outline-danger" href="?del=<?= (int)$r['id'] ?>" 
                   onclick="return confirm('Delete newsletter? Logs will remain.');">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
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
