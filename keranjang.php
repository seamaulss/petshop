<?php
session_start();
require 'auth_user.php';
require 'config/koneksi.php';

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Keranjang Belanja</h3>

<?php if (empty($keranjang)) : ?>
  <div class="alert alert-warning">Keranjang kosong</div>
<?php else : ?>

<table class="table table-bordered">
<tr>
  <th>Produk</th>
  <th>Harga</th>
  <th>Jumlah</th>
  <th>Subtotal</th>
  <th>Aksi</th>
</tr>

<?php foreach ($keranjang as $id => $qty) : 
  $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id=$id"));
  $sub = $p['harga'] * $qty;
  $total += $sub;
?>
<tr>
  <td><?= htmlspecialchars($p['nama_produk']); ?></td>
  <td>Rp <?= number_format($p['harga']); ?></td>
  <td><?= $qty; ?></td>
  <td>Rp <?= number_format($sub); ?></td>
  <td>
    <a href="hapus_keranjang.php?id=<?= $id; ?>" class="btn btn-sm btn-danger">
      Hapus
    </a>
  </td>
</tr>
<?php endforeach; ?>

<tr>
  <th colspan="3">Total</th>
  <th>Rp <?= number_format($total); ?></th>
  <th></th>
</tr>
</table>

<a href="checkout.php" class="btn btn-primary">Checkout</a>

<?php endif; ?>
</div>

</body>
</html>
