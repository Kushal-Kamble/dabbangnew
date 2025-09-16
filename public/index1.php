<?php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$latestPosts = $conn->query("
  SELECT p.id, p.title, p.description, p.main_media, p.post_date, c.name AS category_name
  FROM posts p
  LEFT JOIN categories c ON p.category_id = c.id
  ORDER BY p.post_date DESC, p.id DESC
  LIMIT 6
");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MITSDE — Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .post-card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff;
    }
    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    }
    .post-card img {
      height: 200px;
      object-fit: cover;
    }
    .badge-category {
      background-color: #212428;
      color: #fff;
      font-size: 12px;
      border-radius: 12px;
      padding: 4px 10px;
    }
    .badge-date {
      background-color: #28a745;
      color: #fff;
      font-size: 12px;
      border-radius: 12px;
      padding: 4px 10px;
    }
    .btn-read {
      background-color: #fe9e43;
      border: none;
      border-radius: 20px;
      padding: 6px 16px;
      color: #fff;
      font-size: 14px;
    }
    .btn-read:hover {
      background-color: #e88a33;
      color: #fff;
    }
    .badge-date {
  background-color: #28a745;
  color: #fff;
  font-size: 11px; /* smaller text */
  border-radius: 12px;
  padding: 4px 10px;
  opacity: 0.9; /* slightly lighter */
}

  </style>
</head>
<body class="bg-light">
  <?php include __DIR__ . '/../inc/header.php'; ?>

  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">📢 Latest Posts</h2>
      <div class="row g-4">
        <?php if ($latestPosts && $latestPosts->num_rows > 0): ?>
          <?php while ($post = $latestPosts->fetch_assoc()):
            $image = !empty($post['main_media'])
              ? "../uploads/" . htmlspecialchars($post['main_media'])
              : "https://via.placeholder.com/400x200?text=No+Image";
            $category = $post['category_name'] ?: "Uncategorized";
            // $formattedDate = date("M d, Y — h:i A", strtotime($post['post_date']));
            $formattedDate = date("M d, Y", strtotime($post['post_date']));

            $shortDesc = substr(strip_tags($post['description']), 0, 90) . '...';
          ?>
          <div class="col-md-4">
            <div class="post-card shadow-sm h-100 d-flex flex-column">
              <img src="<?= $image ?>" alt="Post Image" class="w-100">
              <div class="p-3 d-flex flex-column flex-grow-1">
                <h5 class="fw-bold"><?= htmlspecialchars($post['title']) ?></h5>
                <p class="text-muted small mb-2"><?= $shortDesc ?></p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="badge-category"><?= htmlspecialchars($category) ?></span>
                  <span class="badge-date"><?= $formattedDate ?></span>
                </div>
                <a href="post_view.php?id=<?= $post['id'] ?>" class="btn-read mt-auto text-decoration-none text-center">
                  <i class="bi bi-eye"></i> Read More
                </a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">No posts available</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
