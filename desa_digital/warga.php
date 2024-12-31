<?php
include 'db.php';

// Tambah Data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $sql = "INSERT INTO warga (nama, alamat, tanggal_lahir) VALUES ('$nama', '$alamat', '$tanggal_lahir')";
    if ($conn->query($sql) === TRUE) {
        header("Location: warga.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM warga WHERE id=$id";
    $conn->query($sql);
    header("Location: warga.php");
}

// Edit Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $sql = "UPDATE warga SET nama='$nama', alamat='$alamat', tanggal_lahir='$tanggal_lahir' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: warga.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil Data
$result = $conn->query("SELECT * FROM warga");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga Desa</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            width: 50%;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4DB6AC; /* Blue-Green background for table header */
            color: white;
        }
        td {
            background-color: #E0F2F1; /* Lighter blue-green for table cells */
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Tombol kembali ke index */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #4DB6AC; /* Matching theme color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .back-btn:hover {
            background-color: #4CAF50; /* Slightly darker on hover */
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-btn">Kembali</a>

    <h1>Data Warga Desa</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" id="id">
        <input type="text" name="nama" id="nama" placeholder="Nama" required>
        <textarea name="alamat" id="alamat" placeholder="Alamat" required></textarea>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required>
        <button type="submit" name="submit">Tambah</button>
        <button type="submit" name="update" style="display:none;" id="update-btn">Update</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['tanggal_lahir'] ?></td>
                <td>
                    <a href="#" onclick="editData(<?= $row['id'] ?>, '<?= $row['nama'] ?>', '<?= $row['alamat'] ?>', '<?= $row['tanggal_lahir'] ?>')">Edit</a> |
                    <a href="warga.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function editData(id, nama, alamat, tanggal_lahir) {
            document.getElementById('id').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('alamat').value = alamat;
            document.getElementById('tanggal_lahir').value = tanggal_lahir;
            document.getElementById('update-btn').style.display = 'inline';
        }
    </script>
</body>
</html>
