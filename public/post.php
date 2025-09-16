<?php
// public/post.php
require_once "../config.php";
include "../inc/header.php";

if (empty($_GET['id'])) {
    echo "<div class='container py-4'><div class='alert alert-danger'>Invalid post id</div></div>";
    include "../inc/footer.php";
    exit;
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT p.*, c.name AS category_name, a.username AS author_name
                        FROM posts p
                        LEFT JOIN categories c ON p.category_id=c.id
                        LEFT JOIN admins a ON p.author_id=a.id
                        WHERE p.id=? AND p.status='published'");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title><?= $post ? htmlspecialchars($post['title']) : 'Post' ?></title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-header {
            background: linear-gradient(135deg, #212529, #343a40, #495057);
            color: #fff;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .post-header h1 {
            font-weight: 700;
            font-size: 2rem;
        }
        .post-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #212529;
        }
        .post-meta small {
            font-size: 0.9rem;
        }
        .post-img {
            max-height: 350px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <?php if (!$post): ?>
        <div class="alert alert-warning shadow-sm">🚫 Post not found or not published.</div>
    <?php else: ?>
        <!-- Header Section -->
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

        <!-- Post Card -->
        <article class="card shadow-sm border-0">
            <?php if (!empty($post['main_media'])): ?>
                <img src="<?= htmlspecialchars('../uploads/' . $post['main_media']) ?>" 
                     alt="Post Image" class="post-img rounded-top">
            <?php endif; ?>

            <div class="card-body">
                <div class="post-body mb-3">
                    <?= $post['description'] ?>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center post-meta text-muted">
                    <small>
                        <i class="bi bi-person-check"></i> Posted by 
                        <strong><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></strong>
                    </small>
                    <a href="index.php" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </article>
    <?php endif; ?>
</div>

<?php include "../inc/footer.php"; ?>
    
</body>
</html>
