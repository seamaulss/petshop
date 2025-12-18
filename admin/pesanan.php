<?php
require 'auth.php';
require '../config/koneksi.php';

$status = $_GET['status'] ?? '';
$keyword = $_GET['keyword'] ?? '';

// kondisi pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// kondisi filter
$where = "WHERE 1";
if ($status != '') {
  $where = "WHERE p.status = '$status'";
}

if ($keyword != '') {
  $keyword = mysqli_real_escape_string($conn, $keyword);
  $where .= " AND ( 
      u.nama LIKE '%$keyword%'
      OR p.id LIKE '%$keyword%'
      OR p.tanggal LIKE '%$keyword%'
   )";
}

$totalData = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT COUNT(*) AS total 
  FROM pesanan p
  JOIN users u  ON p.user_id = u.id
  $where
"))['total'];

$totalPage = ceil($totalData / $limit);

$result = mysqli_query($conn, "
  SELECT p.*, u.nama 
  FROM pesanan p 
  JOIN users u ON p.user_id = u.id
  $where
  ORDER BY p.id ASC
  LIMIT $limit OFFSET $offset
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
    <form method="GET" class="row g-2 mb-3">

      <input type="hidden" name="status" value="<?= $status; ?>">



      <!-- SEARCH -->
      <div class="col-md-4">
        <input
          type="text"
          name="keyword"
          class="form-control"
          placeholder="Cari nama user / ID / tanggal"
          value="<?= htmlspecialchars($keyword); ?>">
      </div>

      <div class="col-md-2">
        <button class="btn btn-secondary">Cari</button>
      </div>

      <!-- FILTER -->
    </form>

    <form method="GET" class="row g-2 mb-3">
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option value="">Semua Status</option>
          <option value="pending" <?= ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
          <option value="diproses" <?= ($status == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
          <option value="selesai" <?= ($status == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
      </div>
    </form>

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

    <?php if ($totalPage > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">

          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?status=<?= $status; ?>&page=<?= $page - 1; ?>">
                Prev
              </a>
            </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
              <a class="page-link" href="?status=<?= $status; ?><?= $keyword; ?>&page=<?= $i; ?>">
                <?= $i; ?>
              </a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $totalPage): ?>
            <li class="page-item">
              <a class="page-link" href="?status=<?= $status; ?>&page=<?= $page + 1; ?>">
                Next
              </a>
            </li>
          <?php endif; ?>

        </ul>
      </nav>
    <?php endif; ?>

  </div>

</body>

</html>