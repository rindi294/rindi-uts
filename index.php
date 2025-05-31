<?php include "koneksi.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan</title>
    <style>
        /* Reset dan dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f0f0f0, #d9d9d9);
            color: #333;
        }

        header {
            background-color: #444;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #666;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a.button {
            background-color: #444;
            padding: 8px 15px;
            border-radius: 5px;
        }

        nav a.button:hover {
            background-color: #222;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 30px;
        }

        .search-box {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-box input[type="text"] {
            width: 300px;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-box input[type="text"]:focus {
            border-color: #666;
            outline: none;
        }

        .search-box button {
            padding: 9px 16px;
            border: none;
            background-color: #444;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-box button:hover {
            background-color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #666;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
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
</nav>

<div class="container">

    <!-- Form Search -->
    <form method="get" action="" class="search-box">
        <input type="text" name="search" placeholder="Cari nama karyawan..."
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (isset($_GET['search']) && $_GET['search'] != '') {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $sql = "SELECT * FROM karyawan WHERE nama_karyawan LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM karyawan";
            }

            $result = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($d['nama_karyawan']); ?></td>
                    <td><?= htmlspecialchars($d['jabatan']); ?></td>
                    <td><?= htmlspecialchars($d['departemen']); ?></td>
                    <td><?= htmlspecialchars($d['tanggal_masuk']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
