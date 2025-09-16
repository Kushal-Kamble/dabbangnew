<?php
include "../config.php";
// include "../inc/header.php";

// Fetch posts with category + component
$sql = "SELECT p.*, c.name AS category_name, comp.title AS component_title
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN component_master comp ON p.component_id = comp.id
        ORDER BY p.id DESC";
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
    <?php include "sidebar.php"; ?> <!-- Sidebar Include -->

    <div class="content">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">📋 Posts List</h2>
            <a href="post_add.php" class="btn text-white" style="background:#fd5402;"><i class="bi bi-plus-circle-fill"></i>  Add New Post</a>
        </div>

        <table class="table table-striped table-bordered align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <!-- <th>Component</th> -->
                    <th>Image</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= htmlspecialchars($row['category_name']); ?></td>
                            <td><?= htmlspecialchars($row['subcategory']); ?></td>
                            <!-- <td>/<?= htmlspecialchars($row['component_title']); ?></td> -->
                            <td>
                                <?php if ($row['main_media']) { ?>
                                    <img src="../uploads/<?= $row['main_media']; ?>" width="80" class="rounded shadow-sm">
                                <?php } else { ?>
                                    <span class="text-muted">No Image</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'published') { ?>
                                    <span class="badge bg-success">Published</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="post_edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏Edit</a>
                                <a href="post_delete.php?id=<?= $row['id']; ?>"
                                    onclick="return confirm('Are you sure to delete this post?');"
                                    class="btn btn-sm btn-danger">🗑 Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No posts found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>

    <?php include "../inc/footer.php"; ?>

</body>

</html>