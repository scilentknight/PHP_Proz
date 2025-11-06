<?php
session_start();

require('Includes/header.php');
// require_once('AdminPanel/inc/dbconfig.php'); // Ensure $con is available

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);

    // Get product details
    $product_ids = array_keys($_SESSION['cart']);
    $ids = implode(',', array_map('intval', $product_ids));

    $q = "SELECT * FROM `products` WHERE `id` IN ($ids)";
    $res = mysqli_query($con, $q);

    $products = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $products[$row['id']] = $row;
    }

    // Save each product in order to customer_orders table
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        if (!isset($products[$product_id]))
            continue;

        $product = $products[$product_id];
        $product_name = $product['item'] . ' ' . $product['modal'];
        $unit_price = $product['price'];
        $total_price = $unit_price * $quantity;

        $insert = "INSERT INTO `customer_orders` 
                (`name`, `email`, `phone`, `address`, `payment_method`, `product_id`, `product_name`, `quantity`, `unit_price`, `total_price`)
                VALUES (
                    '$name', '$email', '$phone', '$address', '$payment_method',
                    '$product_id', '$product_name', '$quantity', '$unit_price', '$total_price'
                )";

        mysqli_query($con, $insert);
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo <<<html
        <div class="container mt-5 text-center">
            <h4>✅ Thank you, {$name}!</h4>
            <p>Your order has been placed and recorded successfully.</p>
            <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
        html;

} else {
    header('Location: checkout.php');
    exit;
}
?>