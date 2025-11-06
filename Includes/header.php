<?php
// session_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require('AdminPanel/inc/dbconfig.php');
require('AdminPanel/inc/essentials.php');

$contact_q = "SELECT * FROM `contact_details` WHERE `sn` = ?";
$settings_q = "SELECT * FROM `settings` WHERE `sn` = ?";
$value = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $value, 'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q, $value, 'i'));
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <?php require('links.php'); ?>
  <style>
    .password-container {
      position: relative;
      width: 100%;
    }

    .form-control {
      padding-right: 40px;
    }

    .nav-item.dropdown:hover .dropdown-menu {
      display: block;
      margin-top: 0;
    }

    .dropdown-menu {
      transition: all 0.3s ease;
    }
  </style>
</head>

<body>

  <?php
  if ($settings_r['shutdown']) {
    echo <<<alertbar
    <div class="bg-danger text-center p-2 fw-bold">
      <i class="bi bi-exclamation-triangle-fill"></i>
      Bookings are temporarily closed!
    </div>
    alertbar;
  }
  ?>

  <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">

      <!-- Site Title (Left) -->
      <a class="navbar-brand fw-bold fs-3 h-font me-auto" href="index.php">
        <?php echo $settings_r['site_title']; ?>
      </a>

      <!-- Toggle Button for Mobile -->
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Centered Nav Links -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link me-3" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link me-3" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link me-3" href="facilities.php">Facilities</a></li>
          <li class="nav-item"><a class="nav-link me-3" href="contact.php">Contact Us</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link me-3 dropdown-toggle" href="products.php" role="button" data-bs-toggle="dropdown">
              Products
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="products.php#macbook">MacBooks</a></li>
              <li><a class="dropdown-item" href="products.php#iphone">iPhones</a></li>
              <li><a class="dropdown-item" href="products.php#ipad">iPads</a></li>
              <li><a class="dropdown-item" href="products.php#imac">iMacs</a></li>
            </ul>
          </li>
        </ul>

        <!-- Right-side Cart and Profile/Login -->
        <div class="d-flex align-items-center gap-3 ms-auto mt-2 mt-lg-0">
          <?php if (isset($_SESSION['customerlogin']) && $_SESSION['customerlogin'] === true): ?>
            <!-- Cart Button -->
            <a href="cart_view.php" class="btn btn-outline-dark position-relative">
              <i class="bi bi-cart-fill me-1"></i> Cart
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
              </span>
            </a>

            <!-- Profile Dropdown -->
            <?php $cName = htmlspecialchars($_SESSION['cName']); ?>
            <div class="btn-group">
              <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?= $cName ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="btn btn-outline-danger btn-sm ms-3" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>
                    Log Out</a></li>
              </ul>
            </div>

          <?php else: ?>
            <!-- Login/Register Buttons -->
            <a href="./login.php" class="btn btn-outline-secondary">Login</a>
            <a href="./register.php" class="btn btn-outline-secondary">Register</a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>


</body>

</html>