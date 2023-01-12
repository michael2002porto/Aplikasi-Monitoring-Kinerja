<?php
//inisialisasi session
session_start();
//menyertakan file program config.php pada register
require('config.php');
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // menghilangkan backshlases
    $cur_password = stripslashes($_POST['cur_password']);
    //cara sederhana mengamankan dari sql injection
    $cur_password = mysqli_real_escape_string($link, $cur_password);

    // menghilangkan backshlases
    $new_password = stripslashes($_POST['new_password']);
    //cara sederhana mengamankan dari sql injection
    $new_password = mysqli_real_escape_string($link, $new_password);

    // menghilangkan backshlases
    $confirm_new_password = stripslashes($_POST['confirm_new_password']);
    //cara sederhana mengamankan dari sql injection
    $confirm_new_password = mysqli_real_escape_string($link, $confirm_new_password);

    //select data berdasarkan username dari database
    $query = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($link, $query);
    $rows = mysqli_num_rows($result);
    if ($rows != 0) {
        $fetch_result = mysqli_fetch_assoc($result);
        $hash = $fetch_result['password'];
        if (password_verify($cur_password, $hash)) {
            //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
            if ($new_password == $confirm_new_password) {
                //hashing password sebelum disimpan didatabase
                $pass = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = '$pass' WHERE username = '" . $_SESSION['username'] . "'";
                $result = mysqli_query($link, $query); //jika insert data berhasil maka akan diredirect ke halaman login.php serta menyimpan data username ke session
                if ($result) {
                    $msg = 'Update Password User Berhasil !!';
                } else {
                    $error = 'Update Password User Gagal !!';
                }
            } else {
                $error = 'Konfirmasi Password tidak sama !!';
            }
        } else {
            $error = 'Current Password salah !!';
        }
    }
}

//fungsi untuk mengecek username apakah sudah terdaftar atau belum
function cek_nama($username, $link)
{
    $nama = mysqli_real_escape_string($link, $username);
    $query = "SELECT * FROM users WHERE username = '$nama'";
    if ($result = mysqli_query($link, $query)) return mysqli_num_rows($result);
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

    <title>Monitoring Kinerja - Profile</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
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
                        <h1 class="h3 mb-0 text-gray-800">Settings</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-lg-12 mb-4">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                            <?php } ?>
                            <?php if (!empty($msg)) { ?>
                                <div class="alert alert-success" role="alert"><?= $msg; ?></div>
                            <?php } ?>

                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                                </div>
                                <div class="card-body">
                                    <form class="user" action="settings.php" method="post">
                                        <div class="form-group row">
                                            <label for="cur_password" class="col-sm-3 col-form-label">Current Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-user" name="cur_password" id="cur_password" placeholder="Input current password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-user" name="new_password" id="new_password" placeholder="Input new password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirm_new_password" class="col-sm-3 col-form-label">Confirm New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-user" name="confirm_new_password" id="confirm_new_password" placeholder="Input new password confirmation" required>
                                            </div>
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary btn-user btn-block">
                                            Update Password
                                        </button>
                                    </form>
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