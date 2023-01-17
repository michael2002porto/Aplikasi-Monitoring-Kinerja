<?php
//menyertakan file program config.php pada register
require('config.php');
//inisialisasi session
session_start();
$error = '';
$validate = '';
//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if (isset($_SESSION['username'])) header('Location: index.php');
//mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {
    // menghilangkan backshlases
    $username = stripslashes($_POST['username']);
    //cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($link, $username);
    // menghilangkan backshlases
    $password = stripslashes($_POST['password']);
    //cara sederhana mengamankan dari sql injection
    $password = mysqli_real_escape_string($link, $password);
    //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($username)) && !empty(trim($password)) && !empty(trim($_POST["captcha"]))) {
        //cek captcha
        if ($_SESSION["code"] != $_POST["captcha"]) {
            $error = 'Captcha salah !!';
        } else {
            //select data berdasarkan username dari database
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($link, $query);
            $rows = mysqli_num_rows($result);
            if ($rows != 0) {
                $fetch_result = mysqli_fetch_assoc($result);
                $hash = $fetch_result['password'];
                if (password_verify($password, $hash)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['name'] = $fetch_result['name'];
                    $_SESSION['email'] = $fetch_result['email'];
                    header('Location: index.php');
                }
                //jika gagal maka akan menampilkan pesan error
            } else {
                $error = 'Login User Gagal !!';
            }
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>

<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
</style>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="img/login.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="login.php" method="POST">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-bold mb-0 me-3">SIGN IN</p>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <!-- <p class="text-center fw-bold mx-3 mb-0">Or</p> -->
                        </div>

                        <?php if ($error != "") { ?>
                            <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                        <?php } ?>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Enter a valid username" required />
                            <label class="form-label" for="username">Username</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required />
                            <label class="form-label" for="password">Password</label>
                            <?php if ($validate != '') { ?>
                                <p class="text-danger"><?= $validate; ?></p>
                            <?php } ?>
                        </div>

                        <!-- Captcha input -->
                        <div class="form-outline mb-4">
                            <div class="input-group">
                                <input type="text" id="captcha" name="captcha" class="form-control form-control-lg" placeholder="Enter a valid captcha" required />
                                <div class="input-group-prepend">
                                    <img src="captcha.php" alt="gambar">
                                </div>
                            </div>
                            <label class="form-label" for="captcha">Captcha</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Remember me
                                </label>
                            </div>
                            <a href="#!" class="text-body">Forgot password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php" class="link-danger">Register</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright &copy; Aplikasi Monitoring Kinerja 2023
            </div>
            <!-- Copyright -->
        </div>
    </section>
</body>

</html>