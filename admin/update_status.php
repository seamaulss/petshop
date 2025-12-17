<?php
require 'auth.php';
require '../config/koneksi.php';

$id = $_POST['id'];
$status = $_POST['status'];

// update status pesanan
mysqli_query($conn, "UPDATE pesanan SET status='$status' WHERE id=$id");

// ambil user_id pesanan
$p = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT user_id FROM pesanan WHERE id=$id")
);

$user_id = $p['user_id'];

// buat notifikasi
$pesan = "Pesanan #$id sekarang berstatus: $status";

mysqli_query($conn, "
  INSERT INTO notifikasi (user_id, pesan)
  VALUES ($user_id, '$pesan')
");


header("Location: detail_pesanan.php?id=$id");
?>