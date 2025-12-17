<?php
session_start();
require 'auth_user.php';
require 'config/koneksi.php';

// ambil id pesanan
if (!isset($_GET['id'])) {
    header("Location: pesanan_saya.php");
    exit;
}

$id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// pastikan pesanan milik user
$pesanan = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT * FROM pesanan 
        WHERE id = $id AND user_id = $user_id
    ")
);

if (!$pesanan) {
    echo "Pesanan tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
    <h3>Upload Bukti Pembayaran</h3>
    <p>ID Pesanan: <strong>#<?= $pesanan['id']; ?></strong></p>
    <p>Total: <strong>Rp <?= number_format($pesanan['total']); ?></strong></p>

    <form action="proses_upload_bukti.php" 
          method="post" 
          enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $pesanan['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Bukti Pembayaran (JPG / PNG)</label>
            <input type="file" 
                   name="bukti" 
                   class="form-control" 
                   accept="image/*"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Upload Bukti
        </button>

        <a href="detail_pesanan_saya.php?id=<?= $pesanan['id']; ?>" 
           class="btn btn-secondary">
           Kembali
        </a>
    </form>
</div>

</body>
</html>
