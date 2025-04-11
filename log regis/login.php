<?php
session_start();
include 'config.php'; // pastikan file config.php ada dan sudah benar

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Query untuk cek email dan password
    $query = "SELECT * FROM pengguna WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Cek apakah user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php"); // Redirect ke halaman home
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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
            padding: 40px;
            justify-content: center;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #333;
        }
        p {
            text-align: center;
            font-size: 14px;
        }
        p a {
            color: blue;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    <img src="logo.jpg" alt="Aksi Relawan" class="logo">
        <h2>Login Volunteer</h2>
        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form action="proses_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>