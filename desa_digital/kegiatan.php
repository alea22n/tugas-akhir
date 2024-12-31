<?php 
include 'db.php';

// Tambah Kegiatan
if (isset($_POST['submit'])) {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
    $keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO kegiatan (nama_kegiatan, tanggal_kegiatan, keterangan) VALUES ('$nama_kegiatan', '$tanggal_kegiatan', '$keterangan')";
    if ($conn->query($sql) === TRUE) {
        header("Location: kegiatan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Kegiatan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM kegiatan WHERE id=$id";
    $conn->query($sql);
    header("Location: kegiatan.php");
}

// Ambil Data Kegiatan
$result = $conn->query("SELECT * FROM kegiatan");

// Edit Kegiatan
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM kegiatan WHERE id=$id";
    $editResult = $conn->query($sql);
    $editRow = $editResult->fetch_assoc();
}

// Update Kegiatan
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
    $keterangan = $_POST['keterangan'];

    $sql = "UPDATE kegiatan SET nama_kegiatan='$nama_kegiatan', tanggal_kegiatan='$tanggal_kegiatan', keterangan='$keterangan' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: kegiatan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Desa</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- Menambahkan link CSS -->
    <style>
        /* Menyesuaikan tema warna biru kehijauan */
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
            background-color: #4DB6AC;
            color: white;
        }
        td {
            background-color: #E0F2F1;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #4DB6AC;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .back-btn:hover {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

    <!-- Tombol Kembali -->
    <a href="index.php" class="back-btn">Kembali</a>

    <h1>Informasi Kegiatan Desa</h1>

    <!-- Form untuk Tambah atau Edit Kegiatan -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= isset($editRow) ? $editRow['id'] : ''; ?>">

        <input type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" value="<?= isset($editRow) ? $editRow['nama_kegiatan'] : ''; ?>" required>

        <input type="date" name="tanggal_kegiatan" value="<?= isset($editRow) ? $editRow['tanggal_kegiatan'] : ''; ?>" required>

        <textarea name="keterangan" placeholder="Keterangan" required><?= isset($editRow) ? $editRow['keterangan'] : ''; ?></textarea>

        <button type="submit" name="<?= isset($editRow) ? 'update' : 'submit'; ?>">
            <?= isset($editRow) ? 'Update Kegiatan' : 'Tambah Kegiatan'; ?>
        </button>
    </form>

    <!-- Tabel Data Kegiatan -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal Kegiatan</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_kegiatan'] ?></td>
                <td><?= $row['tanggal_kegiatan'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td>
                    <a href="kegiatan.php?edit=<?= $row['id'] ?>">Edit</a> |
                    <a href="kegiatan.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
