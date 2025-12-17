<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Admin PetShop</a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#adminMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminMenu">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard | </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="produk.php">Kelola Produk | </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="pesanan.php">Kelola Pesanan | </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
