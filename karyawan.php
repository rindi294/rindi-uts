<?php
include "koneksi.php";

if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    $hapus = mysqli_query($conn, "DELETE FROM karyawan WHERE id_karyawan = '$id'");

    if ($hapus) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data karyawan berhasil dihapus.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'karyawan.php';
            });
        });
        </script>";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Data karyawan gagal dihapus.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'karyawan.php';
            });
        });
        </script>";
    }
    exit;
}

$search = '';
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM karyawan WHERE nama_karyawan LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM karyawan";
}

$data = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan</title>
    <style>
        /* Style sesuai permintaan */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #a8e063, #56ab2f);
            color: #333;
        }
        header {
            background-color: #2e7d32;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        nav {
            background-color: #66bb6a;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
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
            box-shadow: 0 2px 8px rgba(7, 205, 40, 0.81);
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<header>
    <h1>Data Karyawan</h1>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="karyawan.php">Data Karyawan</a>
    <a href="absensi.php">Data Absensi</a>
    <a href="tambah.php" class="button">+ Tambah Karyawan</a>

    <form method="get" action="karyawan.php" class="search-form">
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
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($data) > 0) {
                while ($d = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($d['nama_karyawan']) ?></td>
                <td><?= htmlspecialchars($d['jabatan']) ?></td>
                <td><?= htmlspecialchars($d['departemen']) ?></td>
                <td><?= htmlspecialchars($d['tanggal_masuk']) ?></td>
                <td class="action-buttons">
                    <a href="edit.php?id=<?= $d['id_karyawan'] ?>" class="edit">Edit</a>
                    <a href="#" class="hapus" data-id="<?= $d['id_karyawan'] ?>">Hapus</a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="6" style="text-align:center;">Data tidak ditemukan</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>
// SweetAlert konfirmasi hapus
document.querySelectorAll('.hapus').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `karyawan.php?hapus=${id}`;
            }
        });
    });
});
</script>

</body>
</html>
