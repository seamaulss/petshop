<?php
session_start();

$id = $_POST['id'];
$jumlah = $_POST['jumlah'];

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_SESSION['keranjang'][$id])) {
    $_SESSION['keranjang'][$id] += $jumlah;
} else {
    $_SESSION['keranjang'][$id] = $jumlah;
}

header("Location: keranjang.php");
?>