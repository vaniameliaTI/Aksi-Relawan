<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "akun"; 

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>