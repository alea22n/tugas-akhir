<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect ke halaman utama jika sudah login
    exit();
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh data login (ganti dengan database untuk sistem sebenarnya)
    $user_data = [
        "admin" => "admin123", // username => password
        "user" => "user123"
    ];

    // Validasi login
    if (array_key_exists($username, $user_data) && $user_data[$username] == $password) {
        // Login berhasil
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect ke halaman utama
        exit();
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Desa Digital</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- Sesuaikan dengan file CSS Anda -->
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
