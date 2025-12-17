<?php
require '../config/koneksi.php';

$id = (int) $_GET['id'];
$status = $_GET['status']; // diproses / selesai

mysqli_query($conn, "
    UPDATE pesanan 
    SET status = '$status'
    WHERE id = $id
");

header("Location: pesanan.php");
?>