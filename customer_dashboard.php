<?php
require('Includes/header.php');
if (!isset($_SESSION['customerlogin']) || $_SESSION['customerlogin'] !== true) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <?php
    require('Includes/links.php');
    ?>
</head>

<body class="bg-light">
    <!-- Carousel start -->
    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                $result = selectAll('carousel');
                while ($row = mysqli_fetch_assoc($result)) {
                    $path = CAROUSEL_IMG_PATH;
                    echo <<<data
           <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="$path$row[image]" class="w-100 d-block carimg">
          </div>
        data;
                }

                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- check availability form start-->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check availability</h5>
                <form action="">
                    <div class="row align-items-end">
                        <!-- Product Select -->
                        <div class="col-lg-3">
                            <label class="form-label">Select Product</label>
                            <select class="form-select shadow-none" id="selectProduct">
                                <option value="" disabled selected>Select Item</option>
                                <option value="macbook">Macbook</option>
                                <option value="iphone">iPhone</option>
                                <option value="ipad">iPad</option>
                                <option value="macmini">Mac Mini</option>
                                <option value="imac">iMac</option>
                            </select>
                        </div>

                        <!-- Modal Select -->
                        <div class="col-lg-3">
                            <label class="form-label">Select Modal</label>
                            <select class="form-select shadow-none" id="selectModal">
                                <option value="" disabled selected>Select Modal</option>
                            </select>
                        </div>

                        <!-- Variant Select -->
                        <div class="col-lg-3">
                            <label class="form-label">Select Variant</label>
                            <select class="form-select shadow-none" id="selectVariant">
                                <option value="" disabled selected>Select Variant</option>
                            </select>
                        </div>

                        <!-- Color Select -->
                        <div class="col-lg-2">
                            <label class="form-label">Select Color</label>
                            <select class="form-select shadow-none" id="selectColor">
                                <option value="" disabled selected>Select Color</option>
                            </select>
                        </div>

                        <!-- Submit Button -->

                        <div class="col-lg-1 mt-3">
                            <button type="submit" name="buy" class="btn text-white shadow-none custom-bg">
                                <?php
                                $book_btn = "More";
                                if (!$settings_r['shutdown']) {
                                    $book_btn = <<<data
                <a href="login.php" class="text-decoration-none text-black">Buy</a>
                data;
                                }
                                echo <<<data
                $book_btn
                data;
                                ?>

                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    const selectProduct = document.getElementById("selectProduct");
                    const selectModal = document.getElementById("selectModal");
                    const selectVariant = document.getElementById("selectVariant");
                    const selectColor = document.getElementById("selectColor");

                    const modals = {
                        macbook: ["M1 Pro", "M2 Pro", "M3 Pro", "M4 Pro"],
                        iphone: [
                            "iPhone 14 Pro Max",
                            "iPhone 14 Pro",
                            "iPhone 14 Plus",
                            "iPhone 14",
                            "iPhone 15 Pro Max",
                            "iPhone 15 Pro",
                            "iPhone 15 Plus",
                            "iPhone 15",
                            "iPhone 16 Pro Max",
                            "iPhone 16 Pro",
                            "iPhone 16 Plus",
                            "iPhone 16",
                        ],
                        ipad: ["iPad Air", "iPad Pro", "iPad Mini"],
                        macmini: ["M1 Chip", "M1 Pro Chip", "M2 Chip", "M2 Pro Chip", "M3 Chip", "M3 Pro Chip", "M4 Chip", "M4 Pro Chip"],
                        imac: ["iMac 24-inch", "iMac 27-inch", "iMac Pro"],
                    };

                    const variants = {
                        macbook: [
                            "8/256GB",
                            "8/512GB",
                            "16/256GB",
                            "16/512GB",
                            "16/1TB",
                            "32/512GB",
                            "32/1TB",
                        ],
                        iphone: ["128GB", "256GB", "512GB", "1TB"],
                        ipad: ["128GB", "256GB", "512GB", "1TB"],
                        macmini: ["8/256GB", "16/256GB", "16/512GB", "16/1TB", "16/2TB", "24/512GB", "24/1TB", "24/2TB"],
                        imac: ["Standard", "Nano-texture Display"],
                    };

                    const colors = {
                        macbook: [
                            "Space Gray",
                            "Silver White",
                            "Rose Gold",
                            "Midnight Gray",
                            "Midnight Black",
                        ],
                        iphone: ["Mat Black", "White", "Blue", "Titanium Desert"],
                        ipad: ["Space Gray", "Mat Black"],
                        macmini: ["Silver"],
                        imac: ["White", "Silver", "Rose Gold", "Purple"],
                    };

                    selectProduct.addEventListener("change", function () {
                        const selectedProduct = this.value;

                        // Clear old options
                        selectModal.innerHTML =
                            '<option value="" disabled selected>Select Modal</option>';
                        selectVariant.innerHTML =
                            '<option value="" disabled selected>Select Variant</option>';
                        selectColor.innerHTML =
                            '<option value="" disabled selected>Select Color</option>';

                        // Populate Modal
                        if (modals[selectedProduct]) {
                            modals[selectedProduct].forEach(function (modal) {
                                const option = document.createElement("option");
                                option.value = modal.toLowerCase().replace(/\s+/g, "-");
                                option.textContent = modal;
                                selectModal.appendChild(option);
                            });
                        }

                        // Populate Variant
                        if (variants[selectedProduct]) {
                            variants[selectedProduct].forEach(function (variant) {
                                const option = document.createElement("option");
                                option.value = variant.toLowerCase().replace(/\s+/g, "-");
                                option.textContent = variant;
                                selectVariant.appendChild(option);
                            });
                        }

                        // Populate Color
                        if (colors[selectedProduct]) {
                            colors[selectedProduct].forEach(function (color) {
                                const option = document.createElement("option");
                                option.value = color.toLowerCase().replace(/\s+/g, "-");
                                option.textContent = color;
                                selectColor.appendChild(option);
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Our Products start -->
    <h2 class="mt-5 mb-4 text-center fw-bold h-font text-decoration-underline">
        OUR PRODUCTS
    </h2>
    <div class="container">
        <h1 class="mt-5 mb-4 text-center fw-bold h-font">
            Choose your new Appple products
        </h1>
        <div class="row">
            <!-- Macbook -->
            <div class="row gx-4 gy-4 mb-5">
                <?php
                // Fetch Macbook products
                $q = " SELECT * FROM `products` WHERE `item` IN ('Macbook','macbook') ORDER BY `id` DESC LIMIT 8";
                $res = mysqli_query($con, $q);
                $path = PRODUCTS_IMG_PATH;

                while ($row = mysqli_fetch_assoc($res)) {
                    $buttons = '<a href="#" class="btn btn-sm text-white btn-dark shadow-none w-100">See More</a>';

                    // If site is not shutdown
                    if (!$settings_r['shutdown']) {
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
                            $book_btn = "";
                            if (!$settings_r['shutdown']) {
                                $book_btn = <<<data
                <a href="#" class="btn btn-sm text-white custom-bg shadow-none mb-2 w-100">Book Now</a>
            data;
                            }
                            echo <<<data
        <!-- Each column spans 4 columns on large screens = 3 per row -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card border-0 shadow h-100">
            <div class="p-3 text-center">
              <img src="{$path}{$row['image']}" class="img-fluid rounded mb-3"/>
              <h5 class="mb-2">{$row['item']} {$row['modal']}</h5>
              <h6 class="mb-3">Rs. {$row['price']}.00</h6>
              $book_btn
              <a href="cart.php" class="btn btn-sm text-white btn-dark shadow-none w-100">Cart</a>
            </div>
          </div>
        </div>
        data;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 text-center mt-4">
                <a href="products.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More
                    Products
                    >>></a>
            </div>
        </div>
    </div>


    <!-- Our Facilities Start -->
    <h2 class="mt-5 mb-4 text-center fw-bold h-font text-decoration-underline">
        Our Facilities
    </h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
            $res = selectAll('facilities');
            $path = FACILITIES_IMG_PATH;
            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
        <div class="col-lg-4 col-md-6 px-3"> 
        <div class="bg-white text-center rounded shadow py-4 my-3">
        <img src="$path$row[icon]" alt="{$row['name']} image" width="80px" class="rounded-circle" />
        <h5 class="mt-5">{$row['name']}</h5>
        </div>
        </div>
       data;
            }
            ?>
            <div class="col-lg-12 text-center mt-2">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More
                    Facilities
                    >>></a>
            </div>
        </div>
    </div>

    <!-- testimonials start -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font text-decoration-underline">
        TESTIMONIALS
    </h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
                <div class="swiper-slide bg-light p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="" width="30px" />
                        <h6 class="m-0 ms-2">Random Customer1</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magni
                        praesentium, similique molestiae iusto ducimus culpa maxime dicta
                        in deserunt!
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-light p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="Images/Features/star.png" width="30px" />
                        <h6 class="m-0 ms-2">Random Customer2</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magni
                        praesentium, similique molestiae iusto ducimus culpa maxime dicta
                        in deserunt!
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-light p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="" width="30px" />
                        <h6 class="m-0 ms-2">Random Customer3</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magni
                        praesentium, similique molestiae iusto ducimus culpa maxime dicta
                        in deserunt!
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-light p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="Images/Features/star.png" width="30px" />
                        <h6 class="m-0 ms-2">Random Customer4</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magni
                        praesentium, similique molestiae iusto ducimus culpa maxime dicta
                        in deserunt!
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-light p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="" width="30px" />
                        <h6 class="m-0 ms-2">Random Customer5</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magni
                        praesentium, similique molestiae iusto ducimus culpa maxime dicta
                        in deserunt!
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More >>></a>
        </div>
    </div>

    <!-- About Us Start -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">About Us</h2>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-light rounded">
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
            <div class="col-lg-4 col-md-4">
                <?php
                $store_r = selectAll('store');
                $path = STORE_IMG_PATH;
                while ($row = mysqli_fetch_assoc($store_r)) {
                    echo <<<data
          <img src="$path$row[store_image]" alt="Apple Store" class="w-100 rounded">
          data;
                }
                ?>
            </div>
        </div>
    </div>


    <!-- contact us or Reach us start -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-light rounded">
                <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe']; ?>" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-light p-4 rounded mb-3">
                    <h5>Call us</h5>
                    <a href="tel:+9779861252006" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1']; ?>
                    </a>
                    <br />

                    <?php
                    if ($contact_r['pn2'] != '') {
                        $pn2 = $contact_r['pn2'];
                        echo <<<data
             <a href="+$pn2" class="d-inline-block mb-2 text-decoration-none text-dark">
             <i class="bi bi-telephone-fill"></i> +$pn2
             </a>
          data;
                    }
                    ?>
                </div>
                <div class="bg-light p-4 rounded">
                    <h5>Follow us</h5>
                    <a href="<?php echo $contact_r['fb']; ?>" class="d-inline-block mb-2" target="_blank">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </span>
                    </a>
                    <br />
                    <a href="<?php echo $contact_r['insta']; ?>" class="d-inline-block" target="_blank">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i>Instagram
                        </span>
                    </a>
                    <br>
                    <?php
                    if ($contact_r['tw'] != '') {
                        $tw = $contact_r['tw'];
                        echo <<<data
            <a href="$tw" class="d-inline-block mb-2" target="_blank">
              <span class="badge bg-light text-dark fs-6 p-2">
                <i class="bi bi-twitter me-1"></i>Twitter
              </span>
            </a>
          data;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    require('Includes\footer.php');
    ?>

    <!-- Testimonial swiper js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 3,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
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

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
    <script src="Scripts/registerScript.js"></script>
</body>

</html>