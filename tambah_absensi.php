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

    // Include config file
    require_once "config.php";

    $sqlPegawai = "SELECT * FROM pegawai";
	$all_pegawai = mysqli_query($link,$sqlPegawai);

    // Tentukan variabel dan inisialisasi dengan nilai kosong
    $namaPegawai = $jamMasuk = $jamKeluar = $status = "";
    $namaPegawai_err = $status_err = "";

    // Memproses data formulir saat formulir dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Mendapatkan jam sekarang
        date_default_timezone_set('Asia/Jakarta');
        $waktu = date('Y-m-d H:i:s');

        // Validate id pegawai
        $input_pegawai = trim($_POST["nama_pegawai"]);
        if (empty($input_pegawai)) {
            $pegawai_err = "Please enter the pegawai";
        } elseif (!ctype_digit($input_pegawai)) {
            $pegawai_err = "Please enter a positive integer value";
        } else {
            $pegawai = $input_pegawai;
        }

        // Validate satuan
        $input_status = trim($_POST["status_absen"]);
        if (empty($input_status)) {
            $status_err = "Please enter a name";
        } else if (!($input_status != "Masuk" || $input_status != "Keluar")) {
            $status_err = "Status absensi salah";
        } else {
            $status = $input_status;
        }

        if (!empty($status)) {
            if ($status == "Masuk") {
                if (empty($namaPegawai_err) && empty($status_err)) {
                    $sql = "INSERT INTO absensi (id_karyawan, status, absen_masuk) VALUES (?, ?, ?)" ;
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iss", $paramIdPegawai, $paramStatus, $paramAbsenMasuk);

                        $paramIdPegawai = $pegawai;
                        $paramStatus = $status;
                        $paramAbsenMasuk = $waktu;

                        if (mysqli_stmt_execute($stmt)) { 
                            header("location: absensi.php");
                            exit();
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            } else if ($status == "Keluar") {
                if (empty($namaPegawai_err) && empty($status_err)) {
                    $sql = "UPDATE absensi SET absen_pulang = ? WHERE id_karyawan = ? AND absen_pulang IS NULL";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "si", $paramAbsenPulang, $paramIdPegawai);

                        $paramAbsenPulang = $waktu;
                        $paramIdPegawai = $pegawai;

                        if (mysqli_stmt_execute($stmt)) {
                            header('location: absensi.php');
                            exit();
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    // Close connection
    mysqli_close($link);
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

        <title>Monitoring Kinerja - Absensi - Tambah Absensi</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Absensi</h1>
                        </div>

                        <div class="wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                                    <div class="form-group <?php echo (!empty($namaPegawai_err)) ? 'has-error' : ''; ?>">
                                                        <label for="pegawai">Nama Pegawai</label><br>
                                                            <select name="nama_pegawai">
                                                                <option selected disabled>--- Pegawai ---</option>
                                                                <?php
                                                                    while ($namaPegawai = mysqli_fetch_array(
                                                                        $all_pegawai,MYSQLI_ASSOC)){
                                                                ?>
                                                                <option value="<?php echo $namaPegawai["idPegawai"];?>">
                                                                    <?php echo $namaPegawai["nama_peg"];?>
                                                                </option>
                                                                
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        <span class="help-block"><?= $namaPegawai_err ?></span>
                                                    </div>
                                                    <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                                                        <label for="status">Status</label><br>
                                                        <select name="status_absen">
                                                                <option selected disabled>--- Status ---</option>
                                                                <option value="Masuk">Masuk</option>
                                                                <option value="Keluar">Keluar</option>
                                                            </select>
                                                        <span class="help-block"><?= $status_err ?></span>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                    <a href="absensi.php" class="btn btn-default">Cancel</a>
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