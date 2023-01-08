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
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
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
                        <h2 class="pull-left">Data Mahasiswa Akademik PNJ</h2>
                        &nbsp;
                        <a href="chart.php" class="btn btn-primary btn-xs">Lihat Grafik</a>
                        <a href="create.php" class="btn btn-success pull-right">Tambah Mahasiswa</a>
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
                    $batas = 10;
                    $halaman = @$_GET['halaman'];
                    if (empty($halaman)) {
                        $posisi = 0;
                        $halaman = 1;
                    } else {
                        $posisi = ($halaman - 1) * $batas;
                    }
                    if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                        $sql = "SELECT * FROM mahasiswa WHERE nim LIKE '%$search%'
                        OR nama LIKE '%$search%'OR tugas LIKE '%$search%'
                        OR uts LIKE '%$search%' OR uas LIKE '%$search%'
                        ORDER BY nim ASC LIMIT $posisi, $batas";
                    } else {
                        $sql = "SELECT * FROM mahasiswa ORDER BY nim ASC LIMIT $posisi, $batas";
                    }
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                    ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tugas</th>
                                        <th>UTS</th>
                                        <th>UAS</th>
                                        <th>Nilai Akhir</th>
                                        <th>Pengaturan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1 + $posisi;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $nilai_akhir = ($row['tugas'] + $row['uts'] + $row['uas']) / 3;
                                    ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= sprintf('%05d', $row['nim']) ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['tugas'] ?></td>
                                            <td><?= $row['uts'] ?></td>
                                            <td><?= $row['uas'] ?></td>
                                            <td><?= round($nilai_akhir, 2) ?></td>
                                            <td>
                                                <a href="read.php?id=<?= $row['nim'] ?>" title="View Record" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                <a href="update.php?id=<?= $row['nim'] ?>" title="Update Record" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="delete.php?id=<?= $row['nim'] ?>" title="Delete Record" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a>
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
                                    $query2 = "SELECT * FROM mahasiswa WHERE nim LIKE '%$search%'
                                    OR nama LIKE '%$search%'OR tugas LIKE '%$search%'
                                    OR uts LIKE '%$search%' OR uas LIKE '%$search%' ORDER BY nim ASC";
                                } else {
                                    $query2 = "SELECT * FROM mahasiswa ORDER BY nim ASC";
                                }
                                $result2 = mysqli_query($link, $query2);
                                $jmldata = mysqli_num_rows($result2);
                                $jmlhalaman = ceil($jmldata / $batas);

                                for ($i = 1; $i <= $jmlhalaman; $i++) {
                                    if ($i != $halaman) {
                                        if (isset($_GET['search'])) {
                                            $search = $_GET['search'];
                                            echo "<li class='page-item'><a class='page-link' href='index.php?halaman=$i&search=$search'>$i</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a class='page-link' href='index.php?halaman=$i'>$i</a></li>";
                                        }
                                    } else {
                                        echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                                    }
                                } ?>
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