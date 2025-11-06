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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">MyApp</a>
      <div class="d-flex">
        <div class="btn-group">
          <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            <?= $cName ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="products.php">Products</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg rounded-3">
          <div class="card-body text-center p-4">
            <i class="bi bi-person-circle display-1 text-secondary"></i>
            <h2 class="mt-3"><?= $cName ?></h2>
            <p class="text-muted mb-1"><i class="bi bi-envelope"></i> <?= $email ?></p>
            <p class="text-muted"><i class="bi bi-shield-lock"></i> Role: <?= $role ?></p>
            <a href="edit_profile.php" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit
              Profile</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>