<?php
// admin/newsletter_edit.php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once "../config.php";

// Agar id missing hai
if (empty($_GET['id'])) {
    die("Invalid newsletter ID");
}
$id = (int)$_GET['id'];

// Agar form submit hua hai (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "UPDATE newsletter_master SET title='$title', category='$category', content='$content' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: newsletters.php?msg=updated");
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Data fetch
$sql = "SELECT * FROM newsletter_master WHERE id=$id LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    die("Newsletter not found");
}
$newsletter = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4">✏️ Edit Newsletter</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($newsletter['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($newsletter['category']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="8"><?= htmlspecialchars($newsletter['content']) ?></textarea>
                <script>
                    CKEDITOR.replace('content');
                </script>
            </div>

            <button type="submit" class="btn btn-primary">💾 Update</button>
            <a href="newsletters.php" class="btn btn-secondary">⬅ Back</a>
        </form>
    </div>
</div>
</body>
</html>
