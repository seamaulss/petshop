<?php

require 'auth_user.php';

$id = $_GET['id'];
unset($_SESSION['keranjang'][$id]);

header("Location: keranjang.php");
?>