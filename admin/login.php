<?php
session_start();
require '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
<h2>Login Admin</h2>

<?php if (isset($error)) : ?>
    <p style="color:red;">Username / Password salah</p>
<?php endif; ?>

<form method="post">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>
</body>
</html>
