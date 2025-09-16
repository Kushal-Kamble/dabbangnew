<?php 
include "../config.php";

$limit = 6; // posts per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;

$query = "FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";

// search condition
if (!empty($search)) {
    $query .= " AND (p.title LIKE '%$search%' OR p.description LIKE '%$search%')";
}

// category filter
if ($category > 0) {
    $query .= " AND p.category_id = $category";
}

// total rows
$totalRes = mysqli_query($conn, "SELECT COUNT(*) as total $query");
$totalRow = mysqli_fetch_assoc($totalRes);
$totalPosts = $totalRow['total'];
$totalPages = ceil($totalPosts / $limit);

// posts query
$result = mysqli_query($conn, "SELECT p.*, c.name as category_name $query ORDER BY p.post_date DESC, p.id DESC LIMIT $limit OFFSET $offset");

// 🔹 relative time function
function timeAgo($datetime) {
    if (!$datetime) return "";
    $time = strtotime($datetime);
    if (!$time) return "";

    $diff = time() - $time;

    if ($diff < 60) return $diff . " seconds ago";
    $minutes = floor($diff / 60);
    if ($minutes < 60) return $minutes . " minutes ago";
    $hours = floor($diff / 3600);
    if ($hours < 24) return $hours . " hours ago";
    $days = floor($diff / 86400);
    if ($days < 7) return $days . " days ago";
    $weeks = floor($diff / 604800);
    if ($weeks < 4) return $weeks . " weeks ago";
    $months = floor($diff / 2628000);
    if ($months < 12) return $months . " months ago";
    $years = floor($diff / 31536000);
    return $years . " years ago";
}

// build posts HTML
$output = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $image = !empty($row['main_media']) ? "../uploads/".$row['main_media'] : "https://via.placeholder.com/400x200?text=No+Image";
        $category = $row['category_name'] ?: "Uncategorized";

        // formatted date + relative time
        $formattedDate = !empty($row['post_date']) ? date("M d, Y", strtotime($row['post_date'])) : "";
        $dateAgo = !empty($row['post_date']) ? timeAgo($row['post_date']) : "";
        $dateDisplay = $formattedDate . " • " . $dateAgo;

        $output .= '
        <style>
        body{
            
          .custom-card {
            background-color: #f9fafb; /* हल्का grey */
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease-in-out;
          }
          .custom-card:hover {
            border-color: #000;
            box-shadow: 8px 10px 18px rgba(0,0,0,0.15);
            transform: translateY(-4px);
          }
            .btn-custom {
      background-color: #fbaf67;
      border: none;
      color: #fff;
      border-radius: 30px;
      padding: 6px 16px;
      font-size: 14px;
    }
    .btn-custom:hover {
      background-color: #e89b55;
      color: #fff;
    }
        </style>

        <div class="col-md-4 mb-4">
          <div class="card h-100 rounded-3 shadow-sm custom-card border-2">
            <img src="'.$image.'" class="card-img-top rounded-top border-2" style="height:200px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">'.htmlspecialchars($row['title']).'</h5>
              <p class="card-text text-muted" style="flex-grow:1;">'.substr(strip_tags($row['description']), 0, 100).'...</p>
              <div class="mb-2 d-flex justify-content-between align-items-center">
                <span class="badge bg-dark">'.$category.'</span>
                <span class="badge bg-success text-white">'.$dateDisplay.'</span>
              </div>
              <a href="post_view.php?id='.$row['id'].'" class="btn btn-custom  btn-sm mt-auto">
                <i class="bi bi-eye"></i> Read More
              </a>
            </div>
          </div>
        </div>';
    }
} else {
    $output = '<div class="col-12"><div class="alert alert-info text-center">No posts found</div></div>';
}

// pagination
$pagination = "";
if ($totalPages > 1) {
    for ($i=1; $i <= $totalPages; $i++) {
        $active = ($i == $page) ? "active" : "";
        $pagination .= '<li class="page-item '.$active.'"><a class="page-link" data-page="'.$i.'">'.$i.'</a></li>';
    }
}

echo json_encode(["posts" => $output, "pagination" => $pagination]);
?>
