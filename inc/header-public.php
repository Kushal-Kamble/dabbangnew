<?php
// inc/header-public.php
if (session_status() === PHP_SESSION_NONE) session_start();
$isLogged = !empty($_SESSION['user_logged_in']);
$userName = $isLogged ? ($_SESSION['user_name'] ?? trim(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? ''))) : null;
?>
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #f5945c, #fec76f);">
  <div class="container">
    <a class="navbar-brand text-white fw-bold bg-white rounded-2 m-0 p-0" href="<?= htmlspecialchars($BASE_URL . '/public/index-final.php') ?>">
      <img src="<?= htmlspecialchars($BASE_URL . '/assets/logo-mit-school-of-distance-education.png') ?>" alt="Logo" style="height:40px;">
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <?php if ($isLogged): ?>
          <li class="nav-item dropdown me-2">
            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-1 text-success"></i> <?= htmlspecialchars($userName) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li>
                <a class="dropdown-item" href="<?= htmlspecialchars($BASE_URL . '/public/change_password.php') ?>">
                  <i class="bi bi-key me-2 text-warning"></i> Change Password
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= htmlspecialchars($BASE_URL . '/public/logout.php') ?>">
                  <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                </a>
              </li>
            </ul>

          </li>
        <?php else: ?>
          <li class="nav-item me-2">
            <button class="btn btn-light btn-sm px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#subscribeModal">
              <i class="bi bi-bell-fill me-1 text-dark"></i> Subscribe
            </button>
          </li>
          <li class="nav-item ">
            <a class="btn btn-login btn-sm px-3 bg-dark text-white fw-semibold " href="<?= htmlspecialchars($BASE_URL . '/public/login.php') ?>"><i class="bi bi-person-fill px-1"></i> Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Global flash messages via SweetAlert -->
<?php if (!empty($_SESSION['success'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'success',
        title: '<?= addslashes($_SESSION['success']) ?>',
        timer: 2200,
        showConfirmButton: false
      });
    });
  </script>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'error',
        title: '<?= addslashes($_SESSION['error']) ?>'
      });
    });
  </script>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>