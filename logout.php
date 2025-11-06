<?php
session_start();
require_once('AdminPanel/inc/essentials.php');

if (isset($_SESSION['cart'])) {
    setcookie('saved_cart', json_encode($_SESSION['cart']), time() + (86400 * 7), "/"); // store for 7 days
}

session_unset();
session_destroy();

redirect('index.php');
exit;


?>