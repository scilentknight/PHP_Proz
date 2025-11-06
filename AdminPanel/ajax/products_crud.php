<?php
require('../inc/dbconfig.php');
require('../inc/essentials.php');
adminLogin();

// facility section
if (isset($_POST['add_product'])) {
    $frm_data = filteration($_POST);
    $img_r = uploadImage($_FILES['image'], PRODUCTS_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upload_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `products` (`item`, `modal`, `variant`, `color`, `price`, `specs`, `image`, `status`) VALUES (?,?,?,?,?,?,?,?)";
        $values = [$frm_data['item'], $frm_data['modal'], $frm_data['variant'], $frm_data['color'], $frm_data['price'], $frm_data['specs'], $img_r, $frm_data['status']];
        $res = insert($q, $values, 'ssssssss');
        echo $res;
    }
}

if (isset($_POST['get_products'])) {
    $result = selectAll('products');
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $path = PRODUCTS_IMG_PATH;
        $specs = nl2br(htmlspecialchars($row['specs'])); // line breake
        echo <<<data
           <tr class="align-middle">
             <td>$i</td>
             <td>{$row['item']}</td>
             <td>{$row['modal']}</td>
             <td>{$row['variant']}</td>
             <td>{$row['color']}</td>
             <td>{$row['price']}</td>
             <td>$specs</td>
             <td><img src="$path{$row['image']}" alt="" width="50px"></td>
             <td>{$row['status']}</td>
             <td>
             <button type="button" onclick="remove_product({$row['id']})" class="btn btn-danger btn-sm shadow-none">
                 <i class="bi bi-trash"></i> Delete
             </button>
             </td>
           </tr>
        data;
        $i++;
    }
}


if (isset($_POST['remove_product'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['remove_product']];
    $pre_q = "SELECT * FROM `products` WHERE `id`=?";
    $result = select($pre_q, $values, "i");
    $img = mysqli_fetch_assoc($result);

    if (deleteImage($img['image'], PRODUCTS_FOLDER)) {
        $q = "DELETE FROM `products` WHERE id=?";
        $result = delete($q, $values, 'i');
        echo $result;
    } else {
        echo 0;
    }
}

?>