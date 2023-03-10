<?php
session_start();
require('functions.php');
$jabatan = mysqli_query($link, "select * FROM jabatan");
$bidang = mysqli_query($link, "select * FROM bidang");
if (isset($_POST['submit'])) {
    addData($_POST);
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
        $active_sidebar = 'tambah_karyawan';
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
                        <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
                    </div>

                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">

                                            <form action="" method="post" enctype="multipart/form-data">

                                                <li class="input-group mb-2 ">
                                                    <label for="nama" class="input-group-text  "> Nama Karyawan
                                                    </label>
                                                    <input type="text" name="nama" id="nama" required
                                                        class="form-control">
                                                </li>
                                                <li class="input-group mb-2">
                                                    <label for="nip" class="input-group-text"> NIP</label>
                                                    <input type="number" name="nip" id="nip" required
                                                        class="form-control">
                                                </li>
                                                <li class=" input-group mb-2">
                                                    <label for="jabatan" class="input-group-text">Jabatan:</label>

                                                    <select name="jabatan" id="jabatan" required class="form-control">
                                                        <?php while ($result = mysqli_fetch_assoc($jabatan)): ?>
                                                            <option value="<?php echo $result['idJabatan'] ?>">
                                                                <?php echo $result['nama_jabatan'] ?>
                                                            </option>
                                                        <?php endwhile; ?>


                                                    </select>
                                                </li>
                                                <li class="input-group mb-2">
                                                    <label for="uts" class="input-group-text">photo</label>
                                                    <input type="file" name="image" id="uts" required
                                                        class="form-control">
                                                </li>
                                                <li class="input-group mb-2">
                                                    <label for="uts" class="input-group-text">Alamat</label>
                                                    <input type="text-area" name="alamat" id="uts" required
                                                        class="form-control">
                                                </li>
                                                <li class=" input-group mb-2">
                                                    <label for="bidang" class="input-group-text">Bidang:</label>

                                                    <select name="bidang" id="bidang" required class="form-control">
                                                        <?php while ($result = mysqli_fetch_assoc($bidang)): ?>
                                                            <option value="<?php echo $result['idBidang'] ?>">
                                                                <?php echo $result['nama_bidang'] ?>
                                                            </option>
                                                        <?php endwhile; ?>


                                                    </select>
                                                </li>

                                                <input type="submit" name="submit" class="btn btn-primary"
                                                    value="Submit">
                                                <a href="karyawan.php" class="btn btn-default">Cancel</a>


                                            </form>
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