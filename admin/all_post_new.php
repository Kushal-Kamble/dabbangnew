<?php
include "../config.php";

// total posts count (for "All")
$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM posts"))['cnt'];

// fetch categories
$categories = mysqli_query($conn,"
  SELECT c.id,c.name,COUNT(p.id) as total_posts 
  FROM categories c 
  LEFT JOIN posts p ON p.category_id=c.id 
  GROUP BY c.id,c.name 
  ORDER BY c.name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📑 All Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body { background:#f9f9fb; }
    .category-badge{
      cursor:pointer;background:#fff;border:1px solid #ddd;border-radius:25px;
      padding:8px 16px;margin:6px;display:inline-block;
      transition:all .25s;box-shadow:0 2px 5px rgba(0,0,0,.05);
    }
    .category-badge:hover,
    .category-badge.active{
      background:#fbaf67;color:#fff;border-color:#fbaf67;
      box-shadow:0 3px 8px rgba(0,0,0,.1);
    }
    #search{
      max-width:400px;margin:0 auto;border-radius:30px;padding-left:15px;
      box-shadow:0 2px 6px rgba(0,0,0,.08);
    }
    .post-card{
      background:#fff;border-radius:15px;overflow:hidden;
      box-shadow:0 3px 8px rgba(0,0,0,.1);transition:.2s;
    }
    .post-card:hover{transform:translateY(-4px);box-shadow:0 6px 16px rgba(0,0,0,.12);}
    .post-img{width:100%;height:180px;object-fit:cover;}
    .post-body{padding:15px;}
    .post-title{font-size:1.1rem;font-weight:600;margin-bottom:5px;}
    .post-meta{font-size:.85rem;color:#777;margin-bottom:8px;}
    .btn-custom{background:#fbaf67;color:#fff;border-radius:25px;padding:5px 15px;font-size:.9rem;}
    .btn-custom:hover{background:#e89b55;color:#fff;}

    
  </style>
</head>
<body>
<div class="container py-4">
  <h2 class="text-center mb-4">📑 All Posts</h2>

  <!-- Search -->
  <div class="text-center mb-3">
    <input type="text" id="search" class="form-control" placeholder="🔍 Search posts...">
  </div>

  <!-- Categories -->
  <div class="text-center mb-4">
    <span class="category-badge active" data-id="0">All (<?= $total_posts ?>)</span>
    <?php while($c=mysqli_fetch_assoc($categories)){ ?>
      <span class="category-badge" data-id="<?= $c['id'] ?>">
        <?= htmlspecialchars($c['name']) ?> (<?= $c['total_posts'] ?>)
      </span>
    <?php } ?>
  </div>

  <!-- Posts -->
  <div id="postsContainer" class="row gy-4"></div>

  <!-- Pagination -->
  <nav><ul id="pagination" class="pagination justify-content-center mt-4"></ul></nav>
</div>

<script>
$(function(){
  let currentCategory=0,typingTimer,delay=400;

  function loadPosts(page=1){
    $.get("fetch_posts_new.php",{
      search:$("#search").val(),
      category:currentCategory,
      page:page
    },function(data){
      let res=JSON.parse(data);
      $("#postsContainer").html(res.posts);
      $("#pagination").html(res.pagination);
    });
  }
  loadPosts();

  $("#search").on("keyup",function(){
    clearTimeout(typingTimer);
    typingTimer=setTimeout(()=>loadPosts(),delay);
  });

  $(document).on("click",".category-badge",function(){
    $(".category-badge").removeClass("active");
    $(this).addClass("active");
    currentCategory=$(this).data("id");
    loadPosts();
  });

  $(document).on("click",".page-link",function(){
    loadPosts($(this).data("page"));
  });
});
</script>
</body>
</html>
