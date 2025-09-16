<?php
include "../config.php";

$limit=6;
$page=max(1,intval($_GET['page']??1));
$offset=($page-1)*$limit;
$search=mysqli_real_escape_string($conn,$_GET['search']??'');
$category=intval($_GET['category']??0);

$where="WHERE 1=1";
if($search!==""){ $where.=" AND (p.title LIKE '%$search%' OR p.description LIKE '%$search%')"; }
if($category>0){ $where.=" AND p.category_id=$category"; }

$total=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as cnt FROM posts p $where"))['cnt'];
$totalPages=max(1,ceil($total/$limit));

$q=mysqli_query($conn,"
  SELECT p.*,c.name as category_name 
  FROM posts p LEFT JOIN categories c ON p.category_id=c.id 
  $where ORDER BY p.post_date DESC,p.id DESC LIMIT $limit OFFSET $offset
");

function timeAgo($dt){
  if(!$dt)return"";
  $t=time()-strtotime($dt);
  if($t<60)return $t." sec ago";
  $m=floor($t/60);if($m<60)return $m." min ago";
  $h=floor($t/3600);if($h<24)return $h." hr ago";
  $d=floor($t/86400);if($d<7)return $d." days ago";
  return date("M d, Y",strtotime($dt));
}

$out="";
if(mysqli_num_rows($q)){
  $first=true;
  while($r=mysqli_fetch_assoc($q)){
    $img=$r['main_media']?"../uploads/".htmlspecialchars($r['main_media']):"https://via.placeholder.com/400x250?text=No+Image";
    $title=htmlspecialchars($r['title']);
    $desc=substr(strip_tags($r['description']),0,120)."…";
    $cat=$r['category_name']?:'Uncategorized';
    $date=timeAgo($r['post_date']);
    
    // First post bigger (featured)
    if($first){
      $out.="
      <div class='col-12'>
        <div class='post-card d-flex flex-column flex-md-row'>
          <div class='col-md-6'>
            <img src='$img' class='post-img' alt='$title'>
          </div>
          <div class='post-body col-md-6'>
            <h4 class='post-title'>$title</h4>
            <div class='post-meta'><span class='badge bg-dark'>$cat</span> • $date</div>
            <p>$desc</p>
            <a href='post_view.php?id={$r['id']}' class='btn btn-custom btn-sm'>
              <i class='bi bi-eye'></i> Read More
            </a>
          </div>
        </div>
      </div>";
      $first=false;
    } else {
      $out.="
      <div class='col-12'>
        <div class='post-card d-flex flex-column flex-md-row'>
          <div class='col-md-4'>
            <img src='$img' class='post-img' alt='$title'>
          </div>
          <div class='post-body col-md-8'>
            <h5 class='post-title'>$title</h5>
            <div class='post-meta'><span class='badge bg-dark'>$cat</span> • $date</div>
            <p>$desc</p>
            <a href='post_view.php?id={$r['id']}' class='btn btn-custom btn-sm'>Read More</a>
          </div>
        </div>
      </div>";
    }
  }
}else{
  $out="<div class='col-12'><div class='alert alert-info text-center'>No posts found</div></div>";
}

$pagination="";
if($totalPages>1){
  for($i=1;$i<=$totalPages;$i++){
    $active=$i==$page?"active":"";
    $pagination.="<li class='page-item $active'><a class='page-link' data-page='$i'>$i</a></li>";
  }
}

echo json_encode(["posts"=>$out,"pagination"=>$pagination]);
?>
