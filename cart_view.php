<?php
session_start();
require('Includes/header.php');
require('Includes/links.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo <<<html
    <div class="container mt-5 text-center">
        <h4>Your cart is empty 🛒</h4>
        <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
    html;
    exit;
}

require_once('AdminPanel/inc/dbconfig.php');

// Get product data
$product_ids = array_keys($_SESSION['cart']);
$ids = implode(',', array_map('intval', $product_ids));
$q = "SELECT * FROM `products` WHERE `id` IN ($ids)";
$res = mysqli_query($con, $q);

$products = [];
while ($row = mysqli_fetch_assoc($res)) {
    $products[$row['id']] = $row;
}

echo <<<html
<div class="container mt-5">
    <h3 class="mb-4 text-center">Your Cart</h3>
    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>SN</th>
                <th>Product Name</th>
                <th>Price (per unit)</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
html;

$total = 0;
$sn = 1;

foreach ($_SESSION['cart'] as $id => $qty) {
    if (!isset($products[$id]))
        continue;

    $product = $products[$id];
    $name = htmlspecialchars($product['item'] . ' ' . $product['modal']);
    $unit_price = number_format($product['price'], 2);
    $total_price = number_format($product['price'] * $qty, 2);
    $total += $product['price'] * $qty;

    $minus_disabled = ($qty <= 1) ? 'disabled' : '';

    echo <<<row
    <tr>
        <td>{$sn}</td>
        <td>{$name}</td>
        <td>Rs. {$unit_price}</td>
        <td>
            <a href="cart.php?action=decrease&id={$id}" class="btn btn-sm btn-outline-secondary {$minus_disabled}">–</a>
            <span class="mx-2">{$qty}</span>
            <a href="cart.php?action=increase&id={$id}" class="btn btn-sm btn-outline-secondary">+</a>
        </td>
        <td>Rs. {$total_price}</td>
        <td>
            <a href="cart.php?action=remove&id={$id}" class="btn btn-sm btn-outline-danger">Remove</a>
        </td>
    </tr>
    row;

    $sn++;
}

$total_formatted = number_format($total, 2);

echo <<<html
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total</th>
                <th colspan="2" class="text-center">Rs. {$total_formatted}</th>
            </tr>
        </tfoot>
    </table>
    <div class="text-center">
        <a href="index.php" class="btn btn-secondary m-3">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</div>
html;
?>