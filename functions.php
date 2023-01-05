<?php

function upload()
{
  $namaFile = $_FILES["image"]["name"];
  $ukuranFile = $_FILES["image"]["size"];
  $error = $_FILES["image"]["error"];
  $tmpName = $_FILES["image"]["tmp_name"];

  // Cek apakah tidak ada gambar yang diupload
  if ($error === 4) {
    echo "<script>
            alert('Please insert the picture');
          </script>";
    return false;
  }

  // Cek apakah yang diupload adalah gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
            alert('Your upload file is not a picture');
          </script>";
    return false;
  }

  // Cek jika ukurannya terlalu besar
  if ($ukuranFile > 1000000) {
    echo "<script>
            alert('The picture size is too large');
          </script>";
    return false;
  }

  // Lolos pengecekan gambar siap diupload
  // Generate nama gambar baru
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  return $namaFileBaru;
}

function alert($msg)
{
  echo "<script type='text/javascript'>alert('$msg');</script>";
}
