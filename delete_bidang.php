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
    
    // Process delete operation after confirmation
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Include config file
        require_once "config.php";

        // Prepare a delete statement
        $sql = "DELETE FROM bidang WHERE idBidang = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = trim($_POST["id"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: bidang.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        // Check existence of id parameter
        if (empty(trim($_GET["id"]))) {
            // URL doesn't contain id parameter. Redirect to error page
            header("loaction: error.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Record</title>
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
                            <h1>Delete Data Bidang</h1>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="alert alert-danger fade in">
                                <input type="hidden" name="id" value="<?= trim($_GET["id"]) ?>">
                                <p>Anda yakin ingin menghapus data ini?</p>
                                <br>
                                <p>
                                    <input type="submit" class="btn btn-danger" value="Yes">
                                    <a href="bidang.php" class="btn btn-default">Cancel</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>