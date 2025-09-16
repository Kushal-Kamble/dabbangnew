<?php  
// dashboard.php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config.php';

// Quick stats
$stats = [];

// Subscribers
$res = $conn->query("SELECT COUNT(*) AS total,
    SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) AS active 
    FROM subscribers");
$stats['subscribers'] = $res->fetch_assoc();

// Posts
$res = $conn->query("SELECT COUNT(*) AS total FROM posts");
$stats['posts'] = $res->fetch_assoc();

// Components
$res = $conn->query("SELECT COUNT(*) AS total FROM component_master");
$stats['components'] = $res->fetch_assoc();

// Newsletters
$res = $conn->query("SELECT COUNT(*) AS total FROM newsletter_master");
$stats['newsletters'] = $res->fetch_assoc();

// Last 5 Posts
$latest_posts = $conn->query("SELECT id, title, post_date FROM posts ORDER BY post_date DESC LIMIT 7");

// Last 5 Newsletters
$latest_newsletters = $conn->query("SELECT id, title, created_at FROM newsletter_master ORDER BY created_at DESC LIMIT 7");

// Subscribers growth (last 6 months)
$subscribers_growth = [];
$res = $conn->query("
    SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS count
    FROM subscribers
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)
");
while ($row = $res->fetch_assoc()) {
    $subscribers_growth[$row['month']] = $row['count'];
}

// Posts per month (last 6 months)
$posts_growth = [];
$res = $conn->query("
    SELECT DATE_FORMAT(post_date, '%b') AS month, COUNT(*) AS count
    FROM posts
    WHERE post_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY YEAR(post_date), MONTH(post_date)
    ORDER BY YEAR(post_date), MONTH(post_date)
");
while ($row = $res->fetch_assoc()) {
    $posts_growth[$row['month']] = $row['count'];
}

// Newsletters per month (last 6 months)
$newsletters_growth = [];
$res = $conn->query("
    SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS count
    FROM newsletter_master
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)
");
while ($row = $res->fetch_assoc()) {
    $newsletters_growth[$row['month']] = $row['count'];
}

// Toastify flag
$show_welcome = false;
if (!empty($_SESSION['show_welcome'])) {
    $show_welcome = true;
    unset($_SESSION['show_welcome']); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?> 

<div class="content">

    <!-- Stats -->
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-subscribers shadow-sm text-center p-3">
                <div class="stat-icon bg-white text-dark"><i class="bi bi-people-fill"></i></div>
                <h6>Total Subscribers</h6>
                <h2><?= $stats['subscribers']['total'] ?? 0 ?></h2>
                <!-- <small>Active:  <?= $stats['subscribers']['active'] ?? 0 ?></small> -->
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-posts shadow-sm text-center p-3">
                <div class="stat-icon bg-white text-dark"><i class="bi bi-file-earmark-text-fill"></i></div>
                <h6>Total Posts</h6>
                <h2><?= $stats['posts']['total'] ?? 0 ?></h2>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-components shadow-sm text-center p-3">
                <div class="stat-icon bg-white text-dark"><i class="bi bi-box-seam-fill"></i></div>
                <h6>Total Components</h6>
                <h2><?= $stats['components']['total'] ?? 0 ?></h2>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-newsletters shadow-sm text-center p-3">
                <div class="stat-icon bg-white text-dark"><i class="bi bi-envelope-paper-fill"></i></div>
                <h6>Total Newsletters</h6>
                <h2><?= $stats['newsletters']['total'] ?? 0 ?></h2>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>📈 Subscribers Growth </h5>
                <canvas id="subscribersChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>📊 Posts Per Month </h5>
                <canvas id="postsChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>📩 Newsletters Per Month </h5>
                <canvas id="newslettersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest posts & newsletters -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h4 class="mb-3">📝 Latest Posts</h4>
            <ul class="list-group shadow-sm rounded-3">
                <?php while($row = $latest_posts->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="post_view.php?id=<?= $row['id'] ?>" class="text-decoration-none">
                            <?= htmlspecialchars($row['title']) ?>
                        </a>
                        <span class="badge bg-light text-dark"><?= $row['post_date'] ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <h4 class="mb-3">📧 Latest Newsletters</h4>
            <ul class="list-group shadow-sm rounded-3">
                <?php while($row = $latest_newsletters->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="newsletter_master.php?id=<?= $row['id'] ?>" class="text-decoration-none">
                            <?= htmlspecialchars($row['title']) ?>
                        </a>
                        <span class="badge bg-light text-dark"><?= $row['created_at'] ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
<?php if ($show_welcome): ?>
Toastify({
  text: "👋 Welcome back, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>!",
  duration: 3000,
  gravity: "top",
  position: "center",
  backgroundColor: "#15bb0fff",
  close: true
}).showToast();
<?php endif; ?>

// Chart.js data
const subscriberLabels = <?= json_encode(array_keys($subscribers_growth)) ?>;
const subscriberData = <?= json_encode(array_values($subscribers_growth)) ?>;
const postLabels = <?= json_encode(array_keys($posts_growth)) ?>;
const postData = <?= json_encode(array_values($posts_growth)) ?>;
const newsletterLabels = <?= json_encode(array_keys($newsletters_growth)) ?>;
const newsletterData = <?= json_encode(array_values($newsletters_growth)) ?>;

// Subscribers Chart
new Chart(document.getElementById('subscribersChart'), {
    type: 'line',
    data: {
        labels: subscriberLabels,
        datasets: [{
            label: "Subscribers",
            data: subscriberData,
            borderColor: "#f5945c",
            backgroundColor: "rgba(245,148,92,0.2)",
            fill: true,
            tension: 0.4
        }]
    }
});

// Posts Chart
new Chart(document.getElementById('postsChart'), {
    type: 'bar',
    data: {
        labels: postLabels,
        datasets: [{
            label: "Posts",
            data: postData,
            backgroundColor: "#17a2b8"
        }]
    }
});

// Newsletters Chart
new Chart(document.getElementById('newslettersChart'), {
    type: 'bar',
    data: {
        labels: newsletterLabels,
        datasets: [{
            label: "Newsletters",
            data: newsletterData,
            backgroundColor: "#0d6efd"
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
</body>
</html>
