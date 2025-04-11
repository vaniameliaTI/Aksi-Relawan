<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM pengguna WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            header("Location: home.php");
            exit();
        } else {
            header("Location: login.php?error=Email atau password salah!");
            exit();
        }
    } else {
        header("Location: login.php?error=Gagal mempersiapkan query.");
        exit();
    }
}
?>