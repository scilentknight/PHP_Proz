<?php
require('../inc/dbconfig.php');
require('../inc/essentials.php');
adminLogin();

// facility section
if (isset($_POST['add_facility'])) {
    $frm_data = filteration($_POST);
    $img_r = uploadSvgImage($_FILES['icon'], FACILITIES_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upload_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `facilities` (`icon`, `name`, `description`) VALUES (?,?,?)";
        $values = [$img_r, $frm_data['name'], $frm_data['desc']];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}

if (isset($_POST['get_facilities'])) {
    $result = selectAll('facilities');
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $path = FACILITIES_IMG_PATH;
        echo <<<data
           <tr class="align-middle">
             <td>$i</td>
             <td><img src="$path$row[icon]" alt="" width="50px"></td>
             <td>$row[name]</td>
             <td>$row[description]</td>
             <td>
             <button type="button" onclick="remove_facility($row[id])" class="btn btn-danger btn-sm shadow-none">
                 <i class="bi bi-trash"></i> Delete
             </button>
             </td>
           </tr>
        data;
        $i++;
    }
}

if (isset($_POST['remove_facility'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['remove_facility']];
    $pre_q = "SELECT * FROM `facilities` WHERE `id`=?";
    $result = select($pre_q, $values, "i");
    $img = mysqli_fetch_assoc($result);

    if (deleteImage($img['icon'], FACILITIES_FOLDER)) {
        $q = "DELETE FROM `facilities` WHERE id=?";
        $result = delete($q, $values, 'i');
        echo $result;
    } else {
        echo 0;
    }
}

?>