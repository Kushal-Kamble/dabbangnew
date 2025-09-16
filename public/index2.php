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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      
  <div id="postsContainer" class="row g-4"></div>
      
    </div>
  </section>



 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

  
});
</script>
</body>
</html>
