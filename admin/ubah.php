<?php
require 'auth.php';
require '../config/koneksi.php';

$id = $_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id=$id"));

if (isset($_POST['submit'])) {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    if ($_FILES['gambar']['name'] != '') {
        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../assets/img/".$gambar);

        mysqli_query($conn, "UPDATE produk SET
            nama_produk='$nama',
            harga=$harga,
            stok=$stok,
            gambar='$gambar'
            WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE produk SET
            nama_produk='$nama',
            harga=$harga,
            stok=$stok
            WHERE id=$id");
    }

    header("Location: produk.php");
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" value="<?= $p['nama_produk']; ?>"><br><br>
    <input type="number" name="harga" value="<?= $p['harga']; ?>"><br><br>
    <input type="number" name="stok" value="<?= $p['stok']; ?>"><br><br>

    <img src="../assets/img/<?= $p['gambar']; ?>" width="100"><br><br>

    <input type="file" name="gambar"><br><br>
    <button type="submit" name="submit">Update</button>
</form>
