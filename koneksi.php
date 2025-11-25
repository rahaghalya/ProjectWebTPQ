<?php
/*
 * File Koneksi Database (koneksi.php)
 * Ini adalah file "kunci" untuk menghubungkan PHP ke database MySQL Anda.
 * Simpan file ini di folder utama atau folder 'admin' Anda.
 */

// 1. Definisikan detail koneksi Anda
// (Sesuaikan ini saat di-upload ke hosting asli)
$db_host = "localhost";   // Biasanya 'localhost'
$db_user = "root";        // User default XAMPP
$db_pass = "";            // Password default XAMPP (kosong)
$db_name = "db_tpq";      // Nama database yang Anda buat di phpMyAdmin
$db_port = "3307";
// 2. Buat koneksi
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// 3. Cek koneksi
if (mysqli_connect_errno()) {
    // Jika koneksi GAGAL, tampilkan pesan error dan hentikan script
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset ke utf8mb4 (disarankan)
mysqli_set_charset($koneksi, "utf8mb4");

// Jika koneksi berhasil, script akan lanjut.
// File ini bisa di-include di file PHP lain untuk memakai variabel $koneksi.
?>