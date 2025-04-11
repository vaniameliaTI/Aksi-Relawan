<?php
session_start();
include 'config.php'; // pastikan file config.php ada dan sudah benar

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nama = $_POST['nama']; // disamakan dengan field input
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        header("Location: register.php?error=Password tidak cocok");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk insert user baru ke database
    $query = "INSERT INTO pengguna (nama, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?message=Registrasi berhasil, silakan login.");
            exit();
        } else {
            echo "Error executing query: " . mysqli_error($conn);  // Debug
            exit();
        }
    } else {
        echo "Error preparing query: " . mysqli_error($conn);  // Debug
        exit();
    }    
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex-direction: column;
            padding: 20px;
        }
        .logo {
            display: block;
            margin: 0 auto 10px;
            width: 150px;
        }
        .register-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 10px;
        }
        .register-section h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .register-section input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-section button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .help {
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }
        .help a {
            color: blue;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.jpg" alt="Aksi Relawan" class="logo">
        <div class="register-section">
            <h2>Daftar Volunteer</h2>
            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <form action="proses_register.php" method="POST">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" name="nama" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <label for="confirm_password">Konfirmasi Password:</label>
                <input type="password" name="confirm_password" required>
                <button type="submit" name="register">Daftar</button>
            </form>
            <p class="help">Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>