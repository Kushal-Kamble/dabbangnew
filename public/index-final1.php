

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
  <link rel="icon" type="image/png" href="../assets/favicon-mit.ico" />
  <title>MITSDE — Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  


  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL . '/assets/css/styles.css') ?>">
</head>

<body>
  <?php include __DIR__ . '/../inc/header.php'; ?>

  <section class="hero bg-light">
    <div class="container">
      <h1 class="display-5 fw-bold">Weekly tech & AI updates</h1>
      <p class="lead">Curated AI tools, short reads, and product updates.</p>
      <div class="mt-3">
        <button class="btn btn-primary btn-lg me-2" data-bs-toggle="modal" data-bs-target="#aiToolsModal">New AI Tools — This Week</button>

      </div>
    </div>
  </section>

  <section class="py-5 bg-light">

    <div class="container">
      <div class="row g-4">

        <!-- Main Content -->
        <div class="col-lg-8">
          <div class="card p-4 shadow-lg rounded-4 newsletter-preview hover-shadow">
            <h3 class="fw-bold mb-3">This Week’s Insight</h3>
            <p>Short explainer and why it's useful.</p>
            <img src="../assets/ChatGPT.png" class="img-fluid rounded-3 mb-3 shadow-sm  banner" alt="banner">
            <a href="#" class="btn btn-primary btn-gradient shadow-sm hover-scale">Read Full Story</a>
          </div>


        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <div class="card p-3 shadow-sm rounded-4 hover-shadow mb-3">
            <h5 class="fw-bold">Why subscribe?</h5>
            <p class="small text-muted">Short, practical, curated. No spam.</p>
            <button class="btn btn-primary w-100 btn-gradient shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#subscribeModal">
              Subscribe — Free
            </button>
          </div>

          <div class="card p-3 shadow-sm rounded-4 hover-shadow">
            <!-- <h6 class="fw-bold">Newsletter Preview</h6> -->
            <!-- <p class="small text-muted">Image, short text and CTA</p> -->
            <img src="../assets/newsletter.png" class="img-fluid rounded-3 shadow-sm" alt="preview">
          </div>
        </div>

      </div>
    </div>
  </section>

   <section class="py-5">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">📢 Latest Posts</h2>
      <div class="row g-4">
        <?php if ($latestPosts && $latestPosts->num_rows > 0): ?>
          <?php while ($post = $latestPosts->fetch_assoc()):
            $image = !empty($post['main_media'])
              ? "../uploads/" . htmlspecialchars($post['main_media'])
              : "https://via.placeholder.com/400x200?text=No+Image";
            $category = $post['category_name'] ?: "Uncategorized";
            // $formattedDate = date("M d, Y — h:i A", strtotime($post['post_date']));
            $formattedDate = date("M d, Y", strtotime($post['post_date']));

            $shortDesc = substr(strip_tags($post['description']), 0, 90) . '...';
          ?>
          <div class="col-md-4">
            <div class="post-card shadow-sm h-100 d-flex flex-column">
              <img src="<?= $image ?>" alt="Post Image" class="w-100">
              <div class="p-3 d-flex flex-column flex-grow-1">
                <h5 class="fw-bold"><?= htmlspecialchars($post['title']) ?></h5>
                <p class="text-muted small mb-2"><?= $shortDesc ?></p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="badge-category"><?= htmlspecialchars($category) ?></span>
                  <span class="badge-date"><?= $formattedDate ?></span>
                </div>
                <a href="post_view.php?id=<?= $post['id'] ?>" class="btn-read mt-auto text-decoration-none text-center">
                  <i class="bi bi-eye"></i> Read More
                </a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">No posts available</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>


  <?php include __DIR__ . '/../inc/footer.php'; ?>

  <!-- Subscribe Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 rounded-3 shadow">
      <div class="modal-header" style="background:var(--brand1)">
        <h5 class="modal-title text-white">Subscribe</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="subscribeForm" action="<?= htmlspecialchars($BASE_URL . '/public/subscribe.php') ?>" method="post">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" required class="form-control" />
          </div>
          <button type="submit" class="btn btn-primary w-100">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</div>


  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- ✅ SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 5 sec baad modal open hoga
    setTimeout(function() {
      var subscribeModal = new bootstrap.Modal(document.getElementById('subscribeModal'));
      subscribeModal.show();
    }, 5000); 

    // ✅ Form submit event
    document.getElementById("subscribeForm").addEventListener("submit", function(e) {
      e.preventDefault(); // form ko manually handle karenge

      if (this.checkValidity()) { 
        // Agar form valid hai
        var subscribeModal = bootstrap.Modal.getInstance(document.getElementById('subscribeModal'));
        subscribeModal.hide();

        Swal.fire({
          title: '✅ Thank You!',
          text: 'You have successfully subscribed.',
          icon: 'success',
          confirmButtonColor: '#f89852'
        });

        // ✅ Agar backend par bhejna ho to uncomment kijiye:
        this.submit();
      } else {
        // Agar form invalid hai to browser validation trigger karega
        this.reportValidity();
      }
    });
  });
</script>





</body>

</html>