<?php
include "../config.php";

// Total posts for "All"
$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM posts"))['cnt'];

// Fetch categories with post count
$categories = mysqli_query($conn, "
  SELECT c.id, c.name, COUNT(p.id) as total_posts 
  FROM categories c 
  LEFT JOIN posts p ON p.category_id = c.id 
  GROUP BY c.id, c.name 
  ORDER BY c.name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Latest Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .category-badge {
      display:inline-block;
      padding:6px 12px;
      background:#f1f1f1;
      border-radius:20px;
      margin:4px;
      cursor:pointer;
      transition:0.3s;
    }
    .category-badge.active {
      background:#fe9e43;
      color:#fff;
      font-weight:bold;
    }
    .category-badge:hover { background:#fe9e43; color:#fff; }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="text-center mb-4">📑 Latest Posts</h1>

    <!-- Search -->
    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <input type="text" id="search" class="form-control" placeholder="🔍 Search posts...">
      </div>
    </div>

    <!-- Categories -->
    <div class="text-center mb-4">
      <span class="category-badge active" data-id="0">All (<?= $total_posts; ?>)</span>
      <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
        <span class="category-badge" data-id="<?= $cat['id']; ?>">
          <?= htmlspecialchars($cat['name']); ?> (<?= $cat['total_posts']; ?>)
        </span>
      <?php } ?>
    </div>

    <!-- Posts Container -->
    <div id="postsContainer" class="row g-4"></div>

    <!-- Pagination -->
    <nav>
      <ul id="pagination" class="pagination justify-content-center mt-4"></ul>
    </nav>
  </div>

<script>
$(document).ready(function(){
  let currentCategory = 0;
  let typingTimer;
  const typingDelay = 400;

  function loadPosts(page=1){
    let search = $("#search").val();
    $.ajax({
      url: "../admin/fetch_posts.php",
      method: "GET",
      data: { search: search, category: currentCategory, page: page },
      success: function(data){
        const res = JSON.parse(data);
        $("#postsContainer").html(res.posts);
        $("#pagination").html(res.pagination);
      }
    });
  }

  // Initial load
  loadPosts();

  // Debounced search
  $("#search").on("keyup", function(){
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function(){
      loadPosts();
    }, typingDelay);
  });

  // Category filter
  $(document).on("click", ".category-badge", function(){
    $(".category-badge").removeClass("active");
    $(this).addClass("active");
    currentCategory = $(this).data("id");
    loadPosts();
  });

  // Pagination click
  $(document).on("click", ".page-link", function(){
    const page = $(this).data("page");
    loadPosts(page);
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });
});
</script>
</body>
</html>
