<?php
$host = "localhost";    // server database biasanya localhost
$user = "root";         // username default XAMPP biasanya root
$password = "";         // password default kosong
$database = "crud_barang";  // nama database yang sudah kamu buat

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
