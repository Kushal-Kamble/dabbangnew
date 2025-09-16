<?php
require_once "../config.php";
include "../inc/header.php";

$id = $_GET['id'] ?? 0;
$cats = $conn->query("SELECT id,name FROM categories");

$stmt = $conn->prepare("SELECT * FROM component_master WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$component = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $subcategory = $_POST['subcategory'];
    $content_type = $_POST['content_type'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE component_master SET category_id=?, title=?, subcategory=?, content_type=?, content=? WHERE id=?");
    $stmt->bind_param("issssi", $category_id, $title, $subcategory, $content_type, $content, $id);

    if ($stmt->execute()) {
        header("Location: components.php?msg=Component Updated Successfully");
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
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <?php include "sidebar.php"; ?> 

    
<div class="content">

<div class="container mt-4">
    <h2>Edit Component</h2>
    <form method="post">
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <?php while($cat = $cats->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= $component['category_id']==$cat['id']?'selected':'' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($component['title']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Subcategory</label>
            <input type="text" name="subcategory" value="<?= htmlspecialchars($component['subcategory']) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Content Type</label>
            <select name="content_type" class="form-control">
                <?php foreach(['text','image','video','link','mixed'] as $type): ?>
                    <option value="<?= $type ?>" <?= $component['content_type']==$type?'selected':'' ?>><?= ucfirst($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="4"><?= htmlspecialchars($component['content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="components.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</div>
<?php include "../inc/footer.php"; ?>
    
</body>
</html>


