<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Desa Digital</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- Menambahkan link CSS -->
</head>
<body>
    <h1>Selamat datang di Sistem Manajemen Desa Digital</h1>
    <p>Gunakan sistem ini untuk mengelola data desa, termasuk data warga, surat menyurat, dan informasi kegiatan desa.</p>

    <p>Selamat datang, <?php echo $_SESSION['username']; ?>! <br>
    <a href="logout.php">Logout</a></p>

    <h2>Menu Utama</h2>
    <ul>
        <li><a href="warga.php">Pengelolaan Data Warga</a></li>
        <li><a href="surat.php">Pengelolaan Surat</a></li>
        <li><a href="kegiatan.php">Informasi Kegiatan Desa</a></li>
    </ul>

    <h2>Fitur Sistem</h2>
    <p>Sistem ini memiliki fitur utama untuk mengelola data sebagai berikut:</p>
    <ul>
        <li><strong>Data Warga Desa:</strong> Menambah, melihat, mengedit, dan menghapus data warga.</li>
        <li><strong>Pengelolaan Surat Menyurat:</strong> Menangani pengajuan surat seperti surat keterangan dan surat pengantar.</li>
        <li><strong>Informasi Kegiatan Desa:</strong> Mengelola informasi tentang kegiatan yang ada di desa.</li>
    </ul>

    <footer>
        <p>&copy; 2024 Sistem Manajemen Desa Digital | Dibuat oleh [Alya,Nabila,Syifa]</p>
    </footer>
</body>
</html>
