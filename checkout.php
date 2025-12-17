<?php

require 'config/koneksi.php';
require 'auth_user.php';

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Checkout</h3>

<?php if (empty($keranjang)) : ?>
  <div class="alert alert-warning">Keranjang kosong</div>
<?php else : ?>

<form action="proses_checkout.php" method="post">
<table class="table table-bordered">
<tr>
  <th>Produk</th>
  <th>Jumlah</th>
  <th>Subtotal</th>
</tr>

<?php foreach ($keranjang as $id => $qty) :
  $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id=$id"));
  $sub = $p['harga'] * $qty;
  $total += $sub;
?>
<tr>
  <td><?= htmlspecialchars($p['nama_produk']); ?></td>
  <td><?= $qty; ?></td>
  <td>Rp <?= number_format($sub); ?></td>
</tr>
<?php endforeach; ?>

<tr>
  <th colspan="2">Total</th>
  <th>Rp <?= number_format($total); ?></th>
</tr>
</table>

<button type="submit" class="btn btn-primary">
  Proses Pesanan
</button>
</form>

<?php endif; ?>
</div>

</body>
</html>
