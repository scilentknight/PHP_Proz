<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer</title>
</head>

<body>
  <!-- footer start -->
  <footer class="bg-dark text-light pt-5 pb-4 shadow-lg mt-5">
    <div class="container text-center text-md-start">
      <div class="row text-center text-md-start">
        <!-- Company Info -->
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="mb-4 h-font fw-bold text-warning">
            ~<?php echo $settings_r['site_title']; ?>
          </h5>
          <p>
            <?php echo $settings_r['site_about']; ?>
          </p>
        </div>

        <!-- Links -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-warning">Links</h5>
          <p><a href="index.php" class="text-light text-decoration-none">Home</a></p>
          <p><a href="about.php" class="text-light text-decoration-none">About</a></p>
          <p>
            <a href="facilities.php" class="text-light text-decoration-none">Facilities</a>
          </p>
          <p>
            <a href="contact.php" class="text-light text-decoration-none">Contact Us</a>
          </p>
        </div>

        <!-- Products -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-warning">Products</h5>
          <p>
            <a href="products/macbooks" class="text-light text-decoration-none">Macbooks</a>
          </p>
          <p>
            <a href="products/iphones" class="text-light text-decoration-none">Iphones</a>
          </p>
          <p>
            <a href="products/ipads" class="text-light text-decoration-none">Ipads</a>
          </p>
          <p>
            <a href="products/imacs" class="text-light text-decoration-none">iMacs</a>
          </p>
        </div>

        <!-- Contact -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-warning">Contact</h5>
          <p><i class="bi bi-house-door-fill"></i> <?php echo $contact_r['address']; ?></p>
          <p><i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']; ?></p>
          <p><i class="bi bi-phone-fill"></i> +<?php echo $contact_r['pn1']; ?></p>
          <?php
          if ($contact_r['pn2'] != '') {
            $pn2 = $contact_r['pn2'];
            echo <<<data
            <p><i class="bi bi-printer-fill"></i> +$pn2</p>
          data;
          }
          ?>

        </div>
      </div>

      <!-- Bottom -->
      <hr class="my-4" />
      <div class="text-center">
        <p class="mb-0">&copy; 2025 ErcelStore. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
  <!-- footer end -->

  <?php
  require('scripts.php');
  ?>
  <script>
    function setActive() {
      let navbar = document.getElementById('nav-bar');
      let a_tags = navbar.getElementsByTagName('a');

      for (i = 0; i < a_tags.length; i++) {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];

        if (document.location.href.indexOf(file_name) >= 0) {
          a_tags[i].classList.add('active');
        }
      }
    }
    setActive();
  </script>
</body>

</html>