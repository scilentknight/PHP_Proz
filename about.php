<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ErcelStore - About</title>
  <!-- swiperjs cdn start -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- swiperjs cdn end -->

  <?php
  require('Includes/links.php');
  ?>
  <style>
    .h-line {
      width: 120px;
      margin: 0 auto;
      height: 1.7px;
    }

    .box:hover {
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
    <h2 class="fw-bold h-font text-center">About us</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">At ErcelStore, our mission is to provide customers with a seamless shopping experience
      for all their Apple needs. From the latest iPhones to MacBooks, iPads, and more, we offer a wide range of
      authentic Apple products. We pride ourselves on delivering expert customer support, fast and reliable delivery,
      and secure payment options to ensure your shopping journey with us is smooth and satisfying.</p>
  </div>

  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Why Ercel Store</h3>
        <p class="about-text">
          ~Welcome to <span class="fs-5 text-dark fw-bold">ErcelStore</span>,
          your premium destination for all Apple products in Kathmandu, Nepal.
          Whether you're looking for the latest iPhone, a new MacBook, iPad,
          or iMac, we offer top-tier Apple products with the best customer
          service in town.
        </p>
        <p class="about-text">
          Our store is committed to delivering the best Apple experience. We
          aim to provide our customers with cutting-edge products, competitive
          pricing, and quick delivery services to ensure that your experience
          with us is seamless and satisfying.
        </p>
      </div>

      <?php
      $store_r = selectAll('store');
      $path = STORE_IMG_PATH;
      while ($row = mysqli_fetch_assoc($store_r)) {
        echo <<<data
           <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
          <img src="$path$row[store_image]" alt="Apple Store" class="w-100 rounded">
          <h5 class="mt-2 d-flex justify-content-center">$row[store_name]</h5>
          </div>
        data;
      }
      ?>
    </div>
  </div>
  <div class="container mt-5">
    <h3 class="my-5 fw-bold h-font text-center">Choose Us</h3>
    <div class="row">

      <?php
      $chooseus_r = selectAll('chooseus');
      $path = CHOOSEUS_IMG_PATH;
      while ($row = mysqli_fetch_assoc($chooseus_r)) {
        echo <<<data
          <div class="col-lg-3 col-md-6 mb-4 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 text-center border-dark box">
          <img src="$path$row[chooseus_image]" alt="Appple Store" width="70px" class="rounded">
          <h4 class="mt-3">$row[chooseus_name]</h4>
          </div>
          </div>
         data;
      }
      ?>

    </div>
  </div>
  <h3 class="my-5 fw-bold h-font text-center">Support Team</h3>
  <div class="container px-4">
    <!-- Swiper -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper mb-5">
        <?php
        $about_r = selectAll('team_details');
        $path = ABOUT_IMG_PATH;
        while ($row = mysqli_fetch_assoc($about_r)) {
          echo <<<data
          <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="$path$row[picture]" class="w-100">
          <h5 class="mt-2">$row[name]</h5>
          </div>
         data;
        }
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
  <!-- main content end -->
  <?php
  require('Includes\footer.php');
  ?>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 4,
      spaceBetween: 40,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  </script>
</body>

</html>