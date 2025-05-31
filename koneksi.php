<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "absensi_karyawan"; // pastikan sesuai nama databasenya

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
