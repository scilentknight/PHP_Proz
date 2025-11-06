<?php
session_start();
require('Includes/header.php');

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get product ID and action
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : 'add';

if ($product_id <= 0) {
    echo "Invalid product ID.";
    exit;
}

// Handle actions
switch ($action) {
    case 'add':
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
        break;

    case 'increase':
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        }
        break;

    case 'decrease':
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]--;
            if ($_SESSION['cart'][$product_id] < 1) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$product_id]);
        break;

    default:
        echo "Invalid action.";
        exit;
}

redirect('cart_view.php');
?>