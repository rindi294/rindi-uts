<?php
include "koneksi.php";

// Tangani update data absensi langsung dari form
if (isset($_POST['update'])) {
    $id         = $_POST['id'];
    $tanggal    = $_POST['tanggal'];
    $masuk      = $_POST['jam_masuk'];
    $keluar     = $_POST['jam_keluar'];
    $keterangan = $_POST['keterangan'];

    // Escape data untuk keamanan
    $id = mysqli_real_escape_string($conn, $id);
    $tanggal = mysqli_real_escape_string($conn, $tanggal);
    $masuk = mysqli_real_escape_string($conn, $masuk);
    $keluar = mysqli_real_escape_string($conn, $keluar);
    $keterangan = mysqli_real_escape_string($conn, $keterangan);

    mysqli_query($conn, "UPDATE absensi SET 
        tanggal = '$tanggal',
        jam_masuk = '$masuk',
        jam_keluar = '$keluar',
        keterangan = '$keterangan'
        WHERE id_absensi = '$id'");

    // Redirect agar halaman di-refresh tanpa POST data
    header("Location: absensi.php");
    exit;
}

// Tangani parameter pencarian
$search = '';
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT absensi.*, karyawan.nama_karyawan 
            FROM absensi 
            JOIN karyawan ON absensi.id_karyawan = karyawan.id_karyawan
            WHERE karyawan.nama_karyawan LIKE '%$search%'";
} else {
    $sql = "SELECT absensi.*, karyawan.nama_karyawan 
            FROM absensi 
            JOIN karyawan ON absensi.id_karyawan = karyawan.id_karyawan";
}

$data = mysqli_query($conn, $sql);
$edit_id = isset($_GET['edit']) ? $_GET['edit'] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Data Absensi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(to right, #a8e063, #56ab2f);
            color: #333;
        }
        header {
            background-color: #2e7d32;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #66bb6a;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #2e7d32;
            transition: background-color 0.3s ease;
        }
        nav a.button {
            background-color: #1b5e20;
        }
        nav a:hover {
            background-color: #1b5e20;
        }
        nav form.search-form {
            display: flex;
            align-items: center;
        }
        nav form.search-form input[type="text"] {
            padding: 7px 10px;
            border: none;
            border-radius: 5px 0 0 5px;
            font-size: 14px;
            width: 220px;
        }
        nav form.search-form button {
            padding: 7px 12px;
            border: none;
            background-color: #2e7d32;
            color: white;
            font-weight: bold;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        nav form.search-form button:hover {
            background-color: #1b5e20;
        }
        .container {
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(13, 197, 105, 0.1);
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #388e3c;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-buttons a {
            padding: 6px 12px;
            margin-right: 5px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            color: white;
        }
        .action-buttons .edit {
            background-color: #4CAF50;
        }
        .action-buttons .edit:hover {
            background-color: #3e8e41;
        }
        .action-buttons .hapus {
            background-color: #e74c3c;
        }
        .action-buttons .hapus:hover {
            background-color: #c0392b;
        }
        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #3e8e41;
        }
        a.cancel {
            padding: 6px 12px;
            background-color: #999;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        a.cancel:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <header><h1>Data Absensi</h1></header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="karyawan.php">Data Karyawan</a>
        <a href="absensi.php">Data Absensi</a>
        <a href="tambah.php" class="button">+ Tambah Absensi</a>

        <form method="get" action="absensi.php" class="search-form">
            <input type="text" name="search" placeholder="Cari nama karyawan..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cari</button>
        </form>
    </nav>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        if ($edit_id == $row['id_absensi']) {
                            // Form edit inline
                            echo "<form method='post' action='absensi.php'>
                                <tr>
                                    <td>$no</td>
                                    <td>".htmlspecialchars($row['nama_karyawan'])."</td>
                                    <td><input type='date' name='tanggal' value='{$row['tanggal']}' required></td>
                                    <td><input type='time' name='jam_masuk' value='{$row['jam_masuk']}' required></td>
                                    <td><input type='time' name='jam_keluar' value='{$row['jam_keluar']}' required></td>
                                    <td><input type='text' name='keterangan' value='".htmlspecialchars($row['keterangan'])."'></td>
                                    <td>
                                        <input type='hidden' name='id' value='{$row['id_absensi']}'>
                                        <button type='submit' name='update'>Simpan</button>
                                        <a href='absensi.php' class='cancel'>Batal</a>
                                    </td>
                                </tr>
                            </form>";
                        } else {
                            // Tabel biasa
                            echo "<tr>
                                <td>{$no}</td>
                                <td>".htmlspecialchars($row['nama_karyawan'])."</td>
                                <td>".htmlspecialchars($row['tanggal'])."</td>
                                <td>".htmlspecialchars($row['jam_masuk'])."</td>
                                <td>".htmlspecialchars($row['jam_keluar'])."</td>
                                <td>".htmlspecialchars($row['keterangan'])."</td>
                                <td class='action-buttons'>
                                    <a href='absensi.php?edit={$row['id_absensi']}' class='edit'>Edit</a>
                                    <a href='hapus.php?id={$row['id_absensi']}' class='hapus' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                </td>
                            </tr>";
                        }
                        $no++;
                    }
                } else {
                    echo '<tr><td colspan="7" style="text-align:center;">Data tidak ditemukan</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
