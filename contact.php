<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ErcelStore - Contact</title>
  <?php
  require('Includes/links.php');
  ?>
  <style>
    .h-line {
      width: 150px;
      margin: 0 auto;
      height: 1.7px;
    }
  </style>
</head>

<body>
  <?php
  require('Includes\header.php');
  ?>
  <!-- main content start -->

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Contact Us</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
      At ErcelStore, we offer a seamless shopping experience with a wide range
      of authentic Apple products, <br />
      expert customer support, fast delivery services, and secure payment
      options.
    </p>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4">
          <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_r['iframe']; ?>" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
          <h5>Address</h5>
          <i class="bi bi-geo-alt-fill"></i>
          <a href="<?php echo $contact_r['gmap']; ?>" target="_blank"
            class="d-inline-block text-decoration-none text-dark mb-2"><?php echo $contact_r['address']; ?></a>
          <h5 class="mt-2">Call us</h5>
          <a href="tel:+<?php echo $contact_r['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1']; ?>
          </a>
          <br />
          <?php
          if ($contact_r['pn2'] != '') {
            $pn2 = $contact_r['pn2'];
            echo <<<data
            <a href="tel:+$pn2" class="d-inline-block mb-2 text-decoration-none text-dark">
              <i class="bi bi-telephone-fill"></i> +$pn2
            </a>
          data;
          }
          ?>
          <h5 class="mt-4">Email</h5>
          <a href="mailto:<?php echo $contact_r['email']; ?>" class="d-inline-block text-decoration-none text-dark"><i
              class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']; ?></a>

          <h5 class="mt-4">Follow us</h5>
          <a href="<?php echo $contact_r['fb']; ?>" class="d-inline-block text-dark fs-5 me-2 " target="_blank">
            <i class="bi bi-facebook me-1"></i>
          </a>
          <a href="<?php echo $contact_r['insta']; ?>" class="d-inline-block text-dark fs-5 me-2" target="_blank">
            <i class="bi bi-instagram me-1"></i>
          </a>
          <?php
          if ($contact_r['tw'] != '') {
            $tw = $contact_r['tw'];
            echo <<<data
            <a href="$tw" class="d-inline-block text-dark fs-5 me-2" target="_blank">
            <i class="bi bi-twitter me-1"></i>
          </a>
          data;
          }
          ?>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 px-4">
        <div class="bg-white rounded shadow p-4">
          <form action="" method="post">
            <h5>Send a message</h5>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500">Name</label>
              <input type="text" name="name" class="form-control shadow-none" required />
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500">Email</label>
              <input type="email" name="email" class="form-control shadow-none" required />
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500">Subject</label>
              <input type="text" name="subject" class="form-control shadow-none" required />
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500">Message</label>
              <textarea class="form-control shadow-none" rows="5" name="message" style="resize: none"></textarea>
            </div>
            <button type="submit" name="send" class="btn text-white custom-bg mt-3">
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['send'])) {
    // print_r($_POST);
    $frm_data = filteration($_POST);
    $query = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
    $result = insert($query, $values, 'ssss');
    if ($result == 1) {
      alert('success', 'Message send!');
    } else {
      alert('error', 'Server Down! Try again later.');
    }
  }
  ?>
  <!-- main content end -->
  <?php
  require('Includes\footer.php');
  ?>
</body>

</html>