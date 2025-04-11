<?php
include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT id, nama, email FROM pengguna";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Terdaftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center;
        }

        .container {
            background-color: white;
            border-radius: 15px;
            width: 95%;
            max-width: 1200px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #444;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .no-data {
            color: #888;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.jpg" alt="Logo" class="logo">
        <h2>Daftar Akun Terdaftar</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["nama"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="no-data">Belum ada data pengguna.</td>
                </tr>
            <?php endif; ?>
        </table>

        <a href="home.php" class="back-btn">← Kembali ke Home</a>
    </div>
</body>
</html>