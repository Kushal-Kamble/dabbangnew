<?php
include "../config.php";

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");
$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($post['title']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
   
    .post-hero {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 18px rgba(0,0,0,0.12);
    }
    .post-hero img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }
    .post-title {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
        text-transform: capitalize;
      color: #000;
    }
    .post-meta {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 1.5rem;
    }
    .post-content {
      background: #fff;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      line-height: 1.8;
      font-size: 1rem;
      color: #333;
    }
    .post-content h2, 
    .post-content h3 {
      margin-top: 1.8rem;
      margin-bottom: 1rem;
      font-weight: 600;
      color: #212428;
    }
    .post-content img {
      max-width: 100%;
      border-radius: 12px;
      margin: 20px 0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>


<body class="container py-5">
  <h1 class="post-title"><?= htmlspecialchars($post['title']); ?></h1>

  <?php if (!empty($post['main_media'])) { ?>
    <div class="post-hero mb-4">
      <img src="../uploads/<?= htmlspecialchars($post['main_media']); ?>" alt="Main Image">
    </div>
  <?php } ?>

  <div class="post-header mb-4 shadow-sm">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                <div>
                    <span class="badge bg-warning text-dark me-2">
                        <i class="bi bi-folder2-open"></i> 
                        <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?>
                    </span>
                    <span class="badge bg-info text-dark">
                        <i class="bi bi-person-circle"></i>
                        <?= htmlspecialchars($post['author_name'] ?? 'Admin') ?>
                    </span>
                </div>
                <small><i class="bi bi-calendar3"></i> <?= htmlspecialchars($post['post_date']) ?></small>
            </div>
            <h1><?= htmlspecialchars($post['title']) ?></h1>
        </div>

  
  <div class="post-meta">
    📅 <?= date("F d, Y", strtotime($post['created_at'] ?? "now")); ?> 
    | ✍️ Admin
  </div>

  <div class="post-content">
      <?= $post['description']; ?>
  </div>

</body>
</html>
