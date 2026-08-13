<?php
session_start();

// FIX: Pastikan menggunakan $_SESSION (ada tanda dolarnya)
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'peminjam') {
    header("Location: index.php");
    exit();
}

include 'koneksi.php';

// Ambil data buku untuk di katalog (Ganti query-nya ke tabel user dulu untuk dummy awal agar tidak error)
$query_buku = mysqli_query($koneksi, "SELECT * FROM user"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Peminjam - Perpustakaan </title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff6e5;
            display: flex;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #fffaf5;
            box-shadow: 2px 0 15px rgba(0,0,0,0.05);
            position: fixed;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
        }

        .sidebar h3 {
            color: #e88aa3;
            text-align: center;
            margin-bottom: 40px;
            font-size: 20px;
        }

        .sidebar a {
            text-decoration: none;
            color: #6b5b5b;
            padding: 13px 20px;
            margin-bottom: 10px;
            border-radius: 12px;
            display: block;
            transition: 0.3s;
            font-weight: 600;
            cursor: pointer;
        }

        .sidebar a.active, .sidebar a:hover {
            background: linear-gradient(135deg, #f8a5c2, #fbc687);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .logout {
            margin-top: auto;
            background: #ffe4ec;
            color: #e88aa3;
            text-align: center;
        }

        .sidebar .logout:hover {
            background: #ffcbd9;
            color: #bc506e;
            transform: none;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            color: #6b5b5b;
            margin: 0;
            font-size: 28px;
        }

        .header p {
            color: #a39292;
            margin: 5px 0 0 0;
        }

        /* --- CARDS STATISTIK --- */
        .cards-container {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: #fffaf5;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 5px solid #f8a5c2;
        }

        .card-info h3 {
            margin: 0;
            color: #a39292;
            font-size: 13px;
            text-transform: uppercase;
        }

        .card-info p {
            margin: 5px 0 0 0;
            font-size: 24px;
            font-weight: 600;
            color: #6b5b5b;
        }

        .card-icon {
            font-size: 30px;
        }

        /* --- TAB PANEL --- */
        .tab-panel {
            display: none;
        }

        .tab-panel.active-panel {
            display: block;
        }

        .table-container {
            background: #fffaf5;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
            overflow-x: auto;
        }

        .table-container h2 {
            color: #e88aa3;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
        }

        /* --- KATALOG GRID --- */
        .buku-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .buku-item {
            background: #fffaf5;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            text-align: center;
            border: 1px solid #f3d6c6;
        }

        .buku-item .cover-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .buku-item h4 {
            margin: 10px 0 5px 0;
            color: #6b5b5b;
            font-size: 16px;
        }

        .buku-item p {
            margin: 0;
            color: #a39292;
            font-size: 13px;
        }

        .btn-pinjam {
            margin-top: 15px;
            background: linear-gradient(135deg, #f8a5c2, #fbc687);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-pinjam:hover {
            transform: scale(1.03);
        }

        /* --- TABLE STYLE --- */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #ffe4ec;
            color: #e88aa3;
            padding: 15px;
            font-size: 14px;
            border-bottom: 2px solid #f3d6c6;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f3d6c6;
            color: #6b5b5b;
            font-size: 14px;
        }

        .badge {
            background: #ffe4ec;
            color: #e88aa3;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>JijaaLibrary</h3>
        <a onclick="switchTab('dashboard', this)" class="tab-link active">Dashboard</a>
        <a onclick="switchTab('katalog', this)" class="tab-link">Katalog Buku</a>
        <a onclick="switchTab('riwayat', this)" class="tab-link">Riwayat Pinjam</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="main-content">
        
        <div class="header">
            <h1>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>! ✨</h1>
            <p>Mau baca buku apa hari ini? Cari dan lihat status peminjamanmu di sini.</p>
        </div>

        <div id="panel-dashboard" class="tab-panel active-panel">
            <div class="cards-container">
                <div class="card">
                    <div class="card-info">
                        <h3>Sedang Dipinjam</h3>
                        <p>1 Buku</p> </div>
                    <div class="card-icon">📖</div>
                </div>
                <div class="card" style="border-left-color: #fbc687;">
                    <div class="card-info">
                        <h3>Belum Dikembalikan</h3>
                        <p>0 Buku</p> </div>
                    <div class="card-icon">⚠️</div>
                </div>
                <div class="card" style="border-left-color: #a8e6cf;">
                    <div class="card-info">
                        <h3>Total Pernah Pinjam</h3>
                        <p>4 Buku</p> </div>
                    <div class="card-icon">✅</div>
                </div>
            </div>

            <div class="table-container">
                <h2>Buku yang Sedang Kamu Pinjam</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Pinjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TRX-901</td>
                            <td>Laskar Pelangi</td>
                            <td>12-05-2026</td>
                            <td>19-05-2026</td>
                            <td><span class="badge" style="background:#fff3cd; color:#856404;">Dipinjam</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="panel-katalog" class="tab-panel">
            <div class="table-container">
                <h2>Katalog Buku Tersedia</h2>
                <div class="buku-grid">
                    <div class="buku-item">
                        <div class="cover-icon">📘</div>
                        <h4>Laskar Pelangi</h4>
                        <p>Penulis: Andrea Hirata</p>
                        <p style="font-size:11px; color:#e88aa3;">Stok: 5 Tersedia</p>
                        <button class="btn-pinjam">Ajukan Pinjam</button>
                    </div>
                    <div class="buku-item">
                        <div class="cover-icon">📙</div>
                        <h4>Bumi Manusia</h4>
                        <p>Penulis: Pramoedya A. Toer</p>
                        <p style="font-size:11px; color:#e88aa3;">Stok: 2 Tersedia</p>
                        <button class="btn-pinjam">Ajukan Pinjam</button>
                    </div>
                    <div class="buku-item">
                        <div class="cover-icon">📗</div>
                        <h4>PHP untuk Pemula</h4>
                        <p>Penulis: Rizky Perkasa</p>
                        <p style="font-size:11px; color:#e88aa3;">Stok: Tapis Habis</p>
                        <button class="btn-pinjam" style="background:#ddd; color:#888; cursor:not-allowed;" disabled>Habis</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="panel-riwayat" class="tab-panel">
            <div class="table-container">
                <h2>Riwayat Semua Peminjaman Kamu</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Pinjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Dikembalikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TRX-702</td>
                            <td>Filosofi Teras</td>
                            <td>10-04-2026</td>
                            <td>17-04-2026</td>
                            <td><span class="badge" style="background:#d4edda; color:#155724;">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>TRX-641</td>
                            <td>Pulang - Tere Liye</td>
                            <td>01-03-2026</td>
                            <td>08-03-2026</td>
                            <td><span class="badge" style="background:#d4edda; color:#155724;">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function switchTab(tabName, element) {
            const panels = document.querySelectorAll('.tab-panel');
            panels.forEach(panel => panel.classList.remove('active-panel'));

            const links = document.querySelectorAll('.tab-link');
            links.forEach(link => link.classList.remove('active'));

            document.getElementById('panel-' + tabName).classList.add('active-panel');
            element.classList.add('active');
        }
    </script>

</body>
</html>