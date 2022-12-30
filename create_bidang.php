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
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Record Bidang</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper {
                width: 500px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Tambah Data Bidang</h2>
                        </div>
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
    </body>
</html>