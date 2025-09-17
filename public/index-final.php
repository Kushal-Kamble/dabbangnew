<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../inc/mailer.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$isLoggedIn = !empty($_SESSION['user_logged_in']); 

// Random strong password generate
function generatePassword($length = 10) {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
  return substr(str_shuffle($chars), 0, $length);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name   = trim($_POST['first_name']);
  $last_name    = trim($_POST['last_name']);
  $email        = trim($_POST['email']);
  $mobile       = trim($_POST['mobile']);
  $linkedin_url = trim($_POST['linkedin_url']);
  $status       = 1; 
  $password     = generatePassword();

  // Duplicate email check
  $check = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $_SESSION['error'] = "This email is already subscribed!";
    header("Location: index-final.php");
    exit;
  }

  // Insert subscriber
  $stmt = $conn->prepare("INSERT INTO subscribers (first_name, last_name, email, mobile, linkedin_url, status, password) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssis", $first_name, $last_name, $email, $mobile, $linkedin_url, $status, password_hash($password, PASSWORD_BCRYPT));

  if ($stmt->execute()) {
    // ✅ Stylish Email Template
    $subject = "🎉 Welcome {$first_name}, Your Subscription is Active!";
    $message = '
    <div style="font-family: Arial, sans-serif; max-width:600px; margin:auto; background:#f5f7fb; border-radius:8px; overflow:hidden;">
      <div style="background:#fe9e43; padding:20px; text-align:center;">
        <h1 style="color:#fff; margin:0;">WORKSMART Newsletter</h1>
      </div>s
      <div style="padding:20px; color:#212428;">
        <p>Hi <strong>'.$first_name.' '.$last_name.'</strong>,</p>
        <p>Thank you for subscribing to <b>WORKSMART Newsletter</b>! 🎉</p>
        <p>Here are your login details:</p>
        <table style="width:100%; border-collapse:collapse; margin-top:10px;">
          <tr>
            <td style="padding:8px; background:#fefffe; border:1px solid #ddd;">Email</td>
            <td style="padding:8px; background:#fff; border:1px solid #ddd;"><strong>'.$email.'</strong></td>
          </tr>
          <tr>
            <td style="padding:8px; background:#fefffe; border:1px solid #ddd;">Password</td>
            <td style="padding:8px; background:#fff; border:1px solid #ddd; color:#fe9e43;"><strong>'.$password.'</strong></td>
          </tr>
        </table>
        <p style="margin-top:20px;">You can now <a href="'.$BASE_URL.'/login.php" style="color:#fe9e43; text-decoration:none;">log in</a> and explore the latest newsletters and insights.</p>
        <p style="font-size:13px; color:#666;">For your security, please change your password after logging in.</p>
      </div>
      <div style="background:#212428; color:#fefffe; text-align:center; padding:10px;">
        © '.date('Y').' WORKSMART Newsletter | Stay Connected 🚀
      </div>
    </div>';

    // Send mail
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: WORKSMART Newsletter <newsletter@worksmart.com>\r\n";

    mail($email, $subject, $message, $headers);

    $_SESSION['success'] = "Subscription successful! Check your email for login details.";
  } else {
    $_SESSION['error'] = "Something went wrong. Please try again.";
  }

  $stmt->close();
  header("Location: index-final.php");
  exit;
}
?>



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
  <title>WORKSMART — Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/indexpublic.css">
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png">



  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL . '/assets/css/styles.css') ?>">
</head>

<body>
  <?php include __DIR__ . '/../inc/header-public.php'; ?>

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
                  <a href="post_view.php?id=<?= $post['id'] ?>" class="btn-read mt-auto text-decoration-none text-center require-login">
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

              <input name="first_name" class="form-control" placeholder="First Name" required />
            </div>
            <div class="mb-3">

              <input name="last_name" class="form-control" placeholder="Last Name" required />
            </div>
            <div class="mb-3">

              <input name="email" type="email" placeholder="email" required class="form-control" />
            </div>
            <div class="mb-3">

              <input name="mobile" type="text" placeholder="Mobile" required class="form-control" />
            </div>
            <div class="mb-3">

              <input name="linkedin_url" type="url" placeholder="LinkedIn Profile URL" required class="form-control" />
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
    // isLogged value from PHP session
    const isLoggedIn = <?= !empty($_SESSION['user_logged_in']) ? 'true' : 'false' ?>;

    document.querySelectorAll('.require-login').forEach(a => {
      a.addEventListener('click', function(e) {
        if (!isLoggedIn) {
          e.preventDefault();
          Swal.fire({
            icon: 'warning',
            title: 'You are not logged in',
            text: 'Please login or subscribe to read the full article.',
            showCancelButton: true,
            confirmButtonText: 'Login',
            cancelButtonText: 'Close'
          }).then(result => {
            if (result.isConfirmed) {
              // go to login page
              window.location.href = '<?= htmlspecialchars($BASE_URL . "/public/login.php") ?>';
            }
          });
        }
      });
    });
  </script>


  <script>
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(function() {
    <?php if (!$isLoggedIn): ?>  
      // ✅ Agar login nahi hai
      Swal.fire({
        title: 'Welcome!',
        text: 'Please login or subscribe to continue',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Login',
        cancelButtonText: 'Subscribe',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#f89852'
      }).then((result) => {
        if (result.isConfirmed) {
          // ✅ Login page par bhej de
          window.location.href = "login.php";
        } else {
          // ✅ Subscribe modal dikhade
          var subscribeModal = new bootstrap.Modal(document.getElementById('subscribeModal'));
          subscribeModal.show();
        }
      });
    <?php endif; ?>
  }, 5000);

  // ✅ Form submit event
  document.getElementById("subscribeForm").addEventListener("submit", function(e) {
    e.preventDefault();

    if (this.checkValidity()) {
      var subscribeModal = bootstrap.Modal.getInstance(document.getElementById('subscribeModal'));
      subscribeModal.hide();

      Swal.fire({
        title: '✅ Thank You!',
        text: 'You have successfully subscribed.',
        icon: 'success',
        confirmButtonColor: '#f89852'
      });

      this.submit(); // backend me bhejne ke liye
    } else {
      this.reportValidity();
    }
  });
});
</script>

<script>
  // Prevent hover behavior issues on touch devices
  document.querySelectorAll('.navbar .dropdown').forEach(function(drop) {
    drop.addEventListener('touchstart', function(e) {
      if (!this.classList.contains('show')) {
        this.querySelector('.dropdown-toggle').click();
        e.preventDefault();
      }
    });
  });
</script>







</body>

</html>