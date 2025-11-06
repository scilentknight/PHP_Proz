<?php
require('inc/essentials.php');
require('inc/dbconfig.php');
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as reed!');
        } else {
            alert('error', 'Operation failed!');
        }

    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `sn`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as reed!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All Data deleted!');
        } else {
            alert('error', 'Operation failed!');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sn`=?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php
    require('inc/links.php');
    ?>
</head>

<body class="bg-light">
    <?php
    require('inc/header.php')
        ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER QUERIES</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm confirm-readAll"><i
                                    class="bi bi-check-all"> </i>Mark as read</a>
                            <a href="?del=all"
                                class="btn btn-danger rounded-pill shadow-none btn-sm confirm-deleteAll"><i
                                    class="bi bi-trash"> </i> Delete all</a>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th scope="col" class="bg-dark text-light">S.N</th>
                                        <th scope="col" class="bg-dark text-light">Name</th>
                                        <th scope="col" class="bg-dark text-light">Email</th>
                                        <th scope="col" class="bg-dark text-light" width="20%">Subject</th>
                                        <th scope="col" class="bg-dark text-light" width="30%">Message</th>
                                        <th scope="col" class="bg-dark text-light">Date</th>
                                        <th scope="col" class="bg-dark text-light">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM `user_queries` ORDER BY `sn` DESC";
                                    $data = mysqli_query($con, $query);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {

                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[sn]' class='btn btn-sm rounded-pill btn-primary confirm-read'>Read</a>";
                                        }
                                        $seen .= "<a href='?del=$row[sn]' class='btn btn-sm rounded-pill btn-danger mt-2 confirm-delete' data-msg='Are you sure you want to delete this record?'>Delete</a>";
                                        ;
                                        echo <<<query
                                        <tr class="align-middle">
                                            <td>$i</td>
                                            <td>$row[name]</td>
                                            <td>$row[email]</td>
                                            <td>$row[subject]</td>
                                            <td>$row[message]</td>
                                            <td>$row[date]</td>
                                            <td>$seen</td>
                                        </tr>
                                        query;
                                        $i++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteLinks = document.querySelectorAll(".confirm-delete");

            deleteLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    const message = this.dataset.msg || "Are you sure you want to delete?";
                    if (!confirm(message)) {
                        e.preventDefault(); // Stop the default navigation
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const deleteAllBtn = document.querySelector(".confirm-deleteAll");

            if (deleteAllBtn) {
                deleteAllBtn.addEventListener("click", function (e) {
                    const confirmed = confirm("Are you sure you want to delete all data?");
                    if (!confirmed) {
                        e.preventDefault(); // Cancel navigation if not confirmed
                    }
                });
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const readLinks = document.querySelectorAll(".confirm-read");

            readLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    const message = this.dataset.msg || "Are you sure you want to read?";
                    if (!confirm(message)) {
                        e.preventDefault(); // Stop the default navigation
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const readAllBtn = document.querySelector(".confirm-readAll");

            if (readAllBtn) {
                readAllBtn.addEventListener("click", function (e) {
                    const confirmed = confirm("Are you sure you want to read all data?");
                    if (!confirmed) {
                        e.preventDefault(); // Cancel navigation if not confirmed
                    }
                });
            }
        });

    </script>


    <?php require('inc/scripts.php'); ?>
</body>

</html>