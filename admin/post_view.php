<?php
include "../config.php";

$id = intval($_GET['id']);

// ✅ Posts + Categories join
$query = "
  SELECT p.*, c.name AS category_name 
  FROM posts p
  LEFT JOIN categories c 
    ON p.category_id = c.id
  WHERE p.id = $id
";

$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($post['title']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/post_view.css">
</head>

<body class="container py-5">
  <h1 class="post-title"><?= htmlspecialchars($post['title']); ?></h1>

  <?php if (!empty($post['main_media'])) { ?>
    <div class="post-hero mb-4">
      <img src="../uploads/<?= htmlspecialchars($post['main_media']); ?>" 
           alt="<?= htmlspecialchars($post['title']); ?>" 
           class="img-fluid rounded shadow">
    </div>
  <?php } ?>

  <div class="post-header mb-4 shadow-sm p-3 rounded">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
      <div>
        <span class="badge bg-warning text-dark me-2">
          <i class="bi bi-folder2-open"></i> 
          <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized'); ?>
        </span>
        <span class="badge bg-info text-dark">
          <i class="bi bi-person-circle"></i>
          <?= htmlspecialchars($post['author_name'] ?? 'Admin'); ?>
        </span>
      </div>
      <small><i class="bi bi-calendar3"></i> <?= htmlspecialchars($post['post_date']); ?></small>
    </div>
    <h1><?= htmlspecialchars($post['title']); ?></h1>
  </div>

  <div class="post-meta mb-3">
    📅 <?= date("F d, Y", strtotime($post['created_at'] ?? "now")); ?> 
    | ✍️ Admin
  </div>

  <div class="post-content">
    <?= $post['description']; ?>
  </div>
</body>
</html>
