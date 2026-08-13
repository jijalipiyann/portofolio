<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'admin') {
    header("Location: index.php"); exit();
}
include 'koneksi.php';

// Ambil Data Statistik
$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
$total_buku = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku"));
$total_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peminjaman"));
$total_anggota = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE level != 'admin'"));

// Ambil Data Tabel Admin
$query_user = mysqli_query($koneksi, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        *, *:before, *:after { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #fff6e5; display: flex; }

        /* --- SIDEBAR --- */
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

        /* --- CONTENT --- */
        .main-content {
            margin-left: 260px; padding: 40px; width: calc(100% - 260px);
            display: flex; flex-direction: column; gap: 25px;
        }

        .header h1 { color: #6b5b5b; margin: 0; font-size: 24px; }
        .header p { color: #a39292; margin: 5px 0 0 0; font-size: 13px; }

        /* --- STATS ATAS (4 KOLOM KECIL) --- */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;
        }
        .mini-card {
            background: #fffaf5; padding: 15px; border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #f8a5c2;
        }
        .mini-card h3 { margin: 0; color: #a39292; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .mini-card p { margin: 2px 0 0 0; font-size: 16px; font-weight: 600; color: #6b5b5b; }

        /* --- TABLE AREA (FULL WIDTH) --- */
        .table-container {
            background: #fffaf5; padding: 25px; border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04); overflow-x: auto;
        }
        .table-container h2 { color: #e88aa3; margin: 0 0 15px 0; font-size: 17px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #ffe4ec; color: #e88aa3; padding: 12px; font-size: 13px; border-bottom: 2px solid #f3d6c6; }
        td { padding: 12px; border-bottom: 1px solid #f3d6c6; color: #6b5b5b; font-size: 13px; }
        .badge { background: #ffe4ec; color: #e88aa3; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 600; }
    </style>
</head>
<body>

   <div class="sidebar">
        <div class="sidebar-brand">
            <h3>JijaaLibrary</h3>
        </div>
        
        <a href="homepage_admin.php" class="active">Dashboard</a>
        <a href="databuku.php">Kelola Data Buku</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="dataanggota.php">Kelola Anggota</a>
        <a href="logout.php" class="logout">Logout </a>
    </div>

    <div class="main-content">
        
        <div class="header">
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Ringkasan aktivitas perpustakaan hari ini.</p>
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
            <h2>Daftar Akun Petugas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama Lengkap</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query_user)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username'] ?? $row['Username'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['email'] ?? $row['Email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['namalengkap'] ?? $row['NamaLengkap'] ?? ''); ?></td>
                            <td><span class="badge"><?php echo htmlspecialchars($row['level'] ?? $row['Level'] ?? ''); ?></span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>