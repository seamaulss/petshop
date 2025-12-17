<?php
session_start();
require 'config/koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($q);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Login User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 col-md-4">
<h3 class="text-center">Login User</h3>

<?php if (isset($error)) : ?>
<div class="alert alert-danger">Email / Password salah</div>
<?php endif; ?>

<form method="post">
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<button name="login" class="btn btn-success w-100">Login</button>
</form>

<p class="text-center mt-3">
Belum punya akun? <a href="register.php">Register</a>
</p>
</div>

</body>
</html>
