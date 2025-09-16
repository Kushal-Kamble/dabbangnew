<?php
include "../config.php"; 

// Check if post_id is provided
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    // Delete post query
    $sql = "DELETE FROM posts WHERE id = $post_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: posts.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting post: " . $conn->error;
    }
} else {
    echo "Invalid Request!";
}
?>
