<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

if (isset($_POST['daftar'])) {
    $userid   = $_POST['userid'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi Bcrypt
    $email    = $_POST['email'];
    $nama     = $_POST['namalengkap']; 
    $alamat   = $_POST['alamat'];
    $level    = 'admin'; 

    // Prepared Statement mencegah SQL Injection
    $stmt = mysqli_prepare($koneksi, "INSERT INTO user (userid, username, password, email, namalengkap, alamat, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssss", $userid, $username, $password, $email, $nama, $alamat, $level);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Pendaftaran Berhasil!'); location.href='index.php';</script>";
        } else {
            echo "Error saat mengeksekusi data: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error persiapan query: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.php");
    exit();
}
?>