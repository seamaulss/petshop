<?php

require 'config/koneksi.php';
require 'auth_user.php';

$keranjang = $_SESSION['keranjang'];
$user_id = $_SESSION['user_id'];
$total = 0;



// hitung total
foreach ($keranjang as $id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM produk WHERE id=$id"));
    $total += $p['harga'] * $qty;
}

// simpan pesanan
mysqli_query($conn, "INSERT INTO pesanan (user_id, total) VALUES ($user_id, $total)");
$pesanan_id = mysqli_insert_id($conn);

// simpan detail + kurangi stok
foreach ($keranjang as $id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga, stok FROM produk WHERE id=$id"));

    mysqli_query($conn, "INSERT INTO pesanan_detail 
        (pesanan_id, produk_id, jumlah, harga)
        VALUES ($pesanan_id, $id, $qty, {$p['harga']})");

    mysqli_query($conn, "UPDATE produk 
        SET stok = stok - $qty 
        WHERE id = $id");
}

// kosongkan keranjang
unset($_SESSION['keranjang']);

header("Location: sukses.php");
?>