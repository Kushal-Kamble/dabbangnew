<?php
// admin/subscribers.php
session_start();
if (empty($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once "../config.php";

$alert = "";
$msg   = "";

// ✅ Add Subscriber form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subscriber'])) {
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  if (empty($email)) {
    $msg = "<div class='alert alert-danger'>⚠️ Email is required.</div>";
  } else {
    $check = $conn->prepare("SELECT id FROM subscribers WHERE email=?");
    $check->bind_param('s', $email);
    $check->execute(); $check->store_result();
    if ($check->num_rows > 0) {
      $msg = "<div class='alert alert-warning'>❗ Email already exists.</div>";
    } else {
      $stmt = $conn->prepare("INSERT INTO subscribers (name,email,status) VALUES (?,?,1)");
      $stmt->bind_param('ss', $name, $email);
      if ($stmt->execute()) {
        $alert = "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({title:'✅ Thank You!',text:'Subscriber added successfully.',icon:'success',confirmButtonColor:'#f89852'});
          });
        </script>";
      } else {
        $msg = "<div class='alert alert-danger'>❌ Error: ".$stmt->error."</div>";
      }
      $stmt->close();
    }
    $check->close();
  }
}

// ✅ Toggle status
if (isset($_GET['toggle'])) {
  $id = (int)$_GET['toggle'];
  $conn->query("UPDATE subscribers SET status = IF(status=1,0,1) WHERE id=$id");
  header("Location: subscribers.php"); exit;
}

// ✅ Delete subscriber
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM subscribers WHERE id=$id");
  header("Location: subscribers.php"); exit;
}

// Fetch subscribers
$subs = $conn->query("SELECT * FROM subscribers ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Subscribers</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmDelete(id){
      Swal.fire({
        title:'Are you sure?',
        text:'This subscriber will be permanently deleted!',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#d33',
        cancelButtonColor:'#3085d6',
        confirmButtonText:'Yes, delete it!'
      }).then((result)=>{
        if(result.isConfirmed){ window.location='subscribers.php?delete='+id; }
      });
    }
  </script>
</head>
<body>
<?php include 'sidebar.php'; ?> 
<div class="content">
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">👥 Subscribers</h3>
    <a href="subscribers_export.php" class="btn text-white" style="background:linear-gradient(90deg,#f5945c,#ff9f43);">
      <i class="bi bi-filetype-csv"></i> Export CSV
    </a>
  </div>

  <?= $msg ?>

  <!-- ✅ Add Subscriber Form -->
  <div class="card shadow-sm mb-4">
    <div class="card-header text-white" style="background:linear-gradient(90deg,#f5945c,#ff9f43);">Add New Subscriber</div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="add_subscriber" value="1">
        <div class="row g-3">
          <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
          </div>
          <div class="col-md-4">
            <input type="email" name="email" class="form-control" placeholder="Enter Your Email *" required>
          </div>
          <div class="col-md-4 d-grid">
            <button class="btn btn-success" type="submit">
              <i class="bi bi-person-plus"></i> Add Subscriber
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- ✅ Subscribers Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($s=$subs->fetch_assoc()): ?>
              <tr>
                <td><?= (int)$s['id'] ?></td>
                <td><?= htmlspecialchars($s['name'] ?? '') ?></td>
                <td><?= htmlspecialchars($s['email']) ?></td>
                <td>
                  <span class="badge bg-<?= $s['status']?'success':'secondary' ?>">
                    <?= $s['status'] ? 'Active' : 'Inactive' ?>
                  </span>
                </td>
                <td><?= $s['created_at'] ?></td>
                <td>
                  <a class="btn btn-sm btn-warning" 
                     href="?toggle=<?= (int)$s['id'] ?>"
                     onclick="return confirm('Toggle active/inactive?');">
                    <?= $s['status'] ? 'Unsubscribe' : 'Activate' ?>
                  </a>
                  <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= (int)$s['id'] ?>)">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
</div>
<?php include "../inc/footer.php"; ?>
<?= $alert ?>
</body>
</html>
