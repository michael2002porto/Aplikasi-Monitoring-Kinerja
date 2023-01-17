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
    $jabatan = "";
    $jabatan_err = "";

    // Processing form data when form is submitted
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Get hidden input value
        $id = $_POST["id"];

        // Validate uraian kegiatan
        $input_jabatan = trim($_POST["nama_jabatan"]);
        if (empty($input_jabatan)) {
            $jabatan_err = "Please enter a name";
        } else {
            $jabatan = $input_jabatan;
        }
        
        // Check input errors before updating in database
        if (empty($jabatan_err)) {
            // Prepare an update statement
            $sql = "UPDATE jabatan SET nama_jabatan=? WHERE idJabatan=?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "si", $param_jabatan, $param_idJabatan);

                // Set parameters
                $param_jabatan = $jabatan;
                $param_idJabatan = $id;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: jabatan.php");
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
            $sql = "SELECT * FROM jabatan WHERE idJabatan = ?";
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
                        $id = $row["idJabatan"];
                        $jabatan = $row["nama_jabatan"];
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
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Record</title>
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
                            <h2>Update Jabatan</h2>
                        </div>
                        <p>Silahkan edit form di bawah ini kemudian submit untuk mengubah data jabatan di database.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="idJabatan">ID Jabatan</label>
                                <input type="number" id="idJabatan" class="form-control" value="<?= $id ?>" disabled>
                            </div>
                            <div class="form-group <?php echo (!empty($jabatan_err)) ? 'has-error' : ''; ?>">
                                <label for="nama_jabatan">Jabatan</label>
                                <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control" value="<?= $jabatan ?>">
                                <span class="help-block"><?= $jabatan_err ?></span>
                            </div>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="jabatan.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>