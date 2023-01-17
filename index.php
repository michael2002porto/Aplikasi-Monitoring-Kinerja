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

$query = "SELECT COUNT(*) AS jumlah FROM bidang";
$jumlah_bidang = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];

$query = "SELECT COUNT(*) AS jumlah FROM jabatan";
$jumlah_jabatan = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];

$query = "SELECT COUNT(*) AS jumlah FROM pegawai";
$jumlah_pegawai = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];

$query = "SELECT COUNT(*) AS jumlah FROM pekerjaan";
$jumlah_pekerjaan = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];

$query = "SELECT COUNT(*) AS jumlah FROM pekerjaan WHERE LOWER(status_pekerjaan) = 'selesai'";
$jumlah_pekerjaan_selesai = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];

$persentase_pekerjaan_selesai = ($jumlah_pekerjaan_selesai / $jumlah_pekerjaan) * 100;
$persentase_pekerjaan_selesai = round($persentase_pekerjaan_selesai);

// Bidang Overview
$sql = "SELECT * FROM bidang";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $bidang[] = $row['nama_bidang'];
    $query = "SELECT COUNT(*) AS jumlah FROM pegawai WHERE id_bidang = " . $row['idBidang'];
    $bidang_pegawai[] = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];
}

// Jabatan Overview
$sql = "SELECT * FROM jabatan";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $jabatan[] = $row['nama_jabatan'];
    $query = "SELECT COUNT(*) AS jumlah FROM pegawai WHERE id_jabatan = " . $row['idJabatan'];
    $jabatan_pegawai[] = mysqli_fetch_assoc(mysqli_query($link, $query))['jumlah'];
}

// Attendance Overview
$sql = "SELECT * FROM pegawai";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $pegawai[] = $row['nip'] . ' - ' .  $row['nama_peg'];
    $query = "SELECT SUM(TIMESTAMPDIFF(HOUR, absen_masuk, absen_pulang)) AS total_hours FROM absensi WHERE id_karyawan = " . $row['idPegawai'];
    $total_hours_of_attendance[] = mysqli_fetch_assoc(mysqli_query($link, $query))['total_hours'];
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

    <title>Monitoring Kinerja - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Chart -->
    <script type="text/javascript" src="js/chart.js"></script>
    <script type="text/javascript" src="js/chart-utils.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        $active_sidebar = 'dashboard';
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" onclick="window.open(this.href).print(); return false" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Bidang</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_bidang ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jumlah Jabatan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_jabatan ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-wrench fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Karyawan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_pegawai ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-person-booth fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pekerjaan
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $persentase_pekerjaan_selesai ?>%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $persentase_pekerjaan_selesai ?>%" aria-valuenow="<?= $persentase_pekerjaan_selesai ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Pie Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Bidang Overview (Jumlah Karyawan)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="bidangChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Jabatan Overview (Jumlah Karyawan)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="jabatanChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Bar Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Attendance Overview (Office Hours)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="attendanceChart"></canvas>
                                    </div>
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
    const Utils = ChartUtils.init();

    // Pie Chart Example
    var ctx = document.getElementById("bidangChart");
    var bidangChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($bidang); ?>,
            datasets: [{
                data: <?php echo json_encode($bidang_pegawai); ?>,
                backgroundColor: Object.values(Utils.CHART_COLORS)
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 80,
        },
    });

    // Pie Chart Example
    var ctx = document.getElementById("jabatanChart");
    var jabatanChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($jabatan); ?>,
            datasets: [{
                data: <?php echo json_encode($jabatan_pegawai); ?>,
                backgroundColor: Object.values(Utils.CHART_COLORS)
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 80,
        },
    });

    // Bar Chart Example
    var ctx = document.getElementById("attendanceChart");
    var attendanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($pegawai); ?>,
            datasets: [{
                label: 'Total Office Hours',
                data: <?php echo json_encode($total_hours_of_attendance); ?>,
                backgroundColor: Object.values(Utils.CHART_COLORS),
                borderWidth: 1
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 80,
        },
    });
</script>