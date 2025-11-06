<?php
require('../inc/dbconfig.php');
require('../inc/essentials.php');
adminLogin();

// carousel section
if (isset($_POST['add_image'])) {
    $img_r = uploadImage($_FILES['picture'], CAROUSEL_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upload_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `carousel` (`image`) VALUES (?)";
        $values = [$img_r];
        $res = insert($q, $values, 's');
        echo $res;
    }
}

if (isset($_POST['get_carousel'])) {
    $result = selectAll('carousel');
    while ($row = mysqli_fetch_assoc($result)) {
        $path = CAROUSEL_IMG_PATH;
        echo <<<data
           <div class="col-md-3 mb-3">
                <div class="card bg-dark text-white">
                    <img src="$path$row[image]" alt="">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="remove_image($row[sn])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
        </div>
        data;
    }
}

if (isset($_POST['remove_image'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['remove_image']];
    $pre_q = "SELECT * FROM `carousel` WHERE `sn`=?";
    $result = select($pre_q, $values, "i");
    $img = mysqli_fetch_assoc($result);

    if (deleteImage($img['image'], CAROUSEL_FOLDER)) {
        $q = "DELETE FROM `carousel` WHERE sn=?";
        $result = delete($q, $values, 'i');
        echo $result;
    } else {
        echo 0;
    }
}

// store section
if (isset($_POST['add_store'])) {
    $frm_data = filteration($_POST);
    $img_r = uploadImage($_FILES['store_image'], STORE_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upload_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `store` (`store_name`, `store_image`) VALUES (?, ?)";
        $values = [$frm_data['store_name'], $img_r];
        $res = insert($q, $values, 'ss');
        echo $res;
    }
}

if (isset($_POST['get_store'])) {
    $result = selectAll('store');
    while ($row = mysqli_fetch_assoc($result)) {
        $path = STORE_IMG_PATH;
        echo <<<data
           <div class="col-md-2 mb-3">
                <div class="card bg-dark text-white">
                    <img src="$path$row[store_image]" alt="">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="remove_store($row[sn])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                    <p class="card-text text-center px-3 py-2">$row[store_name]</p>
                </div>
        </div>
        data;
    }
}

if (isset($_POST['remove_store'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['remove_store']];
    $pre_q = "SELECT * FROM `store` WHERE `sn`=?";
    $result = select($pre_q, $values, "i");
    $img = mysqli_fetch_assoc($result);

    if (deleteImage($img['store_image'], STORE_FOLDER)) {
        $q = "DELETE FROM `store` WHERE sn=?";
        $result = delete($q, $values, 'i');
        echo $result;
    } else {
        echo 0;
    }
}

// choose us section
if (isset($_POST['add_chooseus'])) {
    $frm_data = filteration($_POST);
    $img_r = uploadImage($_FILES['chooseus_image'], CHOOSEUS_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upload_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `chooseus` (`chooseus_name`, `chooseus_image`) VALUES (?, ?)";
        $values = [$frm_data['chooseus_name'], $img_r];
        $res = insert($q, $values, 'ss');
        echo $res;
    }
}

if (isset($_POST['get_chooseus'])) {
    $result = selectAll('chooseus');
    while ($row = mysqli_fetch_assoc($result)) {
        $path = CHOOSEUS_IMG_PATH;
        echo <<<data
           <div class="col-md-2 mb-3">
                <div class="card bg-dark text-white">
                    <img src="$path$row[chooseus_image]" alt="">
                    <div class="card-img-overlay text-end">
                        <button type="button" onclick="remove_chooseus($row[sn])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                    <p class="card-text text-center px-3 py-2">$row[chooseus_name]</p>
                </div>
        </div>
        data;
    }
}

if (isset($_POST['remove_chooseus'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['remove_chooseus']];
    $pre_q = "SELECT * FROM `chooseus` WHERE `sn`=?";
    $result = select($pre_q, $values, "i");
    $img = mysqli_fetch_assoc($result);

    if (deleteImage($img['chooseus_image'], CHOOSEUS_FOLDER)) {
        $q = "DELETE FROM `chooseus` WHERE sn=?";
        $result = delete($q, $values, 'i');
        echo $result;
    } else {
        echo 0;
    }
}

?>