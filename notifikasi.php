<?php

require 'auth_user.php';
require 'config/koneksi.php';

$user_id = $_SESSION['user_id'];

// tandai notifikasi jadi dibaca
mysqli_query($conn, "
  UPDATE notifikasi 
  SET status='read' 
  WHERE user_id=$user_id
");

$result = mysqli_query($conn, "
  SELECT * FROM notifikasi 
  WHERE user_id=$user_id 
  ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifikasi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'partials/navbar.php'; ?>

<div class="container mt-5">
<h3>Notifikasi</h3>

<?php if (mysqli_num_rows($result) == 0) : ?>
  <div class="alert alert-info">Belum ada notifikasi</div>
<?php else : ?>

<ul class="list-group">
<?php while ($n = mysqli_fetch_assoc($result)) : ?>
  <li class="list-group-item">
    <?= htmlspecialchars($n['pesan']); ?>
    <br>
    <small class="text-muted"><?= $n['created_at']; ?></small>
  </li>
<?php endwhile; ?>
</ul>

<?php endif; ?>
</div>

</body>
</html>
