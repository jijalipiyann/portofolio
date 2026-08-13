<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Ambil Data Utama (Tabel Peminjaman / Transaksi)
$query = mysqli_query($koneksi, "SELECT * FROM peminjaman");

// Ambil Data Statistik untuk Baris Atas
$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
$total_buku = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku"));
$total_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peminjaman"));
$total_anggota = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE level != 'admin'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        *, *:before, *:after { 
            box-sizing: border-box; 
        }
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Poppins', sans-serif; 
            background: #fff6e5; /* Warna pastel awal */
            display: flex; 
        }

        /* --- SIDEBAR KIRI --- */
        .sidebar {
            width: 260px; height: 100vh; background: #fffaf5;
            box-shadow: 2px 0 15px rgba(0,0,0,0.05); position: fixed;
            display: flex; flex-direction: column; padding: 30px 20px;
        }
        .sidebar h3 { color: #e88aa3; text-align: center; margin-bottom: 40px; font-size: 20px; }
        .sidebar a {
            text-decoration: none; color: #6b5b5b; padding: 13px 20px;
            margin-bottom: 10px; border-radius: 12px; display: block;
            transition: 0.3s; font-weight: 600;
        }
        .sidebar a.active, .sidebar a:hover {
            background: linear-gradient(135deg, #f8a5c2, #fbc687);
            color: white; transform: translateX(5px);
        }
        .sidebar .logout { margin-top: auto; background: #ffe4ec; color: #e88aa3; text-align: center; }

        /* --- MAIN CONTENT AREA --- */
        .main-content {
            margin-left: 260px; padding: 40px; width: calc(100% - 260px);
            display: flex; flex-direction: column; gap: 25px;
        }

        .header h1 { color: #6b5b5b; margin: 0; font-size: 24px; }
        .header p { color: #a39292; margin: 5px 0 0 0; font-size: 13px; }

        /* --- STATS ATAS (4 KOLOM KECIL & SIMPEL) --- */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;
        }
        .mini-card {
            background: #fffaf5; padding: 15px; border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #f8a5c2;
        }
        .mini-card h3 { margin: 0; color: #a39292; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .mini-card p { margin: 2px 0 0 0; font-size: 16px; font-weight: 600; color: #6b5b5b; }

        /* --- TABLE AREA (LEBAR PENUH) --- */
        .table-container {
            background: #fffaf5; padding: 25px; border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04); overflow-x: auto;
        }
        .table-container h2 { color: #e88aa3; margin: 0 0 15px 0; font-size: 17px; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #ffe4ec; color: #e88aa3; padding: 12px; font-size: 13px; border-bottom: 2px solid #f3d6c6; }
        td { padding: 12px; border-bottom: 1px solid #f3d6c6; color: #6b5b5b; font-size: 13px; }
        tr:hover { background-color: #fffdfa; }

        .badge {
            background: #ffe4ec; color: #e88aa3; padding: 4px 10px; 
            border-radius: 10px; font-size: 11px; font-weight: 600; display: inline-block;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>JijaaLibrary</h3>
        <a href="homepage_admin.php">Dashboard</a>
        <a href="databuku.php">Kelola Data Buku</a>
        <a href="transaksi.php" class="active">Transaksi</a>
        <a href="dataanggota.php">Kelola Anggota</a>
        <a href="logout.php" class="logout">Logout </a>
    </div>

    <div class="main-content">
        
        <div class="header">
            <h1>Data Transaksi</h1>
            <p>Daftar riwayat peminjaman dan pengembalian buku perpustakaan.</p>
        </div>

        <div class="stats-row">
            <div class="mini-card" style="border-left-color: #bda7ff;">
                <h3>Anggota Aktif</h3>
                <p><?php echo $total_anggota; ?> Orang</p>
            </div>
            <div class="mini-card">
                <h3>Total Pengelola</h3>
                <p><?php echo $total_user; ?> Akun</p>
            </div>
            <div class="mini-card" style="border-left-color: #fbc687;">
                <h3>Koleksi Buku</h3>
                <p><?php echo $total_buku; ?> Buku</p>
            </div>
            <div class="mini-card" style="border-left-color: #e88aa3;">
                <h3>Total Transaksi</h3>
                <p><?php echo $total_transaksi; ?> Riwayat</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Riwayat Peminjaman Buku</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>User ID</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['id_peminjaman'] ?? $data['peminjamanid'] ?? $data['PeminjamanID'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data['userid'] ?? $data['UserID'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data['tanggal_peminjaman'] ?? $data['tanggalpeminjaman'] ?? $data['TanggalPeminjaman'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($data['tanggal_pengembalian'] ?? $data['tanggalpengembalian'] ?? $data['TanggalPengembalian'] ?? ''); ?></td>
                            <td><span class="badge"><?php echo htmlspecialchars($data['status_peminjaman'] ?? $data['statuspeminjaman'] ?? $data['StatusPeminjaman'] ?? ''); ?></span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>