<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// ✅ Pehle full name, agar nahi mila to username, fir default "Admin"
$adminName = $_SESSION['admin_name'] ?? ($_SESSION['admin_username'] ?? 'Admin');
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #f5945c, #fec76f);">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand  text-white fw-bold bg-white rounded-2 m-0 p-0" 
       href="<?= htmlspecialchars($BASE_URL . '/public/index.php') ?>">
      <img src="../assets/worksmart-logo.png" alt="Logo" class="me-2" style="height:40px;">
      <!-- <span class="d-none d-md-inline">Newsletter Portal</span> -->
    </a>

    <!-- Toggle Button for Mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Items -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <?php if (!empty($_SESSION['admin_logged_in'])): ?>
          <li class="nav-item me-2">
            <a href="#"  
            
               class="btn btn-success btn-sm">
                <i class="bi bi-person-circle me-1"></i> Admin <?= htmlspecialchars($adminName) ?>
            </a>
          </li>
          <li class="nav-item me-2">
            <a href="<?= htmlspecialchars($BASE_URL . '/admin/send_newsletter.php') ?>" 
               class="btn btn-outline-light btn-sm">
              <i class="bi bi-envelope-paper-fill me-1"></i> Admin Panel
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= htmlspecialchars($BASE_URL . '/admin/logout.php') ?>" 
               class="btn btn-danger btn-sm">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <button class="btn btn-light btn-sm px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#subscribeModal">
              <i class="bi bi-bell-fill me-1 text-warning"></i> Subscribe
            </button>
          </li>
        <?php endif; ?>

        
      </ul>
    </div>
  </div>
</nav>

<!-- Toastify Welcome Notification (only once per session) -->
<?php if (!empty($_SESSION['admin_logged_in']) && empty($_SESSION['toast_shown'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Toastify({
        text: "👋 Welcome back, Admin!",
        duration: 4000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(135deg, #f5945c, #fec76f)",
      }).showToast();
    });
  </script>
  <?php $_SESSION['toast_shown'] = true; ?>
<?php endif; ?>
