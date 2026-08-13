<?php
// Memulai session untuk menyimpan status login user
session_start();

// Menampilkan error jika ada (untuk mempermudah debugging saat development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menghubungkan ke file koneksi database
include 'koneksi.php';

// Memastikan bahwa data dikirimkan melalui tombol submit 'login' dari form
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menggunakan Prepared Statement untuk mencari username di database demi keamanan
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username = ?");
    
    if ($stmt) {
        // "s" berarti tipe data parameter yang dikirim adalah string (username)
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        
        // Mengambil hasil query
        $result = mysqli_stmt_get_result($stmt);
        
        // Memeriksa apakah username tersebut ditemukan di database
        if ($user = mysqli_fetch_assoc($result)) {
            
            // Memverifikasi apakah password teks biasa cocok dengan password hash Bcrypt di database
            if (password_verify($password, $user['password'])) {
                
                // Menyimpan data user ke dalam session untuk proteksi halaman homepage nanti
                $_SESSION['userid']   = $user['userid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['level']    = $user['level'];
                
                // Pengecekan Level Hak Akses untuk Menentukan Halaman Tujuan (Redirect)
                if ($user['level'] == 'admin') {
                    // Jika levelnya admin, arahkan ke homepage_admin.php
                    echo "<script>
                            alert('Login Berhasil! Selamat datang Admin " . $user['namalengkap'] . " '); 
                            location.href='homepage_admin.php';
                          </script>";
                } else if ($user['level'] == 'peminjam') {
                    // Jika levelnya peminjam, arahkan ke homepage_peminjam.php
                    echo "<script>
                            alert('Login Berhasil! Selamat datang Member " . $user['namalengkap'] . " '); 
                            location.href='homepage_peminjam.php';
                          </script>";
                } else {
                    // Antisipasi jika ada level lain di luar admin dan peminjam
                    echo "<script>
                            alert('Login Berhasil, tetapi level akses tidak dikenali.'); 
                            location.href='index.php';
                          </script>";
                }
                
            } else {
                // Jika password salah / tidak cocok dengan hash
                echo "<script>
                        alert('Password salah!'); 
                        location.href='index.php';
                      </script>";
            }
        } else {
            // Jika username tidak ditemukan di kolom database
            echo "<script>
                    alert('Username tidak terdaftar!'); 
                    location.href='index.php';
                  </script>";
        }
        
        // Menutup statement database setelah selesai digunakan
        mysqli_stmt_close($stmt);
    } else {
        echo "Error persiapan query: " . mysqli_error($koneksi);
    }
} else {
    // Jika file ini diakses langsung secara paksa lewat URL tanpa input form, tendang ke index.php
    header("Location: index.php");
    exit();
}
?>