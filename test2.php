<?php
session_start();
require('functions.php');

$karyawan = query("SELECT * FROM pegawai");

$jumlahdata = count($karyawan);
$batas = 3;
$banyaknyahalaman = ceil($jumlahdata / $batas);

$halaman = 1;
if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
}

$posisi = ($halaman - 1) * $batas;

if (isset($_POST['cari'])) {
    if (search($_POST['search']) > 0) {
        $karyawan = search($_POST['search']);
    } else {
        $karyawan = query("SELECT * FROM pegawai LIMIT $posisi,$batas");
    }
} else {
    $karyawan = query("SELECT * FROM pegawai LIMIT $posisi,$batas");
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

    <title>Monitoring Kinerja - Bidang - Create Jabatan</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Daftar Karyawan</h1>
                    </div>

                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-body border-black">
                                            <div class="col-md-12 my-3">
                                                <div class="card">

                                                    <?php if (count($karyawan) > 0): ?>
                                                        <?php foreach ($karyawan as $pegawai): ?>
                                                            <div class="card mb-3" style="max-width: 540px;">
                                                                <div class="row g-0">
                                                                    <div class="col-md-4">
                                                                        <img src="..." class="img-fluid rounded-start"
                                                                            alt="...">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">Card title</h5>
                                                                            <p class="card-text">This is a wider card with
                                                                                supporting text below as a natural lead-in to
                                                                                additional content. This content is a little bit
                                                                                longer.</p>
                                                                            <p class="card-text"><small class="text-muted">Last
                                                                                    updated 3 mins ago</small></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p class="lead"><em>No Records were found</em></p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <nav aria-label="Page navigation example d">
                                                            <ul class="pagination">
                                                                <?php for ($i = 1; $i <= $banyaknyahalaman; $i++): ?>
                                                                    <?php if ($i == $halaman): ?>
                                                                        <li class="page-item"><a class="page-link active"
                                                                                href="?halaman=<?= $i; ?>">
                                                                                <?= $i; ?>
                                                                            </a></li>
                                                                    <?php else: ?>
                                                                        <li class="page-item"><a class="page-link"
                                                                                href="?halaman=<?= $i; ?>">
                                                                                <?= $i; ?>
                                                                            </a></li>
                                                                    <?php endif; ?>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        </nav>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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