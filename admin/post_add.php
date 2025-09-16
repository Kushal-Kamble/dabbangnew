<?php
include "../config.php"; 
$message = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = intval($_POST['category_id']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $author_id = 1; // TODO: session se lena hai

    // Image Upload
    $main_media = "";
    if (isset($_FILES["main_media"]["name"]) && $_FILES["main_media"]["error"] == 0) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . "_" . basename($_FILES["main_media"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["main_media"]["tmp_name"], $target_file)) {
            $main_media = $filename;
        }
    }

    // ✅ Insert into posts (component_id removed)
    $sql = "INSERT INTO posts 
                (title, description, category_id, subcategory, main_media, author_id, status) 
            VALUES 
                ('$title', '$description', $category_id, '$subcategory', '$main_media', $author_id, '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Post added successfully!'); window.location='posts.php';</script>";
        exit;
    } else {
        $message = "<div class='alert alert-danger'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Add Post</title>
</head>
<body>
<?php include "sidebar.php"; ?> <!-- Sidebar Include -->

<div class="content">
<div class="container mt-4">
<div class="card shadow p-4">
    <h3 class="mb-3">➕ Add New Post</h3>
    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Subcategory</label>
            <input type="text" name="subcategory" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Main Image</label>
            <input type="file" name="main_media" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="editor" class="form-control" rows="6"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <!-- <option value="draft">Draft</option> -->
                <option value="published">Published</option>
            </select>
        </div>

        <button type="submit" class="btn text-white" style="background:#fd5402;"><i class="bi bi-bookmark-fill"></i> Save Post</button>
        <a href="posts.php" class="btn btn-secondary"><i class="bi bi-x-square-fill"></i> Cancel</a>
    </form>
</div>
</div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

<?php include "../inc/footer.php"; ?>
</body>
</html>
