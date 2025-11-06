<?php
session_start();
require('Includes/header.php');
require('Includes/links.php');
// require_once('AdminPanel/inc/dbconfig.php');

// Ensure cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
  echo <<<html
    <div class="container mt-5 text-center">
        <h4>Your cart is empty 🛒</h4>
        <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
    html;
  exit;
}

// Fetch product details
$product_ids = array_keys($_SESSION['cart']);
$ids = implode(',', array_map('intval', $product_ids));
$q = "SELECT * FROM `products` WHERE `id` IN ($ids)";
$res = mysqli_query($con, $q);

// Build associative array of product info
$products = [];
while ($row = mysqli_fetch_assoc($res)) {
  $products[$row['id']] = $row;
}

// Calculate totals
$total_price = 0;
$order_items_html = '';
$sn = 1;

foreach ($_SESSION['cart'] as $id => $qty) {
  if (!isset($products[$id]))
    continue;

  $p = $products[$id];
  $name = htmlspecialchars($p['item'] . ' ' . $p['modal']);
  $unit_price = $p['price'];
  $subtotal = $unit_price * $qty;
  $total_price += $subtotal;

  $unit_price_fmt = number_format($unit_price, 2);
  $subtotal_fmt = number_format($subtotal, 2);

  $order_items_html .= <<<html
    <tr>
        <td>{$sn}</td>
        <td>{$name}</td>
        <td>{$qty}</td>
        <td>Rs. {$unit_price_fmt}</td>
        <td>Rs. {$subtotal_fmt}</td>
    </tr>
    html;

  $sn++;
}

$total_price_fmt = number_format($total_price, 2);
?>

<div class="container mt-5">
  <div class="row justify-content-center gx-5 gy-4">
    <!-- Billing Details Form -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <h4 class="mb-4 text-center text-primary">
            <i class="bi bi-credit-card-2-front-fill me-2"></i>Billing Details
          </h4>
          <form method="POST" action="place_order.php" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold"><i class="bi bi-person-fill me-1"></i> Full Name</label>
              <input type="text" name="name" class="form-control form-control-lg shadow-sm" placeholder="Full name"
                required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold"><i class="bi bi-envelope-fill me-1"></i> Email Address</label>
              <input type="email" name="email" class="form-control form-control-lg shadow-sm"
                placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold"><i class="bi bi-phone-fill me-1"></i> Phone Number</label>
              <input type="tel" name="phone" class="form-control form-control-lg shadow-sm"
                placeholder="+977 980xxxxxxx" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold"><i class="bi bi-geo-alt-fill me-1"></i> Shipping Address</label>
              <textarea name="address" class="form-control form-control-lg shadow-sm" rows="1"
                placeholder="Your full address" required></textarea>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold"><i class="bi bi-wallet2 me-1"></i> Payment Method</label>
              <select name="payment_method" class="form-select form-select-lg shadow-sm" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="cod">Cash on Delivery</option>
                <option value="khalti">Pay with Khalti</option>
              </select>
            </div>

            <input type="hidden" name="total" value="<?= htmlspecialchars($total_price) ?>">

            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
              <i class="bi bi-bag-check-fill me-2"></i> Place Order
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Order Summary -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <h4 class="mb-4 text-center text-success">
            <i class="bi bi-receipt-cutoff me-2"></i> Order Summary
          </h4>
          <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
              <thead class="table-light">
                <tr>
                  <th>SN</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?= $order_items_html ?>
              </tbody>
              <tfoot class="table-secondary fw-semibold fs-5">
                <tr>
                  <td colspan="4" class="text-end">Total</td>
                  <td>Rs. <?= htmlspecialchars($total_price_fmt) ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <small class="text-muted d-block mt-3 text-center">
            🛒 Thank you for shopping with us!
          </small>
        </div>
      </div>
    </div>
  </div>
</div>