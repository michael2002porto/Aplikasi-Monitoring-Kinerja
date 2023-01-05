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

// Tugas

$sql = "SELECT count(tugas) FROM mahasiswa WHERE tugas BETWEEN 0 AND 60";
$result_tugas[0] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(tugas) FROM mahasiswa WHERE tugas BETWEEN 61 AND 70";
$result_tugas[1] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(tugas) FROM mahasiswa WHERE tugas BETWEEN 71 AND 80";
$result_tugas[2] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(tugas) FROM mahasiswa WHERE tugas BETWEEN 81 AND 90";
$result_tugas[3] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(tugas) FROM mahasiswa WHERE tugas BETWEEN 91 AND 100";
$result_tugas[4] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

// UTS

$sql = "SELECT count(uts) FROM mahasiswa WHERE uts BETWEEN 0 AND 60";
$result_uts[0] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uts) FROM mahasiswa WHERE uts BETWEEN 61 AND 70";
$result_uts[1] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uts) FROM mahasiswa WHERE uts BETWEEN 71 AND 80";
$result_uts[2] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uts) FROM mahasiswa WHERE uts BETWEEN 81 AND 90";
$result_uts[3] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uts) FROM mahasiswa WHERE uts BETWEEN 91 AND 100";
$result_uts[4] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

// UAS

$sql = "SELECT count(uas) FROM mahasiswa WHERE uas BETWEEN 0 AND 60";
$result_uas[0] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uas) FROM mahasiswa WHERE uas BETWEEN 61 AND 70";
$result_uas[1] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uas) FROM mahasiswa WHERE uas BETWEEN 71 AND 80";
$result_uas[2] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uas) FROM mahasiswa WHERE uas BETWEEN 81 AND 90";
$result_uas[3] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(uas) FROM mahasiswa WHERE uas BETWEEN 91 AND 100";
$result_uas[4] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

// Nilai Akhir

$sql = "SELECT count(nim) FROM mahasiswa WHERE (tugas + uts + uas) / 3 BETWEEN 0 AND 60";
$result_nilai_akhir[0] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(nim) FROM mahasiswa WHERE (tugas + uts + uas) / 3 BETWEEN 61 AND 70";
$result_nilai_akhir[1] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(nim) FROM mahasiswa WHERE (tugas + uts + uas) / 3 BETWEEN 71 AND 80";
$result_nilai_akhir[2] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(nim) FROM mahasiswa WHERE (tugas + uts + uas) / 3 BETWEEN 81 AND 90";
$result_nilai_akhir[3] = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT count(nim) FROM mahasiswa WHERE (tugas + uts + uas) / 3 BETWEEN 91 AND 100";
$result_nilai_akhir[4] = mysqli_fetch_array(mysqli_query($link, $sql))[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/chart.js"></script>
    <script type="text/javascript" src="js/chart-utils.min.js"></script>
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
                        <h2 class="pull-left">Grafik Nilai Mahasiswa Akademik PNJ</h2>
                        <a href="index.php" class="btn btn-primary pull-right">Beranda</a>
                    </div>

                    <div style="width: 100%;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    const Utils = ChartUtils.init();

    const labels = [
        "0 - 60",
        "61 - 70",
        "71 - 80",
        "81 - 90",
        "91 - 100"
    ];
    const data = {
        labels: labels,
        datasets: [{
                label: 'Tugas',
                data: <?php echo json_encode($result_tugas); ?>,
                borderColor: Utils.CHART_COLORS.red,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            },
            {
                label: 'UTS',
                data: <?php echo json_encode($result_uts); ?>,
                borderColor: Utils.CHART_COLORS.yellow,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.yellow, 0.5),
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            },
            {
                label: 'UAS',
                data: <?php echo json_encode($result_uas); ?>,
                borderColor: Utils.CHART_COLORS.blue,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            },
            {
                label: 'Nilai Akhir',
                data: <?php echo json_encode($result_nilai_akhir); ?>,
                borderColor: Utils.CHART_COLORS.purple,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.purple, 0.5),
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Jumlah Mahasiswa berdasarkan Range Nilai'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Range Nilai'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Mahasiswa'
                    }
                }
            }
        },
    };

    window.onload = function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        window.myPie = new Chart(ctx, config);
    };
</script>