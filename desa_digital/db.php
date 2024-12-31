<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Default password MySQL di XAMPP
$dbname = 'desa_digital';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
