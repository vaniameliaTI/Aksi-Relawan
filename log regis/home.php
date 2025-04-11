<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php"); // Jika belum login, arahkan ke halaman login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat datang, <?php echo $_SESSION["user_name"]; ?>!</h2>
    <a href="tampil.php" class="btn">Lihat Akun Terdaftar</a>
    <a href="logout.php" class="btn logout">Logout</a>

</body>
</html>