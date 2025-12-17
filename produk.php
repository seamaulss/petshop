<?php
require 'config/koneksi.php';
$produk = mysqli_query($conn, "
    SELECT produk.*, kategori.nama_kategori
    FROM produk
    JOIN kategori ON produk.kategori_id = kategori.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produk PetShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<!-- PRODUK -->
<div class="container my-5">
  <h2 class="text-center mb-4">Produk Kami</h2>

  <div class="row">
    <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow">
          <img src="assets/img/<?= $p['gambar']; ?>" class="card-img-top" style="height:180px; object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']); ?></h5>
            <p class="text-muted"><?= $p['nama_kategori']; ?></p>
            <p class="fw-bold">Rp <?= number_format($p['harga']); ?></p>
          </div>
          <div class="card-footer text-center bg-white">
            <a href="detail_produk.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-primary">
              Detail
            </a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
