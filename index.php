<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <h2 class="mb-4">Daftar Barang</h2>
  <a href="create.php" class="btn btn-primary mb-3">Tambah Barang</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th>Deskripsi</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
        <th>Foto</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM barang");
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= htmlspecialchars($row['kode']) ?></td>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
        <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td>
          <?php if ($row['foto']): ?>
            <img src="uploads/<?= $row['foto'] ?>" width="80">
          <?php else: ?>
            Tidak ada foto
          <?php endif; ?>
        </td>
        <td>
          <a href="edit.php?kode=<?= $row['kode'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete.php?kode=<?= $row['kode'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
