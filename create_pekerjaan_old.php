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

    $sqlPegawai = "SELECT * FROM pegawai";
	$all_pegawai = mysqli_query($link,$sqlPegawai);

    // Tentukan variabel dan inisialisasi dengan nilai kosong
    $uraianPekerjaan = $namaPegawai = $waktuMulai = $waktuSelesai = $atatus = "";
    $uraianPekerjaan_err = $namaPegawai_err = $waktuMulai_err = $waktuSelesai_err = $status_err = "";

    // Memproses data formulir saat formulir dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate uraian pekerjaan
        $input_uraianPekerjaan = trim($_POST["uraian_pekerjaan"]);
        if (empty($input_uraianPekerjaan)) {
            $uraianPekerjaan_err = "Please enter a name";
        } else {
            $uraianPekerjaan = $input_uraianPekerjaan;
        }

        // Validate satuan
        $input_waktuMulai = $_POST["waktu_mulai"];
        $waktuMulai = $input_waktuMulai;

        // Validate id pegawai
        $input_pegawai = trim($_POST["nama_pegawai"]);
        if (empty($input_pegawai)) {
            $pegawai_err = "Please enter the pegawai";
        } elseif (!ctype_digit($input_pegawai)) {
            $pegawai_err = "Please enter a positive integer value";
        } else {
            $pegawai = $input_pegawai;
        }

        // Validate satuan
        $input_waktuSelesai = $_POST["waktu_selesai"];
        $waktuSelesai = $input_waktuSelesai;

        // Validate satuan
        $input_status = trim($_POST["status_pekerjaan"]);
        if (empty($input_status)) {
            $waktuSelesai_err = "Please enter a name";
        } else {
            $status = $input_status;
        }

        // Check input errors before inserting in database
        if (empty($uraianPekerjaan_err) && empty($namaPegawai_err) && empty($waktuMulai_err) && empty($waktuSelesai_err) && empty($status_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO pekerjaan (uraian_pekerjaan, id_pegawai, waktu_mulai, waktu_selesai, status_pekerjaan) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sisss", $param_uraianPekerjaan, $param_namaPegawai, $param_waktuMulai, $param_waktuSelesai, $param_status);

                // Set parameters
                $param_uraianPekerjaan = $uraianPekerjaan;
                $param_namaPegawai = $pegawai;
                $param_waktuMulai = $waktuMulai;
                $param_waktuSelesai = $waktuSelesai;
                $param_status = $status;
                
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: pekerjaan.php");
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
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Record pekerjaan</title>
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
                            <h2>Tambah pekerjaan</h2>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group <?php echo (!empty($uraianPekerjaan_err)) ? 'has-error' : ''; ?>">
                                <label for="uraian_pekerjaan">Uraian pekerjaan</label>
                                <input type="text" id="uraian_pekerjaan" name="uraian_pekerjaan" class="form-control" value="<?= $uraianPekerjaan ?>">
                                <span class="help-block"><?= $uraianPekerjaan_err ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($namaPegawai_err)) ? 'has-error' : ''; ?>">
                                <label for="pegawai">Nama Pegawai</label><br>
                                    <select name="nama_pegawai">
                                        <option selected disabled>--- Pegawai ---</option>
                                        <?php
                                            while ($namaPegawai = mysqli_fetch_array(
                                                $all_pegawai,MYSQLI_ASSOC)){
                                        ?>
                                        <option value="<?php echo $namaPegawai["idPegawai"];?>">
                                            <?php echo $namaPegawai["nama_peg"];?>
                                        </option>
                                        
                                        <?php
                                            }
                                        ?>
                                    </select>
                                <span class="help-block"><?= $namaPegawai_err ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($waktuMulai_err)) ? 'has-error' : ''; ?>">
                                <label for="mulai">Waktu Mulai</label>
                                <input type="datetime-local" id="mulai" name="waktu_mulai" class="form-control" value="<?= $waktuMulai ?>">
                                <span class="help-block"><?= $waktuMulai_err ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($waktuSelesai_err)) ? 'has-error' : ''; ?>">
                                <label for="selesai">Waktu Selesai</label>
                                <input type="datetime-local" id="selesai" name="waktu_selesai" class="form-control" value="<?= $waktuSelesai?>">
                                <span class="help-block"><?= $waktuSelesai_err ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                                <label for="status">Status</label><br>
                                <select name="status_pekerjaan">
                                        <option selected disabled>--- Status ---</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                <span class="help-block"><?= $status_err ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="pekerjaan.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>