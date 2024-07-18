<?php
// Mulai sesi untuk mengelola data sesi pengguna
session_start();

// Sertakan file konfigurasi database untuk membuat koneksi
require('db/config.database.php');

// Periksa apakah pengguna sudah login dengan memeriksa sesi 'user'
if(isset($_SESSION['user'])){
    // Ambil email dari sesi
    $email = $_SESSION['user'];

    // Periksa apakah email kosong
    if(empty($email)){
        // Jika email kosong, redirect ke halaman login
        header('Location: login.html');
    } else {
        // Jika email tidak kosong, redirect ke halaman index
        header('Location: page/index.php');
    }
} else {
    // Jika sesi 'user' tidak ada, redirect ke halaman login
    header('Location: login.html');
}
?>
