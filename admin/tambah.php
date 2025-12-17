<?php
require 'auth.php';
require '../config/koneksi.php';

if (isset($_POST['submit'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../assets/img/".$gambar);

    mysqli_query($conn, "INSERT INTO produk VALUES
    (NULL, '$nama', $harga, $stok, '', '$gambar', 1)");

    header("Location: produk.php");
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" placeholder="Nama Produk" required><br><br>
    <input type="number" name="harga" placeholder="Harga" required><br><br>
    <input type="number" name="stok" placeholder="Stok" required><br><br>
    <input type="file" name="gambar" required><br><br>
    <button type="submit" name="submit">Simpan</button>
</form>
