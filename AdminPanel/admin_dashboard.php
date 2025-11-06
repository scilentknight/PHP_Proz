<?php
require('inc/essentials.php');
require('inc/dbconfig.php');
adminLogin();


$customerCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM customer"))['total'];
$queryCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM user_queries"))['total'];
$orderCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM customer_orders"))['total'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php
    require('inc/links.php');
    ?>
</head>

<body class="bg-light">
    <?php
    require('inc/header.php')
        ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden"> <!-- main content area -->
                <h3 class="mb-4 text-center text-decoration-underline">Admin Dashboard</h3>

                <div class="row g-4">
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column text-center"
                                style="min-height: 150px;">
                                <h5 class="card-title">Total Customers</h5>
                                <p class="card-text fs-4"><?= $customerCount ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column text-center"
                                style="min-height: 150px;">
                                <h5 class="card-title">Total User Queries</h5>
                                <p class="card-text fs-4"><?= $queryCount ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card text-white bg-warning shadow">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column text-center"
                                style="min-height: 150px;">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="card-text fs-4"><?= $orderCount ?></p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <?php
    require('inc/scripts.php');
    ?>
</body>

</html>