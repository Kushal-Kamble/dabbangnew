<?php
// includes/db.php include kare yaha
include '../config.php';

// Add Category
if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO categories (name, slug, description) VALUES ('$name', '$slug', '$description')";
    mysqli_query($conn, $query);
    header("Location: categories.php");
    exit;
}

// Update Category
if (isset($_POST['update_category'])) {
    $id   = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE categories SET name='$name', slug='$slug', description='$description' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: categories.php");
    exit;
}

// Delete Category
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: categories.php");
    exit;
}

// Fetch all categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php include 'sidebar.php'; ?> 
  <div class="content">

<div class="container mt-4">
  <h2 class="mb-4">Manage Categories</h2>

  <!-- Add Category Form -->
  <div class="card mb-4">
    <div class="card-header">Add New Category</div>
    <div class="card-body">
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
      </form>
    </div>
  </div>

  <!-- Category List -->
  <div class="card">
    <div class="card-header">All Categories</div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th width="20%">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($categories)) { ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['slug'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
              <!-- Edit Button trigger modal -->
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
              <a href="categories.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
            </td>
          </tr>

          <!-- Edit Modal -->
          <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="mb-3">
                      <label class="form-label">Category Name</label>
                      <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea name="description" class="form-control"><?= $row['description'] ?></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="update_category" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
