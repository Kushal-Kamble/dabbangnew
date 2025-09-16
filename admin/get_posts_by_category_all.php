<?php
// admin/get_posts_by_category_all.php
require_once "../config.php";

$cat_id = intval($_GET['cat_id'] ?? 0);
$posts = [];

if ($cat_id > 0) {
    $sql = "SELECT id, title, DATE(post_date) as post_date 
            FROM posts 
            WHERE category_id = ? AND status = 'published'
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $today = date('Y-m-d');

    while ($row = $res->fetch_assoc()) {
        $pid = (int)$row['id'];
        $is_used = 0;

        // check if used in single-newsletter links (simple LIKE)
        $q1 = $conn->query("SELECT id FROM newsletter_master WHERE links LIKE '%\"post_id\":{$pid}%' LIMIT 1");
        if ($q1 && $q1->num_rows > 0) {
            $is_used = 1;
        } else {
            // check in multi-newsletter JSON (simple LIKE for post_id)
            $q2 = $conn->query("SELECT id FROM newsletter_master WHERE multi_content LIKE '%\"post_id\":{$pid}%' LIMIT 1");
            if ($q2 && $q2->num_rows > 0) {
                $is_used = 1;
            }
        }

        // 👇 Add these 2 new fields
        $is_new = ($row['post_date'] === $today) ? 1 : 0;

        $posts[] = [
            'id'        => $pid,
            'title'     => $row['title'],
            'created_at'=> $row['post_date'],  // JS expects created_at
            'is_new'    => $is_new,            // for 🆕 check
            'is_used'   => $is_used
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($posts);
exit;
