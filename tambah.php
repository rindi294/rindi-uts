<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $masuk = $_POST['jam_masuk'];
    $keluar = $_POST['jam_keluar'];
    $ket = $_POST['keterangan'];

    $insert = mysqli_query($conn, "INSERT INTO absensi(id_karyawan, tanggal, jam_masuk, jam_keluar, keterangan)
                         VALUES('$id_karyawan', '$tanggal', '$masuk', '$keluar', '$ket')");

    if ($insert) {
        // Output script SweetAlert sukses dan redirect
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data absensi berhasil ditambahkan.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'absensi.php';
            });
        });
        </script>";
    } else {
        // Jika gagal insert, beri alert error dan tetap di halaman tambah
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Data absensi gagal disimpan. Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
        });
        </script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Absensi</title>
    <style>
        /* ... (style yang sama seperti kode kamu) ... */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #a8e063, #56ab2f); /* gradasi hijau */
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #2e7d32; /* hijau gelap */
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #388e3c; /* hijau sedang */
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 12px;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        nav a:hover {
            background-color: #1b5e20; /* hijau lebih gelap */
        }

        .container {
            background: white;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(56, 142, 60, 0.7); /* shadow hijau */
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #2e7d32; /* hijau gelap */
        }

        form label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #56ab2f; /* hijau sedang */
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        form input:focus, form select:focus {
            border-color: #2e7d32; /* hijau gelap */
            outline: none;
        }

        form button {
            margin-top: 20px;
            width: 100%;
            background-color: #2e7d32; /* hijau gelap */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>

    <header>
        <h1>Tambah Data Absensi</h1>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="karyawan.php">Data Karyawan</a>
        <a href="absensi.php">Data Absensi</a>
    </nav>

    <div class="container">
        <h2>Form Absensi Karyawan</h2>
        <form method="post">
            <label for="id_karyawan">Karyawan:</label>
            <select name="id_karyawan" required>
                <option value="" disabled selected>Pilih Karyawan</option>
                <?php
                $karyawan = mysqli_query($conn, "SELECT * FROM karyawan");
                while ($k = mysqli_fetch_array($karyawan)) {
                    echo "<option value='{$k['id_karyawan']}'>{$k['nama_karyawan']}</option>";
                }
                ?>
            </select>

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>

            <label for="jam_masuk">Jam Masuk:</label>
            <input type="time" name="jam_masuk" required>

            <label for="jam_keluar">Jam Keluar:</label>
            <input type="time" name="jam_keluar" required>

            <label for="keterangan">Keterangan:</label>
            <select name="keterangan" required>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpa">Alpa</option>
            </select>

            <button type="submit">Simpan</button>
        </form>
    </div>

</body>
</html>
