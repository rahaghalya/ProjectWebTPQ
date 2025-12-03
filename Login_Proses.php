<?php
session_start();
header('Content-Type: application/json');

// Matikan error reporting di produksi agar tidak bocor ke user
error_reporting(0); 
ini_set('display_errors', 0);

include 'koneksi.php';

$response = [];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username dan password wajib diisi.']);
    exit;
}

// Gunakan Prepared Statement untuk mencegah SQL Injection
$stmt = $koneksi->prepare("SELECT id_user, username, pass, role FROM pengguna WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // --- BAGIAN KUNCI KEAMANAN ---
    // Gunakan password_verify() untuk mencocokkan inputan dengan hash di database
    if (password_verify($password, $user['pass'])) {
        
        // Login Sukses: Set Session
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true; // Penanda login

        // Jika Anda punya fitur "Remember Me" (opsional)
        // if (isset($_POST['remember'])) { ... logika cookie ... }

        $response = ['status' => 'success', 'message' => 'Login berhasil!'];
    } else {
        // Password Salah
        $response = ['status' => 'error', 'message' => 'Username atau password salah.'];
    }
} else {
    // Username Tidak Ditemukan
    $response = ['status' => 'error', 'message' => 'Username atau password salah.'];
}

$stmt->close();
$koneksi->close();

echo json_encode($response);
?>