<?php
require 'config/koneksi.php';

if (isset($_POST['register'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $email  = htmlspecialchars($_POST['email']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $hp     = htmlspecialchars($_POST['no_hp']);
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar";
    } else {
        mysqli_query($conn, "INSERT INTO users VALUES
        (NULL, '$nama', '$email', '$pass', '$alamat', '$hp')");
        header("Location: login.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 col-md-5">
<h3 class="text-center">Register User</h3>

<?php if (isset($error)) : ?>
<div class="alert alert-danger"><?= $error; ?></div>
<?php endif; ?>

<form method="post">
<input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<textarea name="alamat" class="form-control mb-2" placeholder="Alamat"></textarea>
<input type="text" name="no_hp" class="form-control mb-2" placeholder="No HP">
<button name="register" class="btn btn-primary w-100">Register</button>
</form>
</div>

</body>
</html>
