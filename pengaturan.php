<?php
session_start();
include 'headerdev.php'; 

// Cek Login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login dulu'); window.location='login.php';</script>";
    exit;
}

$id_user_aktif = $_SESSION['id_user'];
$current_username = $_SESSION['username']; 

$pesan_status = '';

// ============================================================
// --- 1. FUNGSI ENKRIPSI & DEKRIPSI ---
// ============================================================
define('KUNCI_RAHASIA', 'KunciTPQ_Roudlotul_Ilmi_2025'); 

function enkripsi($string) {
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '1234567891011121'; 
    return openssl_encrypt($string, $ciphering, KUNCI_RAHASIA, $options, $encryption_iv);
}

function dekripsi($string) {
    $ciphering = "AES-128-CTR";
    $options = 0;
    $decryption_iv = '1234567891011121'; 
    return openssl_decrypt($string, $ciphering, KUNCI_RAHASIA, $options, $decryption_iv);
}

// ============================================================
// --- 2. LOGIKA UPDATE PENGATURAN UMUM (DATA TPQ) ---
// ============================================================
if (isset($_POST['simpan_umum'])) {
    $nama_tpq = mysqli_real_escape_string($koneksi, $_POST['nama_tpq']);
    $alamat_tpq = mysqli_real_escape_string($koneksi, $_POST['alamat_tpq']);
    $telepon_tpq = mysqli_real_escape_string($koneksi, $_POST['telepon_tpq']);
    $email_tpq = mysqli_real_escape_string($koneksi, $_POST['email_tpq']);
    $kepala_tpq = mysqli_real_escape_string($koneksi, $_POST['kepala_tpq']);
    $nip_kepala_tpq = mysqli_real_escape_string($koneksi, $_POST['nip_kepala_tpq']);

    $pengaturan_list = [
        'nama_tpq' => $nama_tpq,
        'alamat_tpq' => $alamat_tpq,
        'telepon_tpq' => $telepon_tpq,
        'email_tpq' => $email_tpq,
        'kepala_tpq' => $kepala_tpq,
        'nip_kepala_tpq' => $nip_kepala_tpq
    ];

    $berhasil = true;
    foreach ($pengaturan_list as $key => $value) {
        // Simpan ke tabel_pengaturan
        $query_update = "INSERT INTO tabel_pengaturan (setting_key, setting_value) VALUES ('$key', '$value') 
                         ON DUPLICATE KEY UPDATE setting_value = '$value'";
        if (!mysqli_query($koneksi, $query_update)) $berhasil = false;
    }

    if ($berhasil) {
        $pesan_status = '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil!</strong> Pengaturan umum diperbarui.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        $pesan_status = '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal!</strong> Terjadi kesalahan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// ============================================================
// --- 3. LOGIKA GANTI USERNAME ---
// ============================================================
if (isset($_POST['ganti_username'])) {
    $new_username = mysqli_real_escape_string($koneksi, $_POST['new_username']);
    
    // Cek tabel 'pengguna', kolom 'username', id 'id_user'
    $query_check = "SELECT id_user FROM pengguna WHERE username = '$new_username' AND id_user != '$id_user_aktif'";
    $result_check = mysqli_query($koneksi, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        $pesan_status = '<div class="alert alert-warning alert-dismissible fade show">Username sudah digunakan orang lain.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        $query_update = "UPDATE pengguna SET username = '$new_username' WHERE id_user = '$id_user_aktif'";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['username'] = $new_username; 
            $current_username = $new_username;
            $pesan_status = '<div class="alert alert-success alert-dismissible fade show">Username berhasil diganti.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        } else {
            $pesan_status = '<div class="alert alert-danger alert-dismissible fade show">Gagal mengganti username.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }
}

// ============================================================
// --- 4. LOGIKA GANTI PASSWORD (KOLOM 'pass') ---
// ============================================================
if (isset($_POST['ganti_password'])) {
    $old_password_input = $_POST['old_password']; 
    $new_password = $_POST['new_password'];       
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $pesan_status = '<div class="alert alert-warning alert-dismissible fade show">Password baru dan konfirmasi tidak cocok.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        // Ambil password dari tabel 'pengguna', kolom 'pass'
        $query_get = "SELECT pass FROM pengguna WHERE id_user = '$id_user_aktif'";
        $result_get = mysqli_query($koneksi, $query_get);
        
        if ($result_get && mysqli_num_rows($result_get) > 0) {
            $data_user = mysqli_fetch_assoc($result_get);
            $password_di_db = $data_user['pass'];

            // Cek: Apakah password di DB saat ini masih POLOS (belum dienkripsi)?
            // Karena di screenshot Anda datanya terlihat seperti "raha1234" (polos)
            
            $password_cocok = false;

            // Coba dekripsi dulu (siapa tau sudah terenkripsi)
            $decrypted_db_pass = dekripsi($password_di_db);
            
            if ($old_password_input === $decrypted_db_pass) {
                // Cocok dengan metode enkripsi
                $password_cocok = true;
            } elseif ($old_password_input === $password_di_db) {
                // Cocok dengan metode teks biasa (untuk migrasi pertama kali)
                $password_cocok = true;
            }

            if ($password_cocok) {
                // Enkripsi password baru
                $password_baru_encrypted = enkripsi($new_password);

                // Update kolom 'pass'
                $query_update = "UPDATE pengguna SET pass = '$password_baru_encrypted' WHERE id_user = '$id_user_aktif'";
                
                if (mysqli_query($koneksi, $query_update)) {
                    $pesan_status = '<div class="alert alert-success alert-dismissible fade show">Password berhasil diperbarui!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                } else {
                    $pesan_status = '<div class="alert alert-danger alert-dismissible fade show">Gagal update database.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
            } else {
                $pesan_status = '<div class="alert alert-danger alert-dismissible fade show">Password lama salah!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            }
        } else {
             $pesan_status = '<div class="alert alert-danger alert-dismissible fade show">User tidak ditemukan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }
}

// --- Ambil Pengaturan Umum ---
$pengaturan = [];
$query_select = "SELECT * FROM tabel_pengaturan";
$result_select = mysqli_query($koneksi, $query_select);
while ($row = mysqli_fetch_assoc($result_select)) {
    $pengaturan[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">⚙️ Pengaturan Website</h2>

    <?php echo $pesan_status; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Pengaturan Umum (TPQ & Pimpinan)</h5>
        </div>
        <div class="card-body">
            <p>Ubah informasi dasar TPQ yang tampil di laporan.</p>
            <form action="pengaturan.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama TPQ</label>
                        <input type="text" class="form-control" name="nama_tpq" value="<?php echo htmlspecialchars($pengaturan['nama_tpq'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                         <label class="form-label">Alamat</label>
                         <textarea class="form-control" name="alamat_tpq" rows="1"><?php echo htmlspecialchars($pengaturan['alamat_tpq'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telepon_tpq" value="<?php echo htmlspecialchars($pengaturan['telepon_tpq'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email_tpq" value="<?php echo htmlspecialchars($pengaturan['email_tpq'] ?? ''); ?>">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kepala TPQ</label>
                        <input type="text" class="form-control" name="kepala_tpq" value="<?php echo htmlspecialchars($pengaturan['kepala_tpq'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIP Kepala</label>
                        <input type="text" class="form-control" name="nip_kepala_tpq" value="<?php echo htmlspecialchars($pengaturan['nip_kepala_tpq'] ?? ''); ?>">
                    </div>
                </div>
                <button type="submit" name="simpan_umum" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Simpan Data Umum</button>
            </form>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Pengaturan Akun (<?php echo htmlspecialchars($current_username); ?>)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 border-end">
                    <h5>Ganti Username</h5>
                    <form action="pengaturan.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username Baru</label>
                            <input type="text" class="form-control" name="new_username" required>
                        </div>
                        <button type="submit" name="ganti_username" class="btn btn-success btn-sm"><i class="bi bi-person"></i> Ganti Username</button>
                    </form>
                </div>

                <div class="col-md-6 ps-md-4">
                    <h5>Ganti Password</h5>
                    <form action="pengaturan.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" class="form-control" name="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <button type="submit" name="ganti_password" class="btn btn-danger btn-sm"><i class="bi bi-lock"></i> Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footerdev.php';
?>