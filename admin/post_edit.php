<?php
include "../config.php"; // DB connection

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid Post ID</div>";
    exit;
}

$post_id = intval($_GET['id']);

// Fetch existing post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    echo "<div class='alert alert-danger'>Post not found!</div>";
    exit;
}

// Update Post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = intval($_POST['category_id']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $main_media = $post['main_media']; // default old image

    // Handle Image Upload
    if (isset($_FILES['main_media']['name']) && $_FILES['main_media']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $filename = time() . "_" . basename($_FILES['main_media']['name']);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES['main_media']['tmp_name'], $target_file)) {
            $main_media = $filename;
            // Optional: delete old image if exists
            if (!empty($post['main_media']) && file_exists($target_dir . $post['main_media'])) {
                unlink($target_dir . $post['main_media']);
            }
        }
    }

    $sql = "UPDATE posts 
            SET title=?, category_id=?, subcategory=?, description=?, status=?, main_media=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $title, $category_id, $subcategory, $description, $status, $main_media, $post_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Post updated successfully!'); window.location='posts.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Error: " . $stmt->error . "</div>";
    }
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="all_post.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow p-4">
        <h3 class="mb-3">✏️ Edit Post</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $row['id']; ?>" <?= ($row['id'] == $post['category_id']) ? 'selected' : ''; ?>>
                            <?= $row['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Subcategory</label>
                <input type="text" name="subcategory" class="form-control" value="<?= htmlspecialchars($post['subcategory']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <?php if (!empty($post['main_media'])) { ?>
                    <img src="../uploads/<?= htmlspecialchars($post['main_media']); ?>" alt="Current Image" class="img-thumbnail mb-2" style="max-height:150px;">
                <?php } else { ?>
                    <p class="text-muted">No image uploaded</p>
                <?php } ?>
                <input type="file" name="main_media" class="form-control mt-2">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" id="editor" class="form-control" rows="6"><?= htmlspecialchars($post['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="published" <?= ($post['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?= ($post['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>

            <button type="submit" class="btn text-white" style="background:#fd5402;">
                <i class="bi bi-check-circle-fill"></i> Update Post
            </button>
            <a href="posts.php" class="btn btn-secondary">
                <i class="bi bi-x-square-fill"></i> Cancel
            </a>
        </form>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script> CKEDITOR.replace('editor'); </script>
</body>
</html>
