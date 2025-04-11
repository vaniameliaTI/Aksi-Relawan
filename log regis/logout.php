<?php
session_start();
session_destroy(); // Menghancurkan semua session
header("Location: register.php?message=Anda telah logout. "); // Redirect ke halaman login setelah logout
exit();
?>