<?php
require('inc/dbconfig.php');
require('inc/essentials.php');

session_start();
if ((isset($_SESSION['adminlogin']) && $_SESSION['adminlogin'] == true)) {
  redirect('admin_dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login Panel</title>
  <?php
  require('inc/links.php');
  ?>
  <style>
    .login-form {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
    }
  </style>

</head>

<body>
  <div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
      <h4 class="bg-dark text-white py-3">Admin Login Panel</h4>
      <div class="p-4">
        <div class="mb-3">
          <input name="email" type="email" class="form-control shadow-none text-center" placeholder="Admin Email"
            required />
        </div>
        <div class="mb-4">
          <input name="password" type="password" class="form-control shadow-none text-center" placeholder="Password"
            required />
        </div>
        <button type="submit" name="login" class="btn text-white custom-bg shadow-none">Login</button>
      </div>
    </form>
  </div>
  <?php
  if (isset($_POST['login'])) {
    // print_r($_POST);
    $frm_data = filteration($_POST);
    $query = "SELECT * FROM `admin` WHERE `email` = ? AND `password` = ?";
    $values = [$frm_data['email'], $frm_data['password']];
    $res = select($query, $values, "ss");

    if ($res->num_rows == 1) {
      $row = mysqli_fetch_assoc($res);
      $_SESSION['adminlogin'] = true;
      $_SESSION['adminid'] = $row['id'];
      redirect('admin_dashboard.php');
    } else {
      alert('error', 'Login failed - Invalid Crediantials');
    }
  }
  ?>

  <?php
  require('inc/scripts.php');
  ?>
</body>

</html>