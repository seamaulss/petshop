<?php
require 'config/koneksi.php';
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC LIMIT 4");
?>

<?php require 'partials/navbar.php'; ?>


<div class="container my-5">
  <h3 class="text-center mb-4">Produk Terbaru</h3>
  <div class="row">
    <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
      <div class="col-md-3">
        <div class="card h-100">
          <img src="assets/img/<?= htmlspecialchars($p['gambar']); ?>" class="card-img-top">

          <div class="card-body text-center">
            <h5><?= htmlspecialchars($p['nama_produk']); ?></h5>
            <p>Rp <?= number_format($p['harga']); ?></p>

            <!-- TAMBAHAN PENTING -->
            <a href="detail_produk.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-primary">
              Detail Produk
            </a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
