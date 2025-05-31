<?php
include "koneksi.php";

$status = "";
$pesan = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data dari tabel absensi
    $query = mysqli_query($conn, "DELETE FROM absensi WHERE id_absensi = '$id'");

    if ($query) {
        $status = "success";
        $pesan = "Data absensi berhasil dihapus.";
    } else {
        $status = "error";
        $pesan = "Gagal menghapus data absensi.";
    }
} else {
    $status = "warning";
    $pesan = "ID absensi tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Absensi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Ambil variabel dari PHP ke JavaScript
        const status = <?= json_encode($status); ?>;
        const pesan = <?= json_encode($pesan); ?>;

        Swal.fire({
            title: status === "success" ? "Berhasil!" :
                   status === "error" ? "Gagal!" :
                   "Peringatan!",
            text: pesan,
            icon: status,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'absensi.php';
        });
    </script>
</body>
</html>
