<?php
include 'config.php';

$id = 20; // ID pengguna yang ingin dihapus

$query = "DELETE FROM pengguna WHERE id = $id";
if (mysqli_query($conn, $query)) {
    echo "Data berhasil dihapus.";
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>