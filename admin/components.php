<?php
require_once "../config.php";
include "sidebar.php";

// Fetch components with category
$sql = "SELECT c.*, cat.name AS category_name 
        FROM component_master c 
        JOIN categories cat ON c.category_id = cat.id 
        ORDER BY c.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <title>Document</title>
</head>

<body>
    <?php // include '../inc/header.php'; ?> 

    <div class="content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-3">
                <h2>Component Master</h2>
                <a href="component_add.php" class="btn btn-primary">+ Add Component</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Subcategory</th>
                        <th>Type</th>
                        <th>Used</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['subcategory']) ?></td>
                            <td><?= htmlspecialchars($row['content_type']) ?></td>
                            <td>
                                <?php if ($row['used_in'] == 1): ?>
                                    <span class="badge bg-success">Used</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not Used</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="component_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="component_delete.php?id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure to delete this component?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        <?php if (isset($_GET['msg'])): ?>
            Toastify({
                text: "<?= htmlspecialchars($_GET['msg']) ?>",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "green"
            }).showToast();
        <?php endif; ?>
    </script>
    <?php include "../inc/footer.php"; ?>

</body>

</html>