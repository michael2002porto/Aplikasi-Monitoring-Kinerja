<!-- Nama : Michael Natanael -->
<!-- NIM  : 2107411002 -->

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

// Include functions file
require_once "functions.php";

// Tentukan variabel dan inisialisasi dengan nilai kosong
$nama = $tugas = $uts = $uas = "";
$nama_err = $tugas_err = $uts_err = $uas_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate nama
    $input_nama = trim($_POST["nama"]);
    if (empty($input_nama)) {
        $nama_err = "Please enter a name";
    } elseif (!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nama_err = "Please enter a valid name";
    } else {
        $nama = $input_nama;
    }

    // Validate tugas
    $input_tugas = trim($_POST["tugas"]);
    if (empty($input_tugas)) {
        $tugas_err = "Please enter the assignment score";
    } elseif (!ctype_digit($input_tugas)) {
        $tugas_err = "Please enter a positive integer value";
    } else {
        $tugas = $input_tugas;
    }

    // Validate uts
    $input_uts = trim($_POST["uts"]);
    if (empty($input_uts)) {
        $uts_err = "Please enter the UTS score";
    } elseif (!ctype_digit($input_uts)) {
        $uts_err = "Please enter a positive integer value";
    } else {
        $uts = $input_uts;
    }

    // Validate uas
    $input_uas = trim($_POST["uas"]);
    if (empty($input_uas)) {
        $uas_err = "Please enter the UAS score";
    } elseif (!ctype_digit($input_uas)) {
        $uas_err = "Please enter a positive integer value";
    } else {
        $uas = $input_uas;
    }

    // Upload image
    if ($_FILES['image']['error'] === 4) {
        $image = $_POST["gambarLama"];
    } else {
        $image = upload();
    }

    // Check input errors before updating in database
    if (empty($nama_err) && empty($tugas_err) && empty($uts_err) && empty($uas_err)) {
        // Prepare an update statement
        $sql = "UPDATE mahasiswa SET nama=?, tugas=?, uts=?, uas=?, foto=? WHERE nim=?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiisi", $param_nama, $param_tugas, $param_uts, $param_uas, $param_foto, $param_id);

            // Set parameters
            $param_nama = $nama;
            $param_tugas = $tugas;
            $param_uts = $uts;
            $param_uas = $uas;
            $param_foto = $image;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
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
        $sql = "SELECT * FROM mahasiswa WHERE nim = ?";
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
                    $id = $row["nim"];
                    $nama = $row["nama"];
                    $tugas = $row["tugas"];
                    $uts = $row["uts"];
                    $uas = $row["uas"];
                    $nilai_akhir = ($tugas + $uts + $uas) / 3;
                    $image = $row["foto"];
                } else {
                    // URL doesn't contain valid id parameter. Redirect to error page
                    header("location: error.php");
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
        header("location: error.php");
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
                        <h2>Update Mahasiswa</h2>
                    </div>
                    <p>Silahkan edit form di bawah ini kemudian submit untuk mengubah data mahasiswa di database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" id="nim" class="form-control" value="<?= sprintf('%05d', $id) ?>" disabled>
                        </div>
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="nama" class="form-control" value="<?= $nama ?>">
                            <span class="help-block"><?= $nama_err ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tugas_err)) ? 'has-error' : ''; ?>">
                            <label for="tugas">Tugas</label>
                            <input type="text" id="tugas" name="tugas" class="form-control" value="<?= $tugas ?>">
                            <span class="help-block"><?= $tugas_err ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uts_err)) ? 'has-error' : ''; ?>">
                            <label for="uts">UTS</label>
                            <input type="text" id="uts" name="uts" class="form-control" value="<?= $uts ?>">
                            <span class="help-block"><?= $uts_err ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uas_err)) ? 'has-error' : ''; ?>">
                            <label for="uas">UAS</label>
                            <input type="text" id="uas" name="uas" class="form-control" value="<?= $uas ?>">
                            <span class="help-block"><?= $uas_err ?></span>
                        </div>
                        <div class="form-group media-left">
                            <label for="image">Foto Mahasiswa</label>
                            <a href="#" class="thumbnail">
                                <img src="img/<?= $image ?>" alt="Gambar tidak ditemukan" width="100">
                                <input type="file" name="image" id="image">
                            </a>
                        </div>
                        <input type="hidden" name="gambarLama" value="<?= $image ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>