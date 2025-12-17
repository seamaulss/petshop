<?php
require 'auth.php';
require '../config/koneksi.php';

$id = $_GET['id'];

$pesanan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM pesanan WHERE id=$id")
);

$detail = mysqli_query($conn, "
  SELECT d.*, p.nama_produk
  FROM pesanan_detail d
  JOIN produk p ON d.produk_id = p.id
  WHERE d.pesanan_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Detail Pesanan #<?= $id; ?></h3>

<p>Status: <strong><?= $pesanan['status']; ?></strong></p>

<?php if ($pesanan['bukti_pembayaran']) : ?>
  <p>
    <strong>Bukti Pembayaran:</strong><br>
    <img src="../upload/bukti/<?= $pesanan['bukti_pembayaran']; ?>" 
         width="200" class="img-thumbnail">
  </p>
<?php else : ?>
  <p class="text-danger">Belum upload bukti</p>
<?php endif; ?>


<table class="table table-bordered">
<tr>
  <th>Produk</th>
  <th>Jumlah</th>
  <th>Harga</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($detail)) : ?>
<tr>
  <td><?= htmlspecialchars($d['nama_produk']); ?></td>
  <td><?= $d['jumlah']; ?></td>
  <td>Rp <?= number_format($d['harga']); ?></td>
</tr>
<?php endwhile; ?>
</table>

<form action="update_status.php" method="post">
  <input type="hidden" name="id" value="<?= $id; ?>">
  <select name="status" class="form-select w-25 mb-3">
    <option value="pending">Pending</option>
    <option value="diproses">Diproses</option>
    <option value="selesai">Selesai</option>
  </select>
  <button type="submit" class="btn btn-success">Update Status</button>
</form>

</div>
</body>
</html>
