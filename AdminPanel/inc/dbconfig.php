<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'ercelstore';

// $host = 'sql204.infinityfree.com';
// $user = 'if0_40351630';
// $pass = 'Hosting512';
// $db = 'if0_40351630_ercelstore';

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Can not connect to database" . mysqli_connect_error());
}

function filteration($data)
{
    foreach ($data as $key => $value) {
        // trim(); // remove extra spaces
        // stripslashes(); // remove backward slashes
        // htmlspectialchars(); // html special characters convert into html entities
        // strip_tags(); // remove html tags or block to run
        $value = trim($value);
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = strip_tags($value);
        $data[$key] = $value;
    }
    return $data;
}


function selectAll($table)
{
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
}
function select($sql, $values, $datatypes)
{
    // $query = "SELECT * FROM `admin` WHERE `email` = ? AND `password` = ?";
    // $values = [$frm_data['email'], $frm_data['password']];
    // $datatypes = "ss"; // email is string type and password is string type
    // select($query, $values, $datatypes);
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - select");
        }
    } else {
        die("Query can not be prepared - Select");
    }

}
function update($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Update");
        }
    } else {
        die("Query can not be prepared - Update");
    }

}

function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Insert");
        }
    } else {
        die("Query can not be prepared - Insert");
    }

}

function delete($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Delete");
        }
    } else {
        die("Query can not be prepared - Delete");
    }

}

?>