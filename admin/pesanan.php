<?php
require 'auth.php';
require '../config/koneksi.php';

$result = mysqli_query($conn, "
  SELECT p.*, u.nama 
  FROM pesanan p 
  JOIN users u ON p.user_id = u.id
  ORDER BY p.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Data Pesanan</h3>

<table class="table table-bordered">
<tr>
  <th>ID</th>
  <th>Nama User</th>
  <th>Total</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>

<?php while ($p = mysqli_fetch_assoc($result)) : ?>
<tr>
  <td><?= $p['id']; ?></td>
  <td><?= htmlspecialchars($p['nama']); ?></td>
  <td>Rp <?= number_format($p['total']); ?></td>
  <td>
    <span class="badge bg-info"><?= $p['status']; ?></span>
  </td>
  <td>
    <a href="detail_pesanan.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-primary">
      Detail
    </a>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
