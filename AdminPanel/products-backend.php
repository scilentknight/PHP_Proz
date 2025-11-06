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
  <title>Admin Panel - Products</title>
  <?php
  require('inc/links.php');
  ?>
</head>

<body class="bg-light">
  <?php require('inc/header.php') ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">Products</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="text-end mb-4">
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                data-bs-target="#add-product-s">
                <i class="bi bi-plus-square"></i> Add
              </button>
            </div>

            <div class="table-responsive" style="height: 450px; overflow-y: scroll;">
              <table class="table table-hover border">
                <thead class="sticky-top" style="z-index: 2;">
                  <tr>
                    <th scope="col" class="bg-dark text-light">S.N</th>
                    <th scope="col" class="bg-dark text-light">Item</th>
                    <th scope="col" class="bg-dark text-light">Modal</th>
                    <th scope="col" class="bg-dark text-light">Variant</th>
                    <th scope="col" class="bg-dark text-light">Color</th>
                    <th scope="col" class="bg-dark text-light">Price</th>
                    <th scope="col" class="bg-dark text-light">Specs</th>
                    <th scope="col" class="bg-dark text-light">Image</th>
                    <th scope="col" class="bg-dark text-light">Status</th>
                    <th scope="col" class="bg-dark text-light">Action</th>
                  </tr>
                </thead>
                <tbody id="products-data">
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="modal fade" id="add-product-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="add_product_form" autocomplete="off">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Product</h5>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Item</label>
                      <input type="text" name="items" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Modal</label>
                      <input type="text" name="modal" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Variant</label>
                      <input type="text" name="variant" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Color</label>
                      <input type="text" name="color" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Price</label>
                      <input type="number" name="price" class="form-control shadow-none" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Specs</label>
                      <textarea name="specs" class="form-control shadow-none" rows="5" required></textarea>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Image</label>
                      <input type="file" name="image" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none"
                        required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <label class="form-label fw-bold">Status</label>
                      <input type="text" name="status" class="form-control shadow-none" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="reset" class="btn btn-text-secondary shadow-none"
                    data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php require('inc/scripts.php'); ?>
  <script src="scripts/products-backend.js"></script>
</body>

</html>