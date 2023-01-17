<?php
require("config.php");
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

function addData($data)
{
  global $link;
  //ambil data dari setiap elemen dalam form
  $nama = htmlspecialchars($data["nama"]);
  $nip = htmlspecialchars($data["nip"]);
  $jabatan = htmlspecialchars($data["jabatan"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $bidang = htmlspecialchars($data["bidang"]);

  $foto = upload();


  // querry insert data
  $query = "INSERT INTO pegawai 
              VALUES('','$nip','$nama','$jabatan','$alamat','$bidang','$foto')";
  mysqli_query($link, $query);


  // return mysqli_affected_rows($link);
}
// function getIdJabatan($jabatan)
// {
//   global $link;
//   print($link);
//   die;
//   $query = "SELECT idJabatan FROM jabatan WHERE nama_jabatan = $jabatan";

//   $sql = mysqli_query($link, $query);
//   $hasil = [];
//   print($sql);
//   while ($result = mysqli_fetch_assoc($sql)) {
//     $hasil[] = $result;
//   }

//   return $hasil['idJabatan'];
// }

// function getIdBidang($bidang)
// {
//   global $link;
//   $query = "SELECT idBidang FROM bidang WHERE nama_bidang = $bidang";

//   $sql = mysqli_query($link, $query);
//   $hasil = [];
//   while ($result = mysqli_fetch_assoc($sql)) {
//     $hasil[] = $result;
//   }

//   return $hasil['idBidang'];
// }
function hapus($id)
{
  global $link;
  mysqli_query($link, "DELETE FROM pegawai where idPegawai=$id");
  return mysqli_affected_rows($link);
}
function pagination($page, $limit)
{
  $sql = "SELECT * FROM pegawai LIMIT $page, $limit";
  /*
  Pada query diatas terdapat properti LIMIT 
  yang berguna untuk membatasi pengambilan data 
  dari pernyataan SELECT
  */
  return query($sql);
  // Lalu selanjutnya mengirimkan query tersebut ke dalam 
  // fungsi getDataFromDB yang berguna untuk mengambil data dari database
}
function search($keyword)
{
  // $sql = "SELECT * FROM pegawai 
  // WHERE idPegawai LIKE '%$keyword%'
  // OR nip LIKE '%$keyword%'
  // OR nama_peg LIKE '%$keyword%'";

  $sql = "SELECT pegawai.idPegawai as idPegawai, pegawai.photo as photo, pegawai.nip as nip, pegawai.nama_peg as nama_peg, jabatan.nama_jabatan as jabatan FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.idJabatan WHERE nama_peg LIKE '%$keyword%' OR idPegawai LIKE '%$keyword%' OR nip LIKE '%$keyword%' ";
  /*
  Pada query diatas terdapat properti LIKE 
  yang berguna untuk mengecek apakah ada data yang sesuai dengan keyword
  dari pernyataan SELECT
  */

  return query($sql);
  // Lalu selanjutnya mengirimkan query tersebut ke dalam 
  // fungsi getDataFromDB yang berguna untuk mengambil data dari database
}
function query($query)
{
  global $link;
  $result = mysqli_query($link, $query);
  $rows = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}
function update($data)
{
  global $link;
  $id = $data["idPegawai"];
  $nama = htmlspecialchars($data["nama_peg"]);
  $number = htmlspecialchars($data["nip"]);
  $jabatan = htmlspecialchars($data["id_jabatan"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $bidang = htmlspecialchars($data["id_bidang"]);
  $name = $nama;
  $img = $data['currentPhoto'];
  if ($_FILES['image']['error'] === 0) {
    $img = upload();
  }
  // var_dump($data);
  // die;
  $query = "UPDATE  pegawai SET
                    nip = '$number',
                    nama_peg = '$nama',
                    id_jabatan = $jabatan,
                    alamat ='$alamat',
                    id_bidang = $bidang,
                    photo = '$img'
                    WHERE idPegawai = $id ";
  mysqli_query($link, $query);
  return mysqli_affected_rows($link);
}