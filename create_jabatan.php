<?php
    // Include config file
    require_once "config.php";

    // Tentukan variabel dan inisialisasi dengan nilai kosong
    $jabatan = "";
    $jabatan_err = "";

    // Memproses data formulir saat formulir dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Validate nama jabatan
        $input_jabatan = trim($_POST["nama_jabatan"]);
        if (empty($input_jabatan)) {
            $jabatan_err = "Please enter a name";
        } else {
            $jabatan = $input_jabatan;
        }

        // Check input errors before inserting in database
        if (empty($jabatan_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO jabatan (nama_jabatan) VALUES (?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_jabatan);

                // Set parameters
                $param_jabatan = $jabatan;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: jabatan.php");
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
        <title>Create Record Jabatan</title>
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
                            <h2>Tambah Data Jabatan</h2>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group <?php echo (!empty($jabatan_err)) ? 'has-error' : ''; ?>">
                                <label for="nama_jabatan">Nama Jabatan</label>
                                <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control" value="<?= $jabatan ?>">
                                <span class="help-block"><?= $jabatan_err ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="jabatan.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>