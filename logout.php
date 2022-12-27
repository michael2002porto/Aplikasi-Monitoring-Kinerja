<!-- Nama : Michael Natanael -->
<!-- NIM  : 2107411002 -->

<?php
session_start(); //inisialisasi session
if (session_destroy()) { //menghapus session
    header("Location: login.php"); //jika berhasil maka akan diredirect ke file login.php
}
