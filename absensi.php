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

        <title>Monitoring Kinerja - Pekerjaan - Daftar Bidang</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <?php
                $active_sidebar = 'dashboard';
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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Pekerjaan</h1>
                        </div>

                        <div class="wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-inline pull-right" method="get">
                                            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
                                                $sql = "SELECT k.idPekerjaan, k.uraian_pekerjaan, k.waktu_mulai, k.waktu_selesai, k.status_pekerjaan, p.nama_peg
                                                        FROM pekerjaan k
                                                        INNER JOIN pegawai p ON p.idPegawai = k.id_pegawai
                                                        WHERE uraian_pekerjaan LIKE '%$search%' ORDER BY idPekerjaan ASC LIMIT $posisi, $batas";
                                            } else {
                                                $sql = "SELECT k.idPekerjaan, k.uraian_pekerjaan, k.waktu_mulai, k.waktu_selesai, k.status_pekerjaan, p.nama_peg
                                                        FROM pekerjaan k
                                                        INNER JOIN pegawai p ON p.idPegawai = k.id_pegawai ORDER BY idPekerjaan ASC LIMIT $posisi, $batas";
                                            }

                                            if ($result = mysqli_query($link, $sql)) {
                                                if (mysqli_num_rows($result) > 0) {
                                        ?>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Uraian pekerjaan</th>
                                                    <th>Pegawai</th>
                                                    <th>Waktu Mulai</th>
                                                    <th>Waktu Selesai</th>
                                                    <th>Status</th>
                                                    <th>Pengaturan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i = 1 + $posisi;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                ?>

                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row['uraian_pekerjaan'] ?></td>
                                                    <td><?= $row['nama_peg'] ?></td>
                                                    <td><?= date('d-m-Y H:i:s', strtotime($row['waktu_mulai'])); ?></td>
                                                    <td><?= date('d-m-Y H:i:s', strtotime($row['waktu_selesai'])); ?></td>
                                                    <td><?= $row['status_pekerjaan'] ?></td>
                                                    <td>
                                                        <?php 
                                                            echo "<a href='update_pekerjaan.php?id=" . $row['idPekerjaan'] ."' title='Update record' data-toggle='tooltip'><span class='fas fa-pen'>
                                                            </span></a>";
                                                            echo "<a href='delete_pekerjaan.php?id=" . $row['idPekerjaan'] ."' title='Delete record' data-toggle='tooltip'><span class='fas fa-trash'>
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

                                            <!-- Pagination -->
                                            <ul class="pagination">
                                                <?php
                                                    if (isset($_GET['search'])) {
                                                        $search = $_GET['search'];
                                                        $query2 = "SELECT k.idPekerjaan, k.uraian_pekerjaan, k.waktu_mulai, k.waktu_selesai, k.status_pekerjaan, p.nama_peg
                                                                    FROM pekerjaan k
                                                                    INNER JOIN pegawai p ON p.idPegawai = k.id_pegawai 
                                                                    WHERE uraian_pekerjaan LIKE '%$search%' ORDER BY idPekerjaan ASC";
                                                    } else {
                                                        $query2 = "SELECT k.idPekerjaan, k.uraian_pekerjaan, k.waktu_mulai, k.waktu_selesai, k.status_pekerjaan, p.nama_peg
                                                                    FROM pekerjaan k
                                                                    INNER JOIN pegawai p ON p.idPegawai = k.id_pegawai ORDER BY uraian_pekerjaan ASC";
                                                    }

                                                    $result2 = mysqli_query($link, $query2);
                                                    $jmldata = mysqli_num_rows($result2);
                                                    $jmlhalaman = ceil($jmldata / $batas);

                                                    for ($i = 1; $i <= $jmlhalaman; $i++) {
                                                        if ($i != $halaman) {
                                                            if (isset($_GET['search'])) {
                                                                $search = $_GET['search'];
                                                                echo "<li class='page-item'><a class='page-link' href='pekerjaan.php?halaman=$i&search=$search'>$i</a></li>";
                                                            } else {
                                                                echo "<li class='page-item'><a class='page-link' href='pekerjaan.php?halaman=$i'>$i</a></li>";
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