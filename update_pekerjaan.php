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
    $uraianPekerjaan = $namaPegawai = $waktuMulai = $waktuSelesai = $atatus = "";
    $uraianPekerjaan_err = $namaPegawai_err = $waktuMulai_err = $waktuSelesai_err = $status_err = "";

    // Processing form data when form is submitted
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Get hidden input value
        $id = $_POST["id"];

        // Validate uraian pekerjaan
        $input_uraianPekerjaan = trim($_POST["uraian_pekerjaan"]);
        if (empty($input_uraianPekerjaan)) {
            $uraianPekerjaan_err = "Please enter a name";
        } else {
            $uraianPekerjaan = $input_uraianPekerjaan;
        }

        // Validate satuan
        $input_waktuMulai = $_POST["waktu_mulai"];
        $waktuMulai = $input_waktuMulai;

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
        $input_waktuSelesai = $_POST["waktu_selesai"];
        $waktuSelesai = $input_waktuSelesai;

        // Validate satuan
        $input_status = trim($_POST["status_pekerjaan"]);
        if (empty($input_status)) {
            $waktuSelesai_err = "Please enter a name";
        } else {
            $status = $input_status;
        }


        // Check input errors before updating in database
        if (empty($uraianPekerjaan_err) && empty($namaPegawai_err) && empty($waktuMulai_err) && empty($waktuSelesai_err) && empty($status_err)) {
            // Prepare an update statement
            $sql = "UPDATE pekerjaan SET uraian_pekerjaan=?, id_pegawai=?, waktu_mulai=?, waktu_selesai=?, status_pekerjaan=? WHERE idPekerjaan=?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sisssi", $param_uraianPekerjaan, $param_namaPegawai, $param_waktuMulai, $param_waktuSelesai, $param_status, $param_idPekerjaan);

                // Set parameters
                $param_uraianPekerjaan = $uraianPekerjaan;
                $param_namaPegawai = $pegawai;
                $param_waktuMulai = $waktuMulai;
                $param_waktuSelesai = $waktuSelesai;
                $param_status = $status;
                $param_idPekerjaan = $id;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: pekerjaan.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($link);
    } else {
        // Check existence of id parameter before processing further
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Get URL parameter
            $id = trim($_GET["id"]);

            // Prepare a aselect statement
            $sql = "SELECT * FROM pekerjaan WHERE idPekerjaan = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_id);

                // Set parameters
                $param_id = trim($_GET["id"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) == 1) {
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        // Retrieve individual field value
                        $id = $row["idPekerjaan"];
                        $uraianPekerjaan = $row["uraian_pekerjaan"];
                        $namaPegawai = $row["id_pegawai"];
                        $waktuMulai = $row["waktu_mulai"];
                        $waktuSelesai = $row["waktu_selesai"];
                        $status = $row["status_pekerjaan"];
                    } else {
                        // URL doesn't contain valid id parameter. Redirect to error page
                        header("location: 404.php");
                        exit();
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Clode statement
            mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
        } else {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: 404.php");
            exit();
        }
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

        <title>Monitoring Kinerja - Bidang - Update Pekerjaan</title>

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
                        include "template/topbar_v.php";
                    ?>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Update Pekerjaan</h1>
                        </div>

                        <div class="wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="idPekerjaan">ID pekerjaan</label>
                                                        <input type="number" id="idPekerjaan" class="form-control" value="<?= $id ?>" disabled>
                                                    </div>
                                                    <div class="form-group <?php echo (!empty($uraianPekerjaan_err)) ? 'has-error' : ''; ?>">
                                                            <label for="uraian_pekerjaan">Uraian pekerjaan</label>
                                                            <input type="text" id="uraian_pekerjaan" name="uraian_pekerjaan" class="form-control" value="<?= $uraianPekerjaan ?>">
                                                            <span class="help-block"><?= $uraianPekerjaan_err ?></span>
                                                        </div>
                                                    <div class="form-group <?php echo (!empty($namaPegawai_err)) ? 'has-error' : ''; ?>">
                                                        <label for="pegawai">Nama Pegawai</label><br>
                                                        <select name="nama_pegawai">
                                                            <option selected disabled>--- Pegawai ---</option>
                                                            <?php
                                                                while ($pegawai = mysqli_fetch_array($all_pegawai)){
                                                                    if ($namaPegawai == $pegawai['idPegawai']){
                                                                        $select="selected";
                                                                    }else{
                                                                        $select="";
                                                                    }
                                                                    ?>
                                                                    <option value="<?=$pegawai['idPegawai']?>" <?=$select?>><?php echo $pegawai["nama_peg"];?></option>
                                                                    
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <span class="help-block"><?= $namaPegawai_err ?></span>
                                                    </div>
                                                    <div class="form-group <?php echo (!empty($waktuMulai_err)) ? 'has-error' : ''; ?>">
                                                        <label for="mulai">Waktu Mulai</label>
                                                        <input type="datetime-local" id="mulai" name="waktu_mulai" class="form-control" value="<?= $waktuMulai ?>">
                                                        <span class="help-block"><?= $waktuMulai_err ?></span>
                                                    </div>
                                                    <div class="form-group <?php echo (!empty($waktuSelesai_err)) ? 'has-error' : ''; ?>">
                                                        <label for="selesai">Waktu Selesai</label>
                                                        <input type="datetime-local" id="selesai" name="waktu_selesai" class="form-control" value="<?= $waktuSelesai?>">
                                                    <span class="help-block"><?= $waktuSelesai_err ?></span>
                                                    </div>
                                                    <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                                                        <label for="status">Status</label><br>
                                                        <select name="status_pekerjaan">
                                                            <option selected disabled>--- Status ---</option>
                                                            <option value="Selesai" 
                                                                <?php if($row['status_pekerjaan'] == 'Selesai'){echo 'selected';} ?>>
                                                            Selesai</option>
                                                            <option value="Pending" 
                                                                <?php if($row['status_pekerjaan'] == 'Pending'){echo 'selected';} ?>>
                                                            Pending</option>
                                                        </select>
                                                        <span class="help-block"><?= $status_err ?></span>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                    <a href="pekerjaan.php" class="btn btn-default">Cancel</a>
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