<?php
include 'config.php';

$id = 13; 
$email_baru = "Boby05New@gmail.com";
$nama_baru = "Boby Update";

// Cek apakah email sudah digunakan pengguna lain
$cek = mysqli_query($conn, "SELECT id FROM pengguna WHERE email = '$email_baru' AND id != $id");
if (mysqli_num_rows($cek) > 0) {
    echo "Email sudah digunakan oleh pengguna lain!";
    exit();
}

// Update data
$query = "UPDATE pengguna SET email = '$email_baru', nama = '$nama_baru' WHERE id = $id";
if (mysqli_query($conn, $query)) {
    echo "Data berhasil diupdate.";
} else {
    echo "Gagal update: " . mysqli_error($conn);
}
?>