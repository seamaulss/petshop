<?php
session_start();
require 'auth_user.php';
require 'config/koneksi.php';

$user_id = (int) $_SESSION['user_id'];

$result = mysqli_query($conn, "
  SELECT * FROM pesanan 
  WHERE user_id = $user_id
  ORDER BY id DESC
");

if (!$result) {
  die(mysqli_error($conn));
}

$notif_result = mysqli_query($conn, "
  SELECT * FROM notifikasi 
  WHERE user_id = $user_id 
  AND status = 'unread'
  ORDER BY id DESC
");

$jumlah_notif = mysqli_num_rows($notif_result);

?>

<!DOCTYPE html>
<html>

<head>
  <title>Pesanan Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php require 'partials/navbar.php'; ?>

  <div class="container mt-5">
    <h3>Pesanan Saya</h3>

    <?php if (mysqli_num_rows($result) === 0): ?>
      <div class="alert alert-info">Belum ada pesanan</div>
    <?php else: ?>

      <?php if ($jumlah_notif > 0): ?>
        <?php while ($n = mysqli_fetch_assoc($notif_result)) : ?>
          <div class="alert alert-info">
            <?= htmlspecialchars($n['pesan']); ?>
          </div>
        <?php endwhile; ?>

        <?php
        mysqli_query($conn, "
    UPDATE notifikasi 
    SET status = 'read'
    WHERE user_id = $user_id
  ");
        ?>
      <?php endif; ?>


      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>

        <?php while ($p = mysqli_fetch_assoc($result)): ?>
          <?php
          $warna = 'secondary';
          if ($p['status'] == 'pending')   $warna = 'warning';
          if ($p['status'] == 'diproses')  $warna = 'primary';
          if ($p['status'] == 'selesai')   $warna = 'success';
          if ($p['status'] == 'batal')     $warna = 'danger';
          ?>

          <tr>
            <td>#<?= $p['id']; ?></td>
            <td><?= $p['tanggal']; ?></td>
            <td>Rp <?= number_format($p['total']); ?></td>
            <td>
              <span class="badge bg-<?= $warna; ?>">
                <?= $p['status']; ?>
              </span>
            </td>
            <td>
              <a href="detail_pesanan_saya.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-primary">
                Detail
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>

    <?php endif; ?>
  </div>

</body>

</html>