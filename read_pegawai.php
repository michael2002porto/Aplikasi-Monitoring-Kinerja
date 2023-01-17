<?php
session_start();
require('functions.php');
$id = $_GET['idPegawai'];
$karyawan = query("SELECT pegawai.idPegawai as idPegawai, pegawai.photo as photo, pegawai.nip as nip, pegawai.nama_peg as nama_peg, jabatan.nama_jabatan as jabatan, pegawai.alamat as alamat FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.idJabatan WHERE pegawai.idPegawai = $id")[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitoring Kinerja - Bidang - Create Jabatan</title>
    <!-- <style>
        * {
            border: red 1px solid
        }
    </style> -->

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

        $active_sidebar = 'daftar_karyawan';
        include "template/sidebar_v.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include "template/topbar_v.php";
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">



                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Info Karyawan</h1>
                    </div>
                    <form class="form-inline pull-right" method="post">
                        <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
                    </form>

                    <div class="col-md-12 my-3 ">
                        <div class="card ">
                            <div class="d-flex flex-row">
                                <table cellpadding="10">
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>
                                            <?= $karyawan['nama_peg'] ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>NIP</td>
                                        <td>:</td>
                                        <td>
                                            <?= $karyawan['nip'] ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>jabatan</td>
                                        <td>:</td>
                                        <td>
                                            <?= $karyawan['jabatan'] ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>
                                            <?= $karyawan['alamat'] ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>photo</td>
                                        <td>:</td>
                                        <td>
                                            <img src="./img/<?= $karyawan['photo']; ?>" height="150px"
                                                class="card-img-top" alt="<?= $karyawan['nama_peg']; ?>">
                                        </td>

                                    </tr>


                                </table>
                            </div>
                            <button a href="karyawan.php">back</button>


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