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

// Check existence of id parameter before processing further
if (isset($_GET["id"]) &&  !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

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
                $nim = $row["nim"];
                $nama = $row["nama"];
                $tugas = $row["tugas"];
                $uts = $row["uts"];
                $uas = $row["uas"];
                $nilai_akhir = ($tugas + $uts + $uas) / 3;
                $image = $row["foto"];
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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
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
                        <h2>Data Mahasiswa</h2>
                    </div>
                    <div class="form-group">
                        <label>NIM</label>
                        <p class="form-control-static"><?php echo sprintf('%05d', $nim); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <p class="form-control-static"><?php echo $nama; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tugas</label>
                        <p class="form-control-static"><?php echo $tugas; ?></p>
                    </div>
                    <div class="form-group">
                        <label>UTS</label>
                        <p class="form-control-static"><?php echo $uts; ?></p>
                    </div>
                    <div class="form-group">
                        <label>UAS</label>
                        <p class="form-control-static"><?php echo $uas; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nilai Akhir</label>
                        <p class="form-control-static"><?php echo round($nilai_akhir, 2); ?></p>
                    </div>
                    <div class="form-group media-left">
                        <label>Foto Mahasiswa</label>
                        <a href="#" class="thumbnail">
                            <img src="img/<?= $image ?>" alt="Gambar tidak ditemukan" width="100">
                        </a>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>