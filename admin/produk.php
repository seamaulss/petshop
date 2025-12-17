<?php
require 'auth.php';
require '../config/koneksi.php';

$produk = mysqli_query($conn, "SELECT * FROM produk");
?>

<?php require 'partials/navbar.php'; ?>

<h2>Kelola Produk</h2>
<a href="tambah.php">Tambah Produk</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td>
                <img src="../assets/img/<?= $p['gambar']; ?>" width="80">
            </td>

            <td><?= $p['nama_produk']; ?></td>
            <td><?= $p['harga']; ?></td>
            <td><?= $p['stok']; ?></td>
            <td>
                <a href="ubah.php?id=<?= $p['id']; ?>">Edit</a> |
                <a href="hapus.php?id=<?= $p['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>