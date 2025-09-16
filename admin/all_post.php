<?php   
include "../config.php";

// total posts count (for "All")
$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM posts"))['cnt'];

// fetch categories with post count
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
  <title>📑 All Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="all_post.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<?php //include "../inc/header.php"; ?>

<body>
        <div class="content">

<div class="container py-4">
  <h2 class="mb-4 text-center">📑 All Posts</h2>

  <!-- Search -->
  <div class="row mb-3">
    <div class="col-12 text-center">
      <input type="text" id="search" class="form-control" placeholder="🔍 Search posts...">
    </div>
  </div>

  <!-- Category Filters -->
  <div class="mb-4 text-center">
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
</div>
<script>
$(document).ready(function(){
    let currentCategory = 0;
    let typingTimer;
    const typingDelay = 400; // 0.4 sec delay for debounce

    function loadPosts(page = 1){
        let search = $("#search").val();
        $.ajax({
            url: "fetch_posts.php",
            method: "GET",
            data: { search: search, category: currentCategory, page: page },
            success: function(data){
                let res = JSON.parse(data);
                $("#postsContainer").html(res.posts);
                $("#pagination").html(res.pagination);
            }
        });
    }

    // initial load
    loadPosts();

    // search real-time with debounce
    $("#search").on("keyup", function(){
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function(){
            loadPosts();
        }, typingDelay);
    });

    // category click
    $(document).on("click", ".category-badge", function(){
        $(".category-badge").removeClass("active");
        $(this).addClass("active");
        currentCategory = $(this).data("id");
        loadPosts();
    });

    // pagination click
    $(document).on("click", ".page-link", function(){
        let page = $(this).data("page");
        loadPosts(page);
    });
});
</script>

</body>
</html>
