<?php
include 'db.php';

// Tambah Data Surat
if (isset($_POST['submit'])) {
    $jenis_surat = $_POST['jenis_surat'];
    $keperluan = $_POST['keperluan'];
    $tanggal_pengajuan = $_POST['tanggal_pengajuan'];

    // Proses upload file
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Tentukan lokasi penyimpanan file
    $file_destination = 'uploads/' . uniqid('', true) . '.' . $file_ext;

    if ($file_error === 0) {
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $sql = "INSERT INTO surat (jenis_surat, keperluan, tanggal_pengajuan, file_path) VALUES ('$jenis_surat', '$keperluan', '$tanggal_pengajuan', '$file_destination')";
            if ($conn->query($sql) === TRUE) {
                header("Location: surat.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File upload error.";
    }
}

// Hapus Data Surat
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Ambil file path untuk menghapus file
    $result = $conn->query("SELECT file_path FROM surat WHERE id=$id");
    $row = $result->fetch_assoc();
    $file_path = $row['file_path'];
    if (unlink($file_path)) {
        $sql = "DELETE FROM surat WHERE id=$id";
        $conn->query($sql);
        header("Location: surat.php");
    } else {
        echo "Error deleting file.";
    }
}

// Edit Data Surat
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $jenis_surat = $_POST['jenis_surat'];
    $keperluan = $_POST['keperluan'];
    $tanggal_pengajuan = $_POST['tanggal_pengajuan'];

    // Proses upload file jika ada
    if ($_FILES['file']['name'] != '') {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $file_destination = 'uploads/' . uniqid('', true) . '.' . $file_ext;

        if ($file_error === 0) {
            if (move_uploaded_file($file_tmp, $file_destination)) {
                $sql = "UPDATE surat SET jenis_surat='$jenis_surat', keperluan='$keperluan', tanggal_pengajuan='$tanggal_pengajuan', file_path='$file_destination' WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    header("Location: surat.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "File upload error.";
        }
    } else {
        // Jika tidak ada file baru, update tanpa file
        $sql = "UPDATE surat SET jenis_surat='$jenis_surat', keperluan='$keperluan', tanggal_pengajuan='$tanggal_pengajuan' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: surat.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Ambil Data Surat
$result = $conn->query("SELECT * FROM surat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Surat Desa</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* CSS yang sama seperti pada halaman warga */
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
    <a href="index.php" class="back-btn">Kembali</a>

    <h1>Data Surat Desa</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <input type="text" name="jenis_surat" id="jenis_surat" placeholder="Jenis Surat" required>
        <textarea name="keperluan" id="keperluan" placeholder="Keperluan" required></textarea>
        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" required>
        <input type="file" name="file" id="file">
        <button type="submit" name="submit">Tambah</button>
        <button type="submit" name="update" style="display:none;" id="update-btn">Update</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Jenis Surat</th>
            <th>Keperluan</th>
            <th>Tanggal Pengajuan</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['jenis_surat'] ?></td>
                <td><?= $row['keperluan'] ?></td>
                <td><?= $row['tanggal_pengajuan'] ?></td>
                <td><a href="<?= $row['file_path'] ?>" target="_blank">Lihat File</a></td>
                <td>
                    <a href="#" onclick="editData(<?= $row['id'] ?>, '<?= $row['jenis_surat'] ?>', '<?= $row['keperluan'] ?>', '<?= $row['tanggal_pengajuan'] ?>', '<?= $row['file_path'] ?>')">Edit</a> |
                    <a href="surat.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function editData(id, jenis_surat, keperluan, tanggal_pengajuan, file_path) {
            document.getElementById('id').value = id;
            document.getElementById('jenis_surat').value = jenis_surat;
            document.getElementById('keperluan').value = keperluan;
            document.getElementById('tanggal_pengajuan').value = tanggal_pengajuan;
            document.getElementById('update-btn').style.display = 'inline';
        }
    </script>
</body>
</html>
