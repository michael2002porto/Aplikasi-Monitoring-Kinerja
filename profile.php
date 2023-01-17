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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (cek_nama($username, $link) == 0 || $username == $_SESSION['username']) {
        //hashing password sebelum disimpan didatabase
        $query = "UPDATE users SET username = '$username', name = '$name', email = '$email' WHERE username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($link, $query); //jika update data berhasil maka akan menyimpan data username ke session
        if ($result) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            // header('Location: login.php');
            $msg = 'Update User Profile Berhasil !!';
            //jika gagal maka akan menampilkan pesan error
        } else {
            $error = 'Update User Profile Gagal !!';
        }
    } else {
        $error = 'Username sudah terdaftar !!';
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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                        <a href="#" onclick="enableInput()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-edit fa-sm text-white-50"></i> Edit User Profile</a>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Hello, <?= $_SESSION['name'] ?></h6>
                                </div>
                                <div class="card-body">
                                    <form class="user" action="profile.php" method="post">
                                        <div class="form-group row">
                                            <label for="exampleUsername" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-user" name="username" id="exampleUsername" placeholder="Username" readonly value="<?= $_SESSION['username'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-user" name="name" id="exampleName" placeholder="Name" readonly value="<?= $_SESSION['name'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control form-control-user" name="email" id="exampleEmail" placeholder="Email" readonly value="<?= $_SESSION['email'] ?>" required>
                                            </div>
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary btn-user btn-block" disabled>
                                            Update Profile
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

<script>
    function enableInput() {
        var inputs = document.getElementsByClassName('form-control-user');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly = false;
        }
        document.getElementById('submit').disabled = false;
    }
</script>