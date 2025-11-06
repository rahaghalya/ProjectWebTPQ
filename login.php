<?php
session_start();
include 'koneksi.php'; // Pastikan file ini ada dan konfigurasinya benar

// Atur header respons sebagai JSON
header('Content-Type: application/json');

// Siapkan array untuk respons
$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan yang tidak diketahui.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah 'user' dan 'pass' dikirim
    if (!isset($_POST['user']) || !isset($_POST['pass'])) {
        $response['message'] = 'Username dan Password tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    $username = mysqli_real_escape_string($koneksi, $_POST['user']);
    $password = mysqli_real_escape_string($koneksi, $_POST['pass']);

    // --- PERUBAHAN 1 ---
    // Nama tabel diubah dari 'tabel_pengguna' menjadi 'pengguna'
    $query = "SELECT * FROM pengguna WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // --- PERUBAHAN 2 & 3 ---
        // 1. Diganti dari 'password_verify()' menjadi perbandingan '==='
        // 2. Diganti dari $user['password'] menjadi $user['pass']
        
        // Cek password sebagai teks biasa (karena di DB tidak di-hash)
        if ($password === $user['pass']) {
            // Sukses! Buat session
            $_SESSION['user_id'] = $user['id_user']; // Sesuaikan jika nama kolom ID beda
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Kirim respons sukses
            $response['status'] = 'success';
            $response['message'] = 'Login berhasil! Mengalihkan...';
            $response['redirect'] = 'dashboard.php'; // Beri tahu JS ke mana harus pergi
        } else {
            // Password salah
            $response['message'] = 'Password yang Anda masukkan salah!';
        }
    } else {
        // Username tidak ditemukan
        $response['message'] = 'Username tidak ditemukan!';
    }
} else {
    $response['message'] = 'Metode permintaan tidak valid.';
}

// Kembalikan respons dalam format JSON
echo json_encode($response);
exit;
?>