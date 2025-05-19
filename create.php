<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode         = $_POST['kode'];
  $nama_barang  = $_POST['nama_barang'];
  $deskripsi    = $_POST['deskripsi'];
  $harga_satuan = $_POST['harga_satuan'];
  $jumlah       = $_POST['jumlah'];

  // Tangani upload foto
  $foto_name = $_FILES['foto']['name'];
  $foto_tmp  = $_FILES['foto']['tmp_name'];
  $foto_path = 'uploads/' . $foto_name;

  if (move_uploaded_file($foto_tmp, $foto_path)) {
    $sql = "INSERT INTO barang (kode, nama_barang, deskripsi, harga_satuan, jumlah, foto)
            VALUES ('$kode', '$nama_barang', '$deskripsi', '$harga_satuan', '$jumlah', '$foto_name')";
    
    if ($conn->query($sql) === TRUE) {
      header("Location: index.php");
      exit;
    } else {
      echo "Gagal menyimpan data: " . $conn->error;
    }
  } else {
    echo "Gagal upload foto.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h2 class="mb-4">Tambah Barang</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Kode Barang</label>
      <input type="text" name="kode" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nama Barang</label>
      <input type="text" name="nama_barang" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label>Harga Satuan</label>
      <input type="number" name="harga_satuan" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Foto</label>
      <input type="file" name="foto" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</body>
</html>
