<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: karyawan.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$successUpdate = false;

// Ambil data karyawan yang akan diedit
$result = mysqli_query($conn, "SELECT * FROM karyawan WHERE id_karyawan = '$id'");
if (mysqli_num_rows($result) == 0) {
    // Jika data tidak ditemukan, kembali ke halaman karyawan
    header("Location: karyawan.php");
    exit;
}
$data = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $departemen = mysqli_real_escape_string($conn, $_POST['departemen']);
    $masuk = mysqli_real_escape_string($conn, $_POST['tanggal_masuk']);

    $update = mysqli_query($conn, "UPDATE karyawan SET
        nama_karyawan = '$nama',
        jabatan = '$jabatan',
        departemen = '$departemen',
        tanggal_masuk = '$masuk'
        WHERE id_karyawan = '$id'");

    if ($update) {
        $successUpdate = true;
        // Refresh data supaya form menampilkan data terbaru setelah update
        $data = [
            'nama_karyawan' => $nama,
            'jabatan' => $jabatan,
            'departemen' => $departemen,
            'tanggal_masuk' => $masuk
        ];
    } else {
        echo "Error update data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* CSS seperti yang kamu mau, misal tema hijau */
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #a8e063, #56ab2f);
            color: #333;
            padding: 30px;
        }
        h2 {
            margin-bottom: 20px;
            color: #2e7d32;
            text-align: center;
        }
        form {
            background: white;
            padding: 25px 30px;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(56, 142, 60, 0.7);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2e7d32;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #56ab2f;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="date"]:focus {
            border-color: #2e7d32;
            outline: none;
        }
        button {
            display: block;
            width: 100%;
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>

<h2>Edit Karyawan</h2>

<form method="post" action="">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($data['nama_karyawan']) ?>">

    <label for="jabatan">Jabatan:</label>
    <input type="text" id="jabatan" name="jabatan" required value="<?= htmlspecialchars($data['jabatan']) ?>">

    <label for="departemen">Departemen:</label>
    <input type="text" id="departemen" name="departemen" required value="<?= htmlspecialchars($data['departemen']) ?>">

    <label for="tanggal_masuk">Tanggal Masuk:</label>
    <input type="date" id="tanggal_masuk" name="tanggal_masuk" required value="<?= htmlspecialchars($data['tanggal_masuk']) ?>">

    <button type="submit">Simpan Perubahan</button>
</form>

<?php if ($successUpdate): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data karyawan berhasil diupdate.',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'karyawan.php';
    });
</script>
<?php endif; ?>

</body>
</html>
