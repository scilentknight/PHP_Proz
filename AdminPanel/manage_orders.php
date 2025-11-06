<?php
require('inc/essentials.php');
require('inc/dbconfig.php');
adminLogin();

if (isset($_GET['accept'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['accept'] == 'all') {
        $q = "UPDATE `customer_orders` SET `status`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'All orders accepted!');
        } else {
            alert('error', 'Operation failed!');
        }

    } else {
        $q = "UPDATE `customer_orders` SET `status`=? WHERE `id`=?";
        $values = [1, $frm_data['accept']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Order accepted!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}

if (isset($_GET['reject'])) {
    $frm_data = filteration($_GET);

    // Reject all orders
    if ($frm_data['reject'] == 'all') {
        $q = "UPDATE `customer_orders` SET `status` = ?";
        $values = [2]; // Assuming 2 = rejected
        if (update($q, $values, 'i')) {
            alert('success', 'All orders marked as rejected!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
    // Reject a single order
    else {
        $q = "UPDATE `customer_orders` SET `status` = ? WHERE `id` = ?";
        $values = [2, $frm_data['reject']]; // 2 = rejected
        if (update($q, $values, 'ii')) {
            alert('success', 'Order marked as rejected!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Orders</title>
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
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">MANAGE ORDERS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?accept=all"
                                class="btn btn-dark rounded-pill shadow-none btn-sm confirm-acceptAll"><i
                                    class="bi bi-check-all"> </i>Accept all</a>
                            <a href="?reject=all"
                                class="btn btn-danger rounded-pill shadow-none btn-sm confirm-rejectAll"><i
                                    class="bi bi-trash"> </i> Reject all</a>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th scope="col" class="bg-dark text-light">S.N</th>
                                        <th scope="col" class="bg-dark text-light">Name</th>
                                        <th scope="col" class="bg-dark text-light">Email</th>
                                        <th scope="col" class="bg-dark text-light">Phone</th>
                                        <th scope="col" class="bg-dark text-light">Address</th>
                                        <th scope="col" class="bg-dark text-light">Payment</th>
                                        <th scope="col" class="bg-dark text-light">Pid</th>
                                        <th scope="col" class="bg-dark text-light">Price</th>
                                        <th scope="col" class="bg-dark text-light">Total</th>
                                        <th scope="col" class="bg-dark text-light">Date</th>
                                        <th scope="col" class="bg-dark text-light">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM `customer_orders` ORDER BY `id` DESC";
                                    $data = mysqli_query($con, $query);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {

                                        $action = '';

                                        if ($row['status'] == 1) {
                                            $action = "<span class='badge bg-success'>Accepted</span>";
                                        } elseif ($row['status'] == 2) {
                                            $action = "<span class='badge bg-danger'>Rejected</span>";
                                        } else {
                                            $acceptBtn = "<a href='?accept=$row[id]' class='btn btn-sm rounded-pill btn-primary confirm-accept'>$row[status]</a>";
                                            $rejectBtn = "<a href='?reject=$row[id]' class='btn btn-sm rounded-pill btn-danger mt-2 confirm-reject' data-msg='Are you sure you want to reject this order?'>Reject</a>";
                                            $action = "$acceptBtn $rejectBtn";
                                        }

                                        echo <<<query
                                        <tr class="align-middle">
                                            <td>$i</td>
                                            <td>$row[name]</td>
                                            <td>$row[email]</td>
                                            <td>$row[phone]</td>
                                            <td>$row[address]</td>
                                            <td>$row[payment_method]</td>
                                            <td>$row[id]</td>
                                            <td>$row[unit_price]</td>
                                            <td>$row[total_price]</td>
                                            <td>$row[order_date]</td>
                                            <td>$action</td>
                                        </tr>
                                        query;
                                        $i++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const rejectLinks = document.querySelectorAll(".confirm-reject");

            rejectLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    const message = this.dataset.msg || "Are you sure you want to reject this order?";
                    if (!confirm(message)) {
                        e.preventDefault(); // Stop the default navigation
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const rejectAllBtn = document.querySelector(".confirm-rejectAll");

            if (rejectAllBtn) {
                rejectAllBtn.addEventListener("click", function (e) {
                    const confirmed = confirm("Are you sure you want to reject all orders?");
                    if (!confirmed) {
                        e.preventDefault(); // Cancel navigation if not confirmed
                    }
                });
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const acceptLinks = document.querySelectorAll(".confirm-accept");

            acceptLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    const message = this.dataset.msg || "Are you sure you want to accept this order?";
                    if (!confirm(message)) {
                        e.preventDefault(); // Stop the default navigation
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const acceptAllBtn = document.querySelector(".confirm-acceptAll");

            if (acceptAllBtn) {
                acceptAllBtn.addEventListener("click", function (e) {
                    const confirmed = confirm("Are you sure you want to accept all data?");
                    if (!confirmed) {
                        e.preventDefault(); // Cancel navigation if not confirmed
                    }
                });
            }
        });

    </script>


    <?php require('inc/scripts.php'); ?>
</body>

</html>