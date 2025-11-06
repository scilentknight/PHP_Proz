<?php
require('inc/essentials.php');
require('inc/dbconfig.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Customers</title>
  <?php
  require('inc/links.php');
  ?>
</head>

<body class="bg-light">
  <?php require('inc/header.php') ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4 text-center text-decoration-underline">Customer Details</h3>
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="table-responsive" style="height: 450px; overflow-y: scroll;">
              <table class="table table-hover border">
                <thead class="sticky-top" style="z-index: 2;">
                  <tr>
                    <th scope="col" class="bg-dark text-light">S.N</th>
                    <th scope="col" class="bg-dark text-light">Name</th>
                    <th scope="col" class="bg-dark text-light">Email</th>
                    <th scope="col" class="bg-dark text-light">Phone</th>
                    <th scope="col" class="bg-dark text-light">Address</th>
                    <th scope="col" class="bg-dark text-light">Gender</th>
                    <th scope="col" class="bg-dark text-light">Date_of_Birth</th>
                  </tr>
                </thead>
                <tbody id="customer-data">

                  <?php
                  $query = "SELECT * FROM `customer` ORDER BY `cid` DESC";
                  $data = mysqli_query($con, $query);
                  $i = 1;

                  while ($row = mysqli_fetch_assoc($data)) {
                    echo <<<query
                      <tr class="align-middle">
                          <td>$i</td>
                          <td>$row[name]</td>
                          <td>$row[email]</td>
                          <td>$row[phone]</td>
                          <td>$row[address]</td>
                          <td>$row[gender]</td>
                          <td>$row[date_of_birth]</td>
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

  <?php require('inc/scripts.php'); ?>
  <!-- <script src="scripts/customers-backend.js"></script> -->
</body>

</html>