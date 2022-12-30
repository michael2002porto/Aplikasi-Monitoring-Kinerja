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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

        <title>Manajemen Data | Jabatan</title>
        <style type="text/css">
            .nav {
                padding: 10px;
                margin: 0 auto;
            }

            .wrapper {
                width: 1200px;
                margin: 0 auto;
            }

            .page-header h2 {
                margin-top: 0;
            }

            table tr td:last-child a {
                margin-right: 10px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            })
        </script>
    </head>

    <body>
        <nav class="nav">
            <a href="logout.php" class="btn btn-danger pull-right">Logout</a>
        </nav>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Manajemen Data/Jabatan</h2>
                            &nbsp;
                            <a href="create_jabatan.php" class="btn btn-success pull-right">Tambah Data Jabatan</a>
                        </div>
                        <form class="form-inline pull-right" method="get">
                            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                        <br><br><br>
                        <?php
                            // Include config file
                            require_once "config.php";

                            // Attempt select query execution
                            $batas = 5;
                            $halaman = @$_GET['halaman'];
                            if (empty($halaman)) {
                                $posisi = 0;
                                $halaman = 1;
                            } else {
                                $posisi = ($halaman - 1) * $batas;
                            }

                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql = "SELECT * FROM jabatan WHERE nama_jabatan LIKE '%$search%' ORDER BY idJabatan ASC LIMIT $posisi, $batas";
                            } else {
                                $sql = "SELECT * FROM jabatan ORDER BY idJabatan ASC LIMIT $posisi, $batas";
                            }

                            if ($result = mysqli_query($link, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                        ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jabatan</th>
                                    <th>Pengaturan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1 + $posisi;
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>

                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['nama_jabatan'] ?></td>
                                    <td>
                                        <?php 
                                            echo "<a href='update_jabatan.php?id=" . $row['idJabatan'] ."' title='Update record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'>
                                            </span></a>";
                                            echo "<a href='delete_jabatan.php?id=" . $row['idJabatan'] ."' title='Delete record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'>
                                            </span></a>";
                                        ?>
                                    </td>
                                </tr>
                                
                                <?php
                                         $i++;
                                    }
                                ?>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <ul class="pagination">
                                <?php
                                    if (isset($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $query2 = "SELECT * FROM jabatan WHERE nama_jabatan LIKE '%$search%' ORDER BY idJabatan ASC";
                                    } else {
                                        $query2 = "SELECT * FROM jabatan ORDER BY nama_jabatan ASC";
                                    }

                                    $result2 = mysqli_query($link, $query2);
                                    $jmldata = mysqli_num_rows($result2);
                                    $jmlhalaman = ceil($jmldata / $batas);

                                    for ($i = 1; $i <= $jmlhalaman; $i++) {
                                         if ($i != $halaman) {
                                            if (isset($_GET['search'])) {
                                                $search = $_GET['search'];
                                                echo "<li class='page-item'><a class='page-link' href='jabatan.php?halaman=$i&search=$search'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='jabatan.php?halaman=$i'>$i</a></li>";
                                            }
                                        } else {
                                            echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                                        }
                                    } 
                                ?>
                            </ul>

                            <?php
                                // Free result set
                                mysqli_free_result($result);
                                } else {
                            ?>
                            
                            <p class="lead"><em>No records were found</em></p>
                            
                            <?php
                                }
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                            }

                            // CLose connection
                            mysqli_close($link);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>