<?php
require('Includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php
  require('Includes/links.php');
  ?>
  <style>
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .login-form {
      width: 100%;
      max-width: 450px;
    }

    .mb-4.position-relative {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 12px;
      /* adjust for padding */
      transform: translateY(-50%);
      cursor: pointer;
      user-select: none;
      font-size: 1.2rem;
      /* adjust size if needed */
      color: #555;
      /* subtle color */
    }
  </style>
</head>

<body>

  <!-- Modal Login -->
  <div class="login-wrapper">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
      <form method="POST">
        <h4 class="bg-dark text-white py-3">Login Now</h4>
        <div class="p-4">
          <div class="mb-3">
            <input name="email" type="email" class="form-control shadow-none" placeholder="Email" required />
          </div>
          <div class="mb-4 position-relative">
            <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password"
              required />
            <span class="toggle-password" onclick="passwordToggle()">🔑</span>
          </div>
          <p class="d-flex justify-content-between align-items-center ">
            <span><a class="text-decoration-none" href="forgot-password.php">Forget Password</a></span>
            <span><a class="text-decoration-none" href="register.php">Register Now</a></span>
          </p>
          <div>
            <button type="submit" name="login" id="login" class="btn text-dark custom-bg shadow-none">
              <span>Login</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    function alert(type, msg) {
      let bs_class = (type === 'success') ? 'alert-success' : 'alert-danger';
      let element = document.createElement('div');

      element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-2">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
      document.body.append(element);
      setTimeout(() => {
        element.remove();
      }, 3000);
    }
  </script>

  <?php
  if (isset($_POST['login'])) {
    $frm_data = filteration($_POST);

    // Select user by email only
    $query = "SELECT * FROM `customer` WHERE `email` = ?";
    $values = [$frm_data['email']];
    $res = select($query, $values, "s");

    if ($res->num_rows == 1) {
      $row = mysqli_fetch_assoc($res);

      // Verify password against hash
      if (password_verify($frm_data['password'], $row['password'])) {
        $_SESSION['customerlogin'] = true;
        $_SESSION['cid'] = $row['cid'];  // Use 'cid' as per your schema
        $_SESSION['cName'] = $row['name'];  // Use 'name' as per your schema
        $_SESSION['cPhone'] = $row['phone'];  // Use 'phone' as per your schema
        $_SESSION['cAddress'] = $row['address'];  // Use 'address' as per your schema
        $_SESSION['cGender'] = $row['gender'];  // Use 'gender' as per your schema
        $_SESSION['cDOB'] = $row['date_of_birth'];  // Use 'date_of_birth' as per your schema
        redirect('index.php');
      } else {
        alert("error", "Login Failed - Invalid Credentials!");
      }
    } else {
      alert("error", "Login Failed - Invalid Credentials!");
    }
  }
  ?>
  <?php require('Includes/scripts.php'); ?>

  <script>
    function passwordToggle() {
      const passwordField = document.getElementById('password');
      passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    }
  </script>

</body>

</html>