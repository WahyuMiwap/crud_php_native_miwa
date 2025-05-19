<?php
include 'db.php';

if (!isset($_GET['kode'])) {
    header("Location: index.php");
    exit;
}

$kode = $_GET['kode'];

// Ambil dulu data barang untuk mengetahui nama file foto
$sql = "SELECT foto FROM barang WHERE kode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Data tidak ditemukan!";
    exit;
}

$barang = $result->fetch_assoc();

// Hapus data dari database
$sql_delete = "DELETE FROM barang WHERE kode = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("s", $kode);

if ($stmt_delete->execute()) {
    // Jika ada foto, hapus file fisiknya
    if ($barang['foto'] && file_exists('uploads/' . $barang['foto'])) {
        unlink('uploads/' . $barang['foto']);
    }

    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
