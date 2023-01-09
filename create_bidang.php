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

    // Tentukan variabel dan inisialisasi dengan nilai kosong
    $namaBidang = "";
    $namaBidang_err = "";

    // Memproses data formulir saat formulir dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Validate nama bidang
        $input_namaBidang = trim($_POST["nama_bidang"]);
        if (empty($input_namaBidang)) {
            $namaBidang_err = "Please enter a name";
        } else {
            $namaBidang = $input_namaBidang;
        }

        // Check input errors before inserting in database
        if (empty($namaBidang_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO bidang (nama_bidang) VALUES (?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_namaBidang);

                // Set parameters
                $param_namaBidang = $namaBidang;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: bidang.php");
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

        <title>Monitoring Kinerja - Bidang - Create Bidang</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Create Bidang</h1>
                        </div>

                        <div class="wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                                <div class="form-group <?php echo (!empty($namaBidang_err)) ? 'has-error' : ''; ?>">
                                                    <label for="nama_bidang">Nama Bidang</label>
                                                    <input type="text" id="nama_bidang" name="nama_bidang" class="form-control" value="<?= $namaBidang ?>">
                                                    <span class="help-block"><?= $namaBidang_err ?></span>
                                                </div>
                                                <input type="submit" class="btn btn-primary" value="Submit">
                                                <a href="bidang.php" class="btn btn-default">Cancel</a>
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