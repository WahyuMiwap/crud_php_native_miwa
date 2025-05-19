<?php
include 'db.php';

if (!isset($_GET['kode'])) {
    header("Location: index.php");
    exit;
}

$kode = $_GET['kode'];

// Ambil data barang dari database
$sql = "SELECT * FROM barang WHERE kode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Data tidak ditemukan!";
    exit;
}

$barang = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang  = $_POST['nama_barang'];
    $deskripsi    = $_POST['deskripsi'];
    $harga_satuan = $_POST['harga_satuan'];
    $jumlah      = $_POST['jumlah'];

    // Cek apakah ada foto baru yang diupload
    if ($_FILES['foto']['name']) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp  = $_FILES['foto']['tmp_name'];
        $foto_path = 'uploads/' . $foto_name;

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            $foto_to_save = $foto_name;
            // Optional: Hapus foto lama jika ada
            if ($barang['foto'] && file_exists('uploads/' . $barang['foto'])) {
                unlink('uploads/' . $barang['foto']);
            }
        } else {
            echo "Gagal upload foto baru.";
            exit;
        }
    } else {
        // Tidak ganti foto, pakai foto lama
        $foto_to_save = $barang['foto'];
    }

    // Update data
    $sql_update = "UPDATE barang SET nama_barang=?, deskripsi=?, harga_satuan=?, jumlah=?, foto=? WHERE kode=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssiiis", $nama_barang, $deskripsi, $harga_satuan, $jumlah, $foto_to_save, $kode);

    if ($stmt_update->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal update data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h2 class="mb-4">Edit Barang</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Kode Barang</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($barang['kode']) ?>" disabled>
    </div>
    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($barang['nama_barang']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($barang['deskripsi']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Harga Satuan</label>
        <input type="number" name="harga_satuan" class="form-control" value="<?= $barang['harga_satuan'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" name="jumlah" class="form-control" value="<?= $barang['jumlah'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Foto (biarkan kosong jika tidak ganti)</label><br>
        <?php if ($barang['foto']): ?>
            <img src="uploads/<?= $barang['foto'] ?>" width="100" class="mb-2"><br>
        <?php endif; ?>
        <input type="file" name="foto" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

</body>
</html>
