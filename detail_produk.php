<?php

require 'config/koneksi.php';

// validasi id
if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id = (int)$_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$p = mysqli_fetch_assoc($query);

if (!$p) {
    echo "Produk tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($p['nama_produk']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-6">
      <img src="assets/img/<?= htmlspecialchars($p['gambar']); ?>" class="img-fluid rounded">
    </div>

    <div class="col-md-6">
      <h2><?= htmlspecialchars($p['nama_produk']); ?></h2>
      <h4 class="text-success">Rp <?= number_format($p['harga']); ?></h4>
      <p><?= htmlspecialchars($p['deskripsi']); ?></p>
      <p>Stok: <?= $p['stok']; ?></p>

      <!-- FORM TAMBAH KE KERANJANG -->
      <form action="tambah_keranjang.php" method="post">
        <input type="hidden" name="id" value="<?= $p['id']; ?>">

        <div class="mb-3">
          <label>Jumlah</label>
          <input type="number" name="jumlah" class="form-control"
                 value="1" min="1" max="<?= $p['stok']; ?>" required>
        </div>

        <button type="submit" class="btn btn-success">
          🛒 Tambah ke Keranjang
        </button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
