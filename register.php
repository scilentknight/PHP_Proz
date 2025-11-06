<?php
require('Includes/header.php');
if (isset($_SESSION['customerlogin']) && $_SESSION['customerlogin'] === true) {
  redirect('customer_dashboard.php');
}
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
    .register-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .register-form {
      width: 100%;
      max-width: 600px;
    }

    .password-wrapper {
      position: relative;
      width: 100%;
    }

    .password-wrapper input {
      width: 100%;
      padding-right: 40px;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      user-select: none;
      font-size: 18px;
    }
  </style>
</head>

<body>
  <div class="register-wrapper">
    <div class="register-form text-center rounded bg-white shadow overflow-hidden">
      <form method="POST" onsubmit="return form_validate()" id="register-form">
        <h4 class="bg-dark text-white py-3">Register Now</h4>
        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Note: Your details must match with
          your
          IDs (Citizenship,
          Passport, Driving License, etc)
        </span>
        <div class="p-4">
          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="text" name="name" id="name" class="form-control shadow-none" placeholder="Full Name"
                required />
              <span id="name_msg"></span>
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" name="email" id="email" class="form-control shadow-none" placeholder="Email"
                required />
              <span id="email_msg"></span>

            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="phone" id="phone" class="form-control shadow-none" placeholder="Phone Number"
                required />
              <span id="phone_msg"></span>

            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="address" id="address" class="form-control shadow-none" placeholder="Address"
                required />
              <span id="address_msg"></span>
            </div>
            <div class="col-md-6 mb-3">
              <select name="gender" id="gender" class="form-control shadow-none" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>

            </div>
            <div class="col-md-6 mb-3">
              <input type="date" name="dob" id="dob" class="form-control shadow-none" placeholder="Date of Birth"
                required />

            </div>
            <div class="col-md-6 mb-4">
              <div class="password-wrapper">
                <input type="password" name="password" id="password" class="form-control shadow-none"
                  placeholder="Password" required />
                <span class="toggle-password" onclick="passwordToggle()">🔑</span>
              </div>
              <span id="password_msg"></span>
            </div>

            <div class="col-md-6 mb-4">
              <div class="password-wrapper">
                <input type="password" name="cpassword" id="cpassword" class="form-control shadow-none"
                  placeholder="Confirm Password" required />
                <span class="toggle-password" onclick="cpasswordToggle()">🔑</span>
              </div>
              <span id="cpassword_msg"></span>
            </div>
            <div class="col-md-12 mb-4 d-flex justify-content-between align-items-center">
              <button type="submit" name="register" id="register"
                class="btn text-dark custom-bg shadow-none">Register</button>
              <p>Already have an account?
                <a href="login.php" class="text-decoration-none"> Login</a>
              </p>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>


  <!-- js code -->
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

    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData(register_form);
      data.append('register', '1');  // Add this line so PHP detects $_POST['register']

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "userAjax/register.php", true);

      xhr.onload = function () {
        let res = this.responseText.trim();

        if (res === 'pass_mismatch') {
          alert('error', 'Password Mismatch');
        } else if (res === 'email_exist') {
          alert('error', 'Email Already Exists');
        } else if (res === 'phone_exist') {
          alert('error', 'Phone Already Exists');
        } else if (res === 'failed') {
          alert('error', 'Server Error. Please try again.');
        } else if (res === 'success') {
          alert('success', 'Registration Successful');
          register_form.reset();
          setTimeout(() => {
            window.location.href = "login.php";
          }, 2000);
        } else {
          alert('error', 'Unexpected error: ' + res);
        }
      };

      xhr.send(data);
    });

  </script>




  <?php require('Includes/scripts.php'); ?>
  <script src="Scripts/registerScript.js"></script>
  <script>
    function passwordToggle() {
      const passwordField = document.getElementById('password');
      passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    }
    function cpasswordToggle() {
      const cpasswordField = document.getElementById('cpassword');
      cpasswordField.type = cpasswordField.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>

</html>