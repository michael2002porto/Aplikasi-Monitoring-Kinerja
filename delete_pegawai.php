<?php
require 'functions.php';


$id = $_GET["idPegawai"];

if (hapus($id) > 0) {
    echo "
        <script>
            alert('data berhasil di hapus !');
            document.location.href ='karyawan.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('data berhasil di hapus !');
            document.location.href ='karyawan.php';
        </script>
        ";
}

?>