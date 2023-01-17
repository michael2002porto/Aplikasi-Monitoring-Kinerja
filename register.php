<?php
//menyertakan file program functions.php pada register
require('functions.php');
//inisialisasi session
session_start();
$error = '';
$validate = '';
if (isset($_SESSION['username'])) header('Location: index.php');
//mengecek apakah data username yang diinpukan user kosong atau tidak
if (isset($_POST['submit'])) {
    // menghilangkan backshlases
    $username = stripslashes($_POST['username']); //cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($link, $username);
    $name = stripslashes($_POST['name']);
    $name = mysqli_real_escape_string($link, $name);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($link, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($link, $password);
    $repass = stripslashes($_POST['repassword']);
    $repass = mysqli_real_escape_string($link, $repass); //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (
        !empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password))
        && !empty(trim($repass)) && !empty(trim($_POST["captcha"]))
    ) {
        //cek captcha
        if ($_SESSION["code"] != $_POST["captcha"]) {
            $error = 'Captcha salah !!';
        } else {
            //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
            if ($password == $repass) {
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
                if (cek_nama($username, $link) == 0) {
                    //hashing password sebelum disimpan didatabase
                    $pass = password_hash($password, PASSWORD_DEFAULT); //insert data ke database
                    $query = "INSERT INTO users (username, name, email, password) VALUES ('$username', '$name','$email', '$pass')";
                    $result = mysqli_query($link, $query); //jika insert data berhasil maka akan diredirect ke halaman login.php serta menyimpan data username ke session
                    if ($result) {
                        // $_SESSION['username'] = $username;
                        alert('Register User Berhasil !!');
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "login.php";';
                        echo '</script>';
                        //jika gagal maka akan menampilkan pesan error
                    } else {
                        $error = 'Register User Gagal !!';
                    }
                } else {
                    $error = 'Username sudah terdaftar !!';
                }
            } else {
                $validate = 'Password tidak sama !!';
            }
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                    <?php if ($error != "") { ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                    <?php } ?>

                    <img src="img/login.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="register.php" method="POST">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-bold mb-0 me-3">SIGN UP</p>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <!-- <p class="text-center fw-bold mx-3 mb-0">Or</p> -->
                        </div>

                        <!-- Name input -->
                        <div class="form-outline mb-2">
                            <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Enter name" required />
                            <label class="form-label" for="name">Name</label>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-2">
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email" required />
                            <label class="form-label" for="email">Email</label>
                        </div>

                        <!-- Username input -->
                        <div class="form-outline mb-2">
                            <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Enter username" required />
                            <label class="form-label" for="username">Username</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-2">
                            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required />
                            <label class="form-label" for="password">Password</label>
                            <!-- <?php if ($validate != '') { ?>
                                <p class="text-danger"><?= $validate; ?></p>
                            <?php } ?> -->
                        </div>

                        <!-- Re-Password input -->
                        <div class="form-outline mb-2">
                            <input type="password" id="repassword" name="repassword" class="form-control form-control-lg" placeholder="Enter re-password" required />
                            <label class="form-label" for="repassword">Re-Password</label>
                            <?php if ($validate != '') { ?>
                                <p class="text-danger"><?= $validate; ?></p>
                            <?php } ?>
                        </div>

                        <!-- Captcha input -->
                        <div class="form-outline mb-2">
                            <div class="input-group">
                                <input type="text" id="captcha" name="captcha" class="form-control form-control-lg" placeholder="Enter a valid captcha" required />
                                <div class="input-group-prepend">
                                    <img src="captcha.php" alt="gambar">
                                </div>
                            </div>
                            <label class="form-label" for="captcha">Captcha</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php" class="link-danger">Login</a></p>
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