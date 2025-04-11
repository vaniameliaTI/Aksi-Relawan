<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nama = $_POST["nama"];
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        header("Location: register.php?error=Password tidak cocok!");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO pengguna (nama, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?message=Registrasi berhasil, silakan login.");
        } else {
            header("Location: register.php?error=Gagal mendaftar.");
        }
    } else {
        header("Location: register.php?error=Query error.");
    }
    exit();
}
?>