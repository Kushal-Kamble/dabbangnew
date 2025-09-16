<?php 
require_once "../config.php";
// include "../inc/header.php";

// Get categories
$cats = $conn->query("SELECT id, name FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $subcategory = $_POST['subcategory'];
    $content_type = $_POST['content_type'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO component_master (category_id, title, subcategory, content_type, content) VALUES (?,?,?,?,?)");
    $stmt->bind_param("issss", $category_id, $title, $subcategory, $content_type, $content);

    if ($stmt->execute()) {
        header("Location: components.php?msg=Component Added Successfully");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: ".$stmt->error."</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Component</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<?php include "sidebar.php"; ?>  <!-- Sidebar Include -->

<div class="content">
    <div class="container mt-4">
        <h2>Add Component</h2>
        <form method="post">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control form-select" required>
                    <option value="">Select Category</option>
                    <?php while($cat = $cats->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Subcategory</label>
                <input type="text" name="subcategory" class="form-control">
            </div>
            <div class="mb-3">
                <label>Content Type</label>
                <select name="content_type" class="form-control form-select">
                    <option value="text">Text</option>
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                    <option value="link">Link</option>
                    <option value="mixed">Mixed</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="components.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php include "../inc/footer.php"; ?>
</body>
</html>
