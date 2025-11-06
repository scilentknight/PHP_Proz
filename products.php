<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ErcelStore - Products</title>
  <?php
  require('Includes/links.php');
  ?>
</head>
<style>
  .custom-navbar-width {
    width: 50%;
    margin: 0 auto;
  }
</style>

<body>
  <?php
  require('Includes\header.php');
  ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center mb-4">
      Explore Our Exclusive Range of Products
    </h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3 mb-5">
      Browse our curated collection of genuine Apple products at ErcelStore
      <br />offering you premium quality, expert support, fast delivery,<br />
      and secure shopping all in one place.
    </p>
  </div>

  <div class="container-fluid">

    <!-- filter section  -->
    <div class="col-lg-12 col-md-12 mb-5">
      <nav class="navbar navbar-light bg-white rounded shadow custom-navbar-width">
        <div class="container-fluid align-items-stretch">
          <h4 class="mt-2 h-font">FILTERS</h4>
          <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="filterDropdown">
            <div class="d-flex flex-wrap gap-3">

              <!-- Model Year Filter -->
              <div class="border bg-light p-3 rounded mb-3" style="flex: 1 1 300px;">
                <h5 class="mb-3" style="font-size: 18px">Model Year</h5>
                <div class="mb-2">
                  <input type="checkbox" id="2020" class="form-check-input shadow-none me-1" />
                  <label for="2020" class="form-check-label">2020</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="2021" class="form-check-input shadow-none me-1" />
                  <label for="2021" class="form-check-label">2021</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="2022" class="form-check-input shadow-none me-1" />
                  <label for="2022" class="form-check-label">2022</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="2023" class="form-check-input shadow-none me-1" />
                  <label for="2023" class="form-check-label">2023</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="2024" class="form-check-input shadow-none me-1" />
                  <label for="2024" class="form-check-label">2024</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="2025" class="form-check-input shadow-none me-1" />
                  <label for="2025" class="form-check-label">2025</label>
                </div>
              </div>

              <!-- Color Filter -->
              <div class="border bg-light p-3 rounded mb-3" style="flex: 1 1 300px;">
                <h5 class="mb-3" style="font-size: 18px">Color</h5>
                <div class="mb-2">
                  <input type="checkbox" id="silver" class="form-check-input shadow-none me-1" />
                  <label for="silver" class="form-check-label">Silver</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="midnightblack" class="form-check-input shadow-none me-1" />
                  <label for="midnightblack" class="form-check-label">Midnight Black</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="spacegray" class="form-check-input shadow-none me-1" />
                  <label for="spacegray" class="form-check-label">Space Gray</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="deserttitanium" class="form-check-input shadow-none me-1" />
                  <label for="deserttitanium" class="form-check-label">Desert Titanium</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="matblack" class="form-check-input shadow-none me-1" />
                  <label for="matblack" class="form-check-label">Mat Black</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="purple" class="form-check-input shadow-none me-1" />
                  <label for="purple" class="form-check-label">Purple</label>
                </div>
                <div class="mb-2">
                  <input type="checkbox" id="blue" class="form-check-input shadow-none me-1" />
                  <label for="blue" class="form-check-label">Blue</label>
                </div>
              </div>

            </div>
          </div>

        </div>
      </nav>
    </div>

    <!-- product section  -->
    <div class="row">
      <!-- Macbook -->
      <div class="col-lg-12 col-md-12 px-4 mb-5" id="mackbook">
        <div class="container">
          <div class="row gx-4 gy-4">
            <?php
            // Fetch Macbook products
            $q = "SELECT * FROM `products` WHERE `item` IN ('Macbook','macbook') ORDER BY `id` DESC";
            $res = mysqli_query($con, $q);
            $path = PRODUCTS_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {

              // Default button (fallback for shutdown or not logged in)
              $buttons = '<a href="#" class="btn btn-sm text-white btn-dark shadow-none w-100">See More</a>';

              // If site is not shutdown AND user is logged in
              if (!$settings_r['shutdown'] && isset($_SESSION['customerlogin']) && $_SESSION['customerlogin'] === true) {
                $buttons = <<<btn
            <a href="purchase.php?id={$row['id']}" class="btn btn-sm text-white custom-bg shadow-none mb-2 w-100">Book Now</a>
            <a href="cart.php?id={$row['id']}" class="btn btn-sm text-white btn-dark shadow-none w-100">Add to Cart</a>
          btn;
              }

              echo <<<data
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card border-0 shadow h-100">
              <div class="p-3 text-center">
                <img src="{$path}{$row['image']}" class="img-fluid rounded mb-3" />
                <h5 class="mb-2">{$row['item']} {$row['modal']}</h5>
                <h6 class="mb-3">Rs. {$row['price']}.00</h6>
                $buttons
              </div>
            </div>
          </div>
        data;
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Iphone -->
      <div class="col-lg-12 col-md-12 px-4" id="iphone">
        <div class="container">
          <div class="row gx-4 gy-4"> <!-- gx for horizontal gap, gy for vertical gap -->
            <?php
            // Fetch Iphone products
            $q = " SELECT * FROM `products` WHERE `item` IN ('Iphone','iphone') ORDER BY `id` DESC LIMIT 8";

            $res = mysqli_query($con, $q);
            $path = PRODUCTS_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {
              // Default button (fallback for shutdown or not logged in)
              $buttons = '<a href="products.php?id=' . $row['id'] . '" class="btn btn-sm text-white btn-dark shadow-none w-100">See More</a>';

              // If site is not shutdown AND user is logged in
              if (!$settings_r['shutdown'] && isset($_SESSION['customerlogin']) && $_SESSION['customerlogin'] === true) {
                $buttons = <<<btn
            <a href="purchase.php?id={$row['id']}" class="btn btn-sm text-white custom-bg shadow-none mb-2 w-100">Book Now</a>
            <a href="cart.php?id={$row['id']}" class="btn btn-sm text-white btn-dark shadow-none w-100">Add to Cart</a>
          btn;
              }

              echo <<<data
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card border-0 shadow h-100">
              <div class="p-3 text-center">
                <img src="{$path}{$row['image']}" class="img-fluid rounded mb-3" />
                <h5 class="mb-2">{$row['item']} {$row['modal']}</h5>
                <h6 class="mb-3">Rs. {$row['price']}.00</h6>
                $buttons
              </div>
            </div>
          </div>
        data;
            }
            ?>
          </div>
        </div>
      </div>



    </div>
  </div>
  <?php
  require('Includes\footer.php');
  ?>
</body>

</html>