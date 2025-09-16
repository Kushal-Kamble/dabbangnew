<?php
// DB connect
require_once "../config.php";

// Check id from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request!");
}

$id = intval($_GET['id']);

// Fetch newsletter data
$stmt = $conn->prepare("SELECT * FROM newsletter_master WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Newsletter not found!");
}

$newsletter = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($newsletter['title']); ?> | Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background:#f5f7fb; font-family: "Segoe UI", sans-serif; }
    .card { border-radius: 18px; box-shadow:0 4px 14px rgba(0,0,0,0.08); }
    .newsletter-header {
        background: linear-gradient(90deg, #007bff, #00bcd4);
        color: #fff; 
        padding: 1.5rem; 
        border-radius: 18px 18px 0 0;
    }
    .newsletter-header h2 { font-weight: 700; margin: 0; }
    .newsletter-meta span { margin-right: 1rem; font-size: 0.9rem; }
    .newsletter-content { line-height: 1.7; font-size: 1.05rem; }
    .newsletter-media img { max-width: 100%; border-radius: 12px; margin: 20px 0; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
    .newsletter-media iframe { width: 100%; height: 380px; margin: 20px 0; border-radius: 12px; }
    .links-box { background:#f8f9fa; padding:15px; border-radius:10px; font-size:0.95rem; }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="dashboard.php" class="btn btn-outline-primary mb-3">
    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>

  <div class="card">
    <!-- Header -->
    <div class="newsletter-header">
      <h2><?= htmlspecialchars($newsletter['title']); ?></h2>
      <div class="newsletter-meta mt-2">
        <span><i class="bi bi-folder2-open"></i> Category ID: <?= htmlspecialchars($newsletter['category_id']); ?></span>
        <span><i class="bi bi-tags"></i> Subcategory: <?= htmlspecialchars($newsletter['subcategory']); ?></span>
        <span><i class="bi bi-calendar3"></i> <?= htmlspecialchars($newsletter['created_at']); ?></span>
      </div>
    </div>

    <!-- Body -->
    <div class="card-body">
      <div class="newsletter-content mb-4">
        <?= $newsletter['editor_content']; // CKEditor ka HTML ?>
      </div>

      <!-- Media Section -->
      <div class="newsletter-media">
        <?php if (!empty($newsletter['image'])): ?>
          <img src="<?= htmlspecialchars($newsletter['image']); ?>" alt="Newsletter Image">
        <?php endif; ?>

        <?php if (!empty($newsletter['video'])): ?>
          <iframe src="<?= htmlspecialchars($newsletter['video']); ?>" frameborder="0" allowfullscreen></iframe>
        <?php endif; ?>
      </div>

      <!-- Links -->
      <?php if (!empty($newsletter['links'])): ?>
        <hr>
        <h5 class="mb-2"><i class="bi bi-link-45deg"></i> Related Links</h5>
        <div class="links-box">
          <?= nl2br(htmlspecialchars($newsletter['links'])); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
