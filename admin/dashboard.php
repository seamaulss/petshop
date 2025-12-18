<?php
require 'auth.php';
require '../config/koneksi.php';

// total pesanan
$q1 = mysqli_query($conn, "SELECT COUNT(*) total FROM pesanan");
$totalPesanan = mysqli_fetch_assoc($q1)['total'];

// total pendapatan (pesanan selesai)
$q2 = mysqli_query($conn, "
  SELECT SUM(total) total 
  FROM pesanan 
  WHERE status = 'selesai'
");
$totalPendapatan = mysqli_fetch_assoc($q2)['total'] ?? 0;

// pesanan hari ini
$q3 = mysqli_query($conn, "
  SELECT COUNT(*) total 
  FROM pesanan 
  WHERE DATE(tanggal) = CURDATE()
");
$pesananHariIni = mysqli_fetch_assoc($q3)['total'];

// pesanan pending
$q4 = mysqli_query($conn, "
  SELECT COUNT(*) total 
  FROM pesanan 
  WHERE status = 'pending'
");
$pending = mysqli_fetch_assoc($q4)['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Dashboard Admin</h3>

<div class="row mt-4">

  <div class="col-md-3">
    <div class="card text-bg-primary mb-3">
      <div class="card-body">
        <h5>Total Pesanan</h5>
        <h2><?= $totalPesanan; ?></h2>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-bg-success mb-3">
      <div class="card-body">
        <h5>Total Pendapatan</h5>
        <h4>Rp <?= number_format($totalPendapatan); ?></h4>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-bg-warning mb-3">
      <div class="card-body">
        <h5>Pesanan Hari Ini</h5>
        <h2><?= $pesananHariIni; ?></h2>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-bg-danger mb-3">
      <div class="card-body">
        <h5>Pending</h5>
        <h2><?= $pending; ?></h2>
      </div>
    </div>
  </div>

</div>

<hr>

<h5>Pesanan Terbaru</h5>
<table class="table table-bordered">
<tr>
  <th>User</th>
  <th>Total</th>
  <th>Status</th>
</tr>

<?php
$latest = mysqli_query($conn, "
  SELECT p.*, u.nama 
  FROM pesanan p 
  JOIN users u ON p.user_id = u.id
  ORDER BY p.tanggal DESC
  LIMIT 5
");
while ($p = mysqli_fetch_assoc($latest)) :
?>
<tr>
  <td><?= htmlspecialchars($p['nama']); ?></td>
  <td>Rp <?= number_format($p['total']); ?></td>
  <td><?= $p['status']; ?></td>
</tr>
<?php endwhile; ?>
</table>

</div>

</body>
</html>
