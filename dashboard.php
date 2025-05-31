<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Absensi Karyawan</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #a8e063, #56ab2f); /* Gradasi hijau */
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2e7d32; /* Hijau gelap */
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #66bb6a; /* Hijau sedang */
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 30px;
            text-align: center;
        }
        .card {
            display: inline-block;
            width: 250px;
            margin: 15px;
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .card h2 {
            font-size: 40px;
            color: #2e7d32;
        }
        .card p {
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Absensi Karyawan</h1>
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="karyawan.php">Data Karyawan</a>
        <a href="absensi.php">Data Absensi</a>
    </nav>

    <div class="container">
        <?php
        // Jumlah karyawan
        $jumlah_karyawan = mysqli_query($conn, "SELECT COUNT(*) as total FROM karyawan");
        $total_karyawan = mysqli_fetch_assoc($jumlah_karyawan)['total'];

        // Jumlah absensi
        $jumlah_absensi = mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi");
        $total_absensi = mysqli_fetch_assoc($jumlah_absensi)['total'];
        ?>
        
        <div class="card">
            <h2><?= $total_karyawan ?></h2>
            <p>Total Karyawan</p>
        </div>

        <div class="card">
            <h2><?= $total_absensi ?></h2>
            <p>Total Kehadiran</p>
        </div>
    </div>
</body>
</html>
