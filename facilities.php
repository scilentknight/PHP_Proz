<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ErcelStore - Facilities</title>
  <?php
  require('Includes/links.php');
  ?>
  <style>
    .h-line {
      width: 180px;
      margin: 0 auto;
      height: 1.7px;
    }

    .pop:hover {
      border-top-color: var(--teal) !important;
      transform: scale(1.03);
      transition: all 0.3s;
    }
  </style>
</head>

<body>
  <?php
  require('Includes\header.php');
  ?>
  <!-- main content start -->

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Our facilities</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">At ErcelStore, we offer a seamless shopping experience with a wide range of authentic
      Apple products, <br> expert customer support, fast delivery services, and secure payment options.</p>
  </div>
  <div class="container">
    <div class="row">

      <?php
      $res = selectAll('facilities');
      $path = FACILITIES_IMG_PATH;
      while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
          <div class="col-lg-4 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
          <div class="d-flex align-items-center mb-2">
            <img src="$path$row[icon]" width="40px" class="rounded-circle">
            <h5 class="m-0 ms-3">$row[name]</h5>
          </div>
          <p>$row[description]</p>
        </div>
      </div>
      data;
      }
      ?>

    </div>
  </div>
  </div>
  <!-- main content end -->
  <?php
  require('Includes\footer.php');
  ?>

</body>

</html>