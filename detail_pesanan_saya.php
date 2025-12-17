<?php

require 'auth_user.php';
require 'config/koneksi.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// pastikan pesanan milik user
$pesanan = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM pesanan 
                       WHERE id=$id AND user_id=$user_id")
);

if (!$pesanan) {
    echo "Pesanan tidak ditemukan";
    exit;
}

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

<?php if ($pesanan['status'] == 'pending') : ?>
<form action="proses_upload_bukti.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $pesanan['id']; ?>">

  <div class="mb-3">
    <label>Bukti Pembayaran</label>
    <input type="file" name="bukti" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-success">
    Upload Bukti
  </button>
</form>
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

<a href="pesanan_saya.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
