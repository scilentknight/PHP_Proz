<?php
session_start();
require_once('Includes/header.php');

// Check product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid product ID.";
    exit();
}

$product_id = intval($_GET['id']);
$customer_id = $_SESSION['cid']; // Assuming 'cid' is stored here

// Fetch customer details
$customer_q = $con->prepare("SELECT * FROM customer WHERE cid = ?");
$customer_q->bind_param("i", $customer_id);
$customer_q->execute();
$customer_res = $customer_q->get_result();

if ($customer_res->num_rows === 0) {
    echo "Customer not found.";
    exit();
}
$customer = $customer_res->fetch_assoc();

// Fetch product details
$product_q = $con->prepare("SELECT * FROM products WHERE id = ?");
$product_q->bind_param("i", $product_id);
$product_q->execute();
$product_res = $product_q->get_result();

if ($product_res->num_rows === 0) {
    echo "Product not found.";
    exit();
}
$product = $product_res->fetch_assoc();

// Handle form submission
$order_success = false;
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity']);
    $payment_method = htmlspecialchars(trim($_POST['payment_method']));

    if ($quantity < 1) {
        $error_msg = "Quantity must be at least 1.";
    } elseif (!in_array($payment_method, ['cod', 'khalti'])) {
        $error_msg = "Invalid payment method.";
    } else {
        $unit_price = floatval($product['price']);
        $total_price = $unit_price * $quantity;
        $product_name = $product['item'] . ' ' . $product['modal'];

        $insert_q = $con->prepare("INSERT INTO customer_orders (name, email, phone, address, payment_method, product_id, product_name, quantity, unit_price, total_price)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_q->bind_param(
            "sssssissdd",
            $customer['name'],
            $customer['email'],
            $customer['phone'],
            $customer['address'],
            $payment_method,
            $product_id,
            $product_name,
            $quantity,
            $unit_price,
            $total_price
        );

        $order_success = $insert_q->execute();

        if (!$order_success) {
            $error_msg = "Failed to place order. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <style>
        .card {
            border-radius: 1rem;
        }

        .card-title {
            font-weight: bold;
        }

        .btn-lg {
            font-size: 1.1rem;
        }
    </style>

</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">
                            <i class="bi bi-cart-check-fill text-success"></i> Confirm Your Order
                        </h3>
                        <h5 class="text-muted text-center mb-4">
                            <?= htmlspecialchars($product['item'] . ' ' . $product['modal']) ?>
                        </h5>

                        <?php if ($order_success): ?>
                                <div class="alert alert-success text-center">
                                    <strong>Success!</strong> Your order has been placed successfully.
                                </div>
                                <div class="text-center">
                                    <a href="products.php" class="btn btn-primary">Back to Products</a>
                                </div>
                        <?php else: ?>
                                <?php if ($error_msg): ?>
                                        <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
                                <?php endif; ?>

                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-person-circle"></i> Customer Name</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($customer['name']) ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Address</label>
                                        <textarea class="form-control" disabled
                                            rows="1"><?= htmlspecialchars($customer['address']) ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-bag-plus-fill"></i> Quantity</label>
                                        <div class="input-group" style="max-width: 180px;">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity(-1)">−</button>
                                            <input type="number" name="quantity" id="quantity" class="form-control text-center"
                                                value="1" min="1" max="5" required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity(1)">+</button>
                                        </div>
                                        <small class="text-muted">Max 5 units per order</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label"><i class="bi bi-credit-card-2-front-fill"></i> Payment
                                            Method</label>
                                        <select name="payment_method" class="form-select" required>
                                            <option value="cod">Cash on Delivery</option>
                                            <option value="khalti">Pay with Khalti</option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-check-circle"></i>
                                            Confirm Order</button>
                                        <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeQuantity(delta) {
            const input = document.getElementById('quantity');
            let val = parseInt(input.value);
            if (!val || val < 1) val = 1;
            val += delta;
            if (val < 1) val = 1;
            if (val > 5) val = 5;
            input.value = val;
        }
    </script>

</body>

</html>