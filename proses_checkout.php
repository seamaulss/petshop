<?php
session_start();
require 'auth_user.php';
require 'config/koneksi.php';

$user_id = (int) $_SESSION['user_id'];
$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
  die("Keranjang kosong");
}

mysqli_begin_transaction($conn);

try {
  $total = 0;

  foreach ($keranjang as $id => $qty) {
    $id  = (int)$id;
    $qty = (int)$qty;

    if ($qty <= 0) {
      throw new Exception("Jumlah tidak valid");
    }

    $p = mysqli_fetch_assoc(mysqli_query($conn,
      "SELECT harga, stok FROM produk WHERE id=$id FOR UPDATE"
    ));

    if (!$p) {
      throw new Exception("Produk tidak ditemukan");
    }

    if ($qty > $p['stok']) {
      throw new Exception("Stok produk tidak cukup");
    }

    $total += $p['harga'] * $qty;
  }

  mysqli_query($conn,
    "INSERT INTO pesanan (user_id, total, tanggal, status)
     VALUES ($user_id, $total, NOW(), 'pending')"
  );

  $pesanan_id = mysqli_insert_id($conn);

  foreach ($keranjang as $id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn,
      "SELECT harga FROM produk WHERE id=$id"
    ));

    mysqli_query($conn,
      "INSERT INTO pesanan_detail 
      (pesanan_id, produk_id, jumlah, harga)
      VALUES ($pesanan_id, $id, $qty, {$p['harga']})"
    );

    mysqli_query($conn,
      "UPDATE produk SET stok = stok - $qty WHERE id=$id"
    );
  }

  mysqli_query($conn,
    "INSERT INTO notifikasi (user_id, pesan, status, created_at)
     VALUES ($user_id, 'Pesanan #$pesanan_id berhasil dibuat', 'unread', NOW())"
  );

  mysqli_commit($conn);
  unset($_SESSION['keranjang']);

  header("Location: sukses.php");
  exit;

} catch (Exception $e) {
  mysqli_rollback($conn);
  echo "Checkout gagal: " . $e->getMessage();
}
?>