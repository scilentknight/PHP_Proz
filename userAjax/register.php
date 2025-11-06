<?php
require('../AdminPanel/inc/dbconfig.php');
require('../AdminPanel/inc/essentials.php');

if (isset($_POST['register'])) {
    $frm_data = filteration($_POST);

    // Password match check
    if ($frm_data['password'] !== $frm_data['cpassword']) {
        echo 'pass_mismatch';
        exit;
    }

    // Check if email or phone already exists
    $u_exist = select(
        "SELECT * FROM `customer` WHERE `email` = ? OR `phone` = ? LIMIT 1",
        [$frm_data['email'], $frm_data['phone']],
        'ss'
    );

    if (mysqli_num_rows($u_exist) !== 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_exist_fetch['email'] === $frm_data['email']) {
            echo 'email_exist';
        } else {
            echo 'phone_exist';
        }
        exit;
    }

    // Hash the password
    $enc_pass = password_hash($frm_data['password'], PASSWORD_BCRYPT);

    // Insert the new user
    $query = "INSERT INTO `customer` (`name`, `email`, `phone`, `address`, `gender`, `date_of_birth`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $values = [
        $frm_data['name'],
        $frm_data['email'],
        $frm_data['phone'],
        $frm_data['address'],
        $frm_data['gender'],
        $frm_data['dob'],
        $enc_pass
    ];

    if (insert($query, $values, 'sssssss')) {
        echo 'success';
    } else {
        echo 'failed';
    }
    exit;
} else {
    echo 'failed';
}

?>