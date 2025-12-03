<?php
session_start();
include 'headerdev.php';

// Cek Login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login dulu'); window.location='login.html';</script>";
    exit;
}

// Pastikan koneksi database tersedia
if (!isset($koneksi)) {
    include 'koneksi.php';
}

$id_user_aktif = $_SESSION['id_user'];
$current_username = $_SESSION['username'];
$pesan_status = '';

// ============================================================
// --- 1. LOGIKA UPDATE PENGATURAN UMUM (DATA TPQ) ---
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
        // Simpan ke tabel_pengaturan (Pastikan tabel ini ada)
        // Gunakan INSERT ... ON DUPLICATE KEY UPDATE
        $query_update = "INSERT INTO tabel_pengaturan (setting_key, setting_value) VALUES ('$key', '$value') 
                         ON DUPLICATE KEY UPDATE setting_value = '$value'";
        if (!mysqli_query($koneksi, $query_update)) $berhasil = false;
    }

    if ($berhasil) {
        $pesan_status = '<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"><i class="bi bi-check-circle me-2"></i> Pengaturan umum berhasil diperbarui.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        $pesan_status = '<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm"><i class="bi bi-exclamation-circle me-2"></i> Gagal menyimpan pengaturan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// ============================================================
// --- 2. LOGIKA GANTI USERNAME ---
// ============================================================
if (isset($_POST['ganti_username'])) {
    $new_username = mysqli_real_escape_string($koneksi, $_POST['new_username']);

    // Cek apakah username sudah dipakai orang lain
    $query_check = "SELECT id_user FROM pengguna WHERE username = '$new_username' AND id_user != '$id_user_aktif'";
    $result_check = mysqli_query($koneksi, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        $pesan_status = '<div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm">Username sudah digunakan orang lain.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        $query_update = "UPDATE pengguna SET username = '$new_username' WHERE id_user = '$id_user_aktif'";
        if (mysqli_query($koneksi, $query_update)) {
            $_SESSION['username'] = $new_username;
            $current_username = $new_username;
            $pesan_status = '<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"><i class="bi bi-check-circle me-2"></i> Username berhasil diganti.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        } else {
            $pesan_status = '<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">Gagal mengganti username.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }
}

// ============================================================
// --- 3. LOGIKA GANTI PASSWORD (STANDAR AMAN) ---
// ============================================================
if (isset($_POST['ganti_password'])) {
    $old_password_input = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $pesan_status = '<div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm">Password baru dan konfirmasi tidak cocok.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        // Ambil password saat ini dari DB
        $query_get = "SELECT pass FROM pengguna WHERE id_user = '$id_user_aktif'";
        $result_get = mysqli_query($koneksi, $query_get);

        if ($result_get && mysqli_num_rows($result_get) > 0) {
            $data_user = mysqli_fetch_assoc($result_get);
            $password_di_db = $data_user['pass'];

            $password_cocok = false;

            // 1. Cek dengan password_verify (Untuk password yang sudah di-hash/enkripsi aman)
            if (password_verify($old_password_input, $password_di_db)) {
                $password_cocok = true;
            } 
            // 2. Fallback: Cek Plain Text (Jika password di DB masih mentah/belum dienkripsi)
            elseif ($old_password_input === $password_di_db) {
                $password_cocok = true;
            }

            if ($password_cocok) {
                // ENKRIPSI PASSWORD BARU (Hashing)
                $password_baru_hash = password_hash($new_password, PASSWORD_DEFAULT);

                // Update ke Database
                $query_update = "UPDATE pengguna SET pass = '$password_baru_hash' WHERE id_user = '$id_user_aktif'";

                if (mysqli_query($koneksi, $query_update)) {
                    $pesan_status = '<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"><i class="bi bi-check-circle me-2"></i> Password berhasil diperbarui!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                } else {
                    $pesan_status = '<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">Gagal update database.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
            } else {
                $pesan_status = '<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">Password lama salah!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            }
        } else {
            $pesan_status = '<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">User tidak ditemukan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }
}

// --- Ambil Pengaturan Umum untuk ditampilkan di Form ---
$pengaturan = [];
// Cek dulu apakah tabel_pengaturan ada, jika tidak, abaikan error
$cek_tabel = mysqli_query($koneksi, "SHOW TABLES LIKE 'tabel_pengaturan'");
if (mysqli_num_rows($cek_tabel) > 0) {
    $query_select = "SELECT * FROM tabel_pengaturan";
    $result_select = mysqli_query($koneksi, $query_select);
    while ($row = mysqli_fetch_assoc($result_select)) {
        $pengaturan[$row['setting_key']] = $row['setting_value'];
    }
}
?>

<main class="main">
    <section class="section">
        <div class="container mt-4 mb-5">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">Pengaturan</h2>
                    <p class="text-muted mb-0">Kelola Data Instansi & Keamanan Akun</p>
                </div>
            </div>

            <?php echo $pesan_status; ?>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-building"></i> Data Umum TPQ</h5>
                            <p class="text-muted small mb-4">Informasi ini akan ditampilkan pada kop surat dan laporan.</p>
                            
                            <form action="pengaturan.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama TPQ</label>
                                        <input type="text" class="form-control" name="nama_tpq" value="<?php echo htmlspecialchars($pengaturan['nama_tpq'] ?? ''); ?>" placeholder="Contoh: TPQ Roudlotul Ilmi">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Telepon / WA</label>
                                        <input type="text" class="form-control" name="telepon_tpq" value="<?php echo htmlspecialchars($pengaturan['telepon_tpq'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat_tpq" rows="2"><?php echo htmlspecialchars($pengaturan['alamat_tpq'] ?? ''); ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" class="form-control" name="email_tpq" value="<?php echo htmlspecialchars($pengaturan['email_tpq'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kepala TPQ</label>
                                        <input type="text" class="form-control" name="kepala_tpq" value="<?php echo htmlspecialchars($pengaturan['kepala_tpq'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">NIP Kepala (Opsional)</label>
                                    <input type="text" class="form-control" name="nip_kepala_tpq" value="<?php echo htmlspecialchars($pengaturan['nip_kepala_tpq'] ?? ''); ?>">
                                </div>
                                <div class="text-end">
                                    <button type="submit" name="simpan_umum" class="btn btn-primary px-4">Simpan Data Umum</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-warning"><i class="bi bi-person-circle"></i> Akun Pengguna</h5>
                            <p class="text-muted small">Login saat ini: <strong><?php echo htmlspecialchars($current_username); ?></strong></p>
                            
                            <form action="pengaturan.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Username Baru</label>
                                    <input type="text" class="form-control" name="new_username" required>
                                </div>
                                <button type="submit" name="ganti_username" class="btn btn-warning text-white w-100 mb-3">Ganti Username</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-shield-lock"></i> Keamanan</h5>
                            <form action="pengaturan.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Password Lama</label>
                                    <input type="password" class="form-control" name="old_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Password Baru</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" name="ganti_password" class="btn btn-danger w-100">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include 'footerdev.php';
?>