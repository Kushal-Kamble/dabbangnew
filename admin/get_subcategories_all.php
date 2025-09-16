<?php
// admin/get_subcategories_all.php
require_once "../config.php";

$cat_id = intval($_GET['cat_id'] ?? 0);
$subcats = [];

if ($cat_id > 0) {
    // Distinct subcategories from posts
    $sql = "SELECT subcategory, DATE(created_at) as created_date
            FROM posts
            WHERE category_id = ? AND subcategory<>'' 
            GROUP BY subcategory
            ORDER BY subcategory ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $today = date('Y-m-d');

    while ($row = $res->fetch_assoc()) {
        $subcatName = $row['subcategory'];
        $created    = $row['created_date'];
        $used       = 0;

        // check in single-newsletter table
        $escSub = $conn->real_escape_string($subcatName);
        $q1 = $conn->query("SELECT id FROM newsletter_master 
                            WHERE category_id={$cat_id} AND subcategory='{$escSub}' LIMIT 1");
        if ($q1 && $q1->num_rows > 0) {
            $used = 1;
        } else {
            // check in multi-newsletter JSON
            $likeCat = '"category_id":' . $cat_id;
            $likeSub = '"subcategory":"' . $conn->real_escape_string($subcatName) . '"';
            $q2 = $conn->query("SELECT id FROM newsletter_master 
                                WHERE multi_content LIKE '%{$likeCat}%' 
                                  AND multi_content LIKE '%{$likeSub}%' 
                                LIMIT 1");
            if ($q2 && $q2->num_rows > 0) {
                $used = 1;
            }
        }

        // ✅ Final rule: agar use ho gayi hai to "new" cancel ho jaye
        $is_new = ($created === $today) ? 1 : 0;
        if ($used == 1) {
            $is_new = 0;
        }

        $subcats[] = [
            'name'       => $subcatName,
            'is_used'    => $used,
            'created_at' => $created,
            'is_new'     => $is_new
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($subcats);
exit;
