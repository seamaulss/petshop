<?php

require 'auth_user.php';
require 'config/koneksi.php';

$id = $_POST['id'];
$file = $_FILES['bukti'];

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$namaFile = 'bukti_' . time() . '.' . $ext;

move_uploaded_file($file['tmp_name'], 'upload/bukti/' . $namaFile);

mysqli_query($conn, "
  UPDATE pesanan 
  SET bukti_pembayaran = '$namaFile'
  WHERE id = $id
");

header("Location: detail_pesanan_saya.php?id=$id");
?>