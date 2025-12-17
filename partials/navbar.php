<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$notif = 0;

if (isset($_SESSION['user_id'])) {
  $uid = (int) $_SESSION['user_id'];

  $q = mysqli_query($conn, "
        SELECT COUNT(*) AS total 
        FROM pesanan 
        WHERE user_id = $uid 
        AND status = 'pending'
    ");

  $d = mysqli_fetch_assoc($q);
  $notif = $d['total'];
}

$jumlahKeranjang = 0;
if (isset($_SESSION['keranjang'])) {
  $jumlahKeranjang = array_sum($_SESSION['keranjang']);
}

?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">PetShop</a>

    <ul class="navbar-nav ms-auto">

      <li class="nav-item">
        <a class="nav-link" href="keranjang.php">
          Keranjang
          <?php if ($jumlahKeranjang > 0): ?>
            <span class="badge bg-warning text-dark">
              <?= $jumlahKeranjang; ?>
            </span>
          <?php endif; ?>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="pesanan_saya.php">
          Pesanan Saya
          <?php if ($notif > 0): ?>
            <span class="badge bg-danger"><?= $notif; ?></span>
          <?php endif; ?>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

    </ul>
  </div>
</nav>