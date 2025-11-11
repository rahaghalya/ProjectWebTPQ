<?php
// login_process.php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header untuk JSON
header('Content-Type: application/json');

// Buat array untuk respon
$response = [];

// Ambil data dari POST request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Log received data untuk debugging
error_log("Login attempt - Username: $username");

// Validasi dasar
if (empty($username) || empty($password)) {
    $response = ['status' => 'error', 'message' => 'Username dan password tidak boleh kosong.'];
    echo json_encode($response);
    exit;
}

try {
    // Sertakan file koneksi database Anda
    include 'koneksi.php'; // Pastikan path ini benar
    
    // Check if connection is successful
    if (!$koneksi || $koneksi->connect_error) {
        throw new Exception('Database connection failed: ' . ($koneksi->connect_error ?? 'Unknown error'));
    }
    
    // Siapkan statement SQL
    $sql = "SELECT * FROM pengguna WHERE username = ?";
    $stmt = $koneksi->prepare($sql);

    if ($stmt === false) {
        throw new Exception('Gagal mempersiapkan statement: ' . $koneksi->error);
    }

    // Bind parameter dan execute
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Debug log
        error_log("User found: " . $user['username']);
        error_log("Password hash in DB: " . $user['pass']);
        error_log("Input password: $password");

        // Verifikasi password
        if ($password === $user['pass']) {
            // Password cocok
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            $response = ['status' => 'success', 'message' => 'Login berhasil!'];
            error_log("Login successful for user: $username");
        } else {
            // Password salah
            $response = ['status' => 'error', 'message' => 'Username atau password salah.'];
            error_log("Password verification failed for user: $username");
        }
    } else {
        // User tidak ditemukan
        $response = ['status' => 'error', 'message' => 'Username atau password salah.'];
        error_log("User not found: $username");
    }

    $stmt->close();

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $response = ['status' => 'error', 'message' => 'Terjadi kesalahan server: ' . $e->getMessage()];
}

// Kirim respon JSON
echo json_encode($response);

// Tutup koneksi
if (isset($koneksi)) {
    $koneksi->close();
}
?>
