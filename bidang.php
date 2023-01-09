<?php
//inisialisasi session
session_start();
//menyertakan file program functions.php pada register
require('functions.php');
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    alert($_SESSION['msg']);
    // header('Location: login.php');
    echo '<script type="text/javascript">';
    echo 'window.location.href = "login.php";';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitoring Kinerja - Bidang - Daftar Bidang</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        $active_sidebar = 'daftar_bidang';
        include "template/sidebar_v.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include "template/topbar_v2.php";
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Bidang</h1>
                    </div>

                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-inline pull-right" method="get">
                                        <input class="form-control mr-sm-2" type="search" name="search"
                                            placeholder="Search" aria-label="Search">
                                        <button class="btn btn-outline-success my-2 my-sm-0"
                                            type="submit">Search</button>
                                    </form>
                                    <br><br><br>
                                    <?php
                                    // Include config file
                                    require_once "config.php";

                                    // Attempt select query execution
                                    $batas = 5;
                                    $halaman = @$_GET['halaman'];
                                    if (empty($halaman)) {
                                        $posisi = 0;
                                        $halaman = 1;
                                    } else {
                                        $posisi = ($halaman - 1) * $batas;
                                    }

                                    if (isset($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $sql = "SELECT * FROM bidang WHERE nama_bidang LIKE '%$search%' ORDER BY idBidang ASC LIMIT $posisi, $batas";
                                    } else {
                                        $sql = "SELECT * FROM bidang ORDER BY idBidang ASC LIMIT $posisi, $batas";
                                    }

                                    if ($result = mysqli_query($link, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            ?>

                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Bidang</th>
                                                                <th>Pengaturan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1 + $posisi;
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                ?>

                                                                <tr>
                                                                    <td>
                                                                        <?= $i ?>
                                                                    </td>
                                                                    <td><?= $row['nama_bidang'] ?></td>
                                                                    <td>
                                                                        <?php
                                                                        echo "<a href='update_bidang.php?id=" . $row['idBidang'] . "' title='Update record' data-toggle='tooltip'><span class='fas fa-pen'>
                                                            </span></a>";
                                                                        echo "<a href='delete_bidang.php?id=" . $row['idBidang'] . "' title='Delete record' data-toggle='tooltip'><span class='fas fa-trash'>
                                                            </span></a>";
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Pagination -->
                                            <ul class="pagination">
                                                <?php
                                                if (isset($_GET['search'])) {
                                                    $search = $_GET['search'];
                                                    $query2 = "SELECT * FROM bidang WHERE nama_bidang LIKE '%$search%' ORDER BY idBidang ASC";
                                                } else {
                                                    $query2 = "SELECT * FROM bidang ORDER BY nama_bidang ASC";
                                                }

                                                $result2 = mysqli_query($link, $query2);
                                                $jmldata = mysqli_num_rows($result2);
                                                $jmlhalaman = ceil($jmldata / $batas);

                                                for ($i = 1; $i <= $jmlhalaman; $i++) {
                                                    if ($i != $halaman) {
                                                        if (isset($_GET['search'])) {
                                                            $search = $_GET['search'];
                                                            echo "<li class='page-item'><a class='page-link' href='bidang.php?halaman=$i&search=$search'>$i</a></li>";
                                                        } else {
                                                            echo "<li class='page-item'><a class='page-link' href='bidang.php?halaman=$i'>$i</a></li>";
                                                        }
                                                    } else {
                                                        echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>

                                            <?php
                                            // Free result set
                                            mysqli_free_result($result);
                                        } else {
                                            ?>

                                            <p class="lead"><em>No records were found</em></p>

                                            <?php
                                        }
                                    } else {
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                    }

                                    // CLose connection
                                    mysqli_close($link);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php
            include "template/footer_v.php";
            ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php
    include "template/tools_v.php";
    ?>

</body>

</html>