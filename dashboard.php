<?php
session_start();
include 'headerdev.php';

// Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<body>

<div class="fullpage-background">
    <div class="content-overlay">
        
        <!-- Dashboard Header -->
        <section class="dashboard-header mb-5">
            <div class="container">
                <!-- PERBAIKAN: Menambah class 'text-center' untuk HP -->
                <div class="row align-items-center">
                    <div class="col-md-8 text-center text-md-start">
                        <h1 class="display-4">🏠 Dashboard Admin</h1>
                        <p class="lead">Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                        Sebagai, <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
                    </div>
                    <div class="col-md-4 text-center text-md-end">
                        <a href="logout.php" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="container mb-5">
            <div class="row">
                <!-- PERBAIKAN: Mengubah col-md-3 menjadi col-6 (HP) dan col-lg-3 (Desktop) -->
                <!-- Ini akan jadi 2x2 di HP/Tablet dan 4x1 di Desktop -->
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">👨‍🎓</div>
                        <div class="stat-number" id="total-santri">0</div>
                        <h5>Total Santri</h5>
                        <p class="text-muted small">Seluruh santri aktif</p>
                    </div>
                </div>
                
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">👨‍🏫</div>
                        <div class="stat-number" id="total-guru">0</div>
                        <h5>Total Guru</h5>
                        <p class="text-muted small">Pengajar aktif</p>
                    </div>
                </div>
                
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">📚</div>
                        <div class="stat-number" id="total-kelas">0</div>
                        <h5>Kelas Aktif</h5>
                        <p class="text-muted small">Kelas pembelajaran</p>
                    </div>
                </div>
                
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-number" id="tahun-aktif">2024</div>
                        <h5>Tahun Ajaran</h5>
                        <p class="text-muted small">Tahun aktif</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions & Recent Activity -->
        <section class="section">
        <div class="container-fluid px-4"> 
            <div class="row justify-content-center"> 
                <div class="col-lg-8 mb-4"> <!-- Tetap col-lg-8 agar tidak terlalu lebar -->
                    <h4 class="mb-4" style="color: var(--heading-color, #333);">Aksi Cepat</h4>
                    <div class="row">
                        <!-- Baris 1 Aksi Cepat -->
                        <div class="col-6 col-md-3 mb-4">
                            <a href="data-santri.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">👨‍🎓</div>
                                <h6>Data Santri</h6>
                                <small class="text-muted">Kelola data santri</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="gurudev.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">👨‍🏫</div>
                                <h6>Data Guru</h6>
                                <small class="text-muted">Kelola data guru</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="beritadev.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">📰</div>
                                <h6>Kelola Berita</h6>
                                <small class="text-muted">Kelola berita</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="laporan.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">📈</div>
                                <h6>Lihat Laporan</h6>
                                <small class="text-muted">Lihat laporan</small>
                            </a>
                        </div>

                        <!-- Baris 2 Aksi Cepat -->
                        <div class="col-6 col-md-3 mb-4">
                            <a href="jadwal.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">📅</div>
                                <h6>Jadwal</h6>
                                <small class="text-muted">Jadwal mengajar</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="pembayaran.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">💳</div>
                                <h6>Pembayaran</h6>
                                <small class="text-muted">Pembayaran SPP</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="pengaturan.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">⚙️</div>
                                <h6>Pengaturan</h6>
                                <small class="text-muted">System settings</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="backup.php" class="quick-action text-decoration-none d-block h-100">
                                <div class="mb-2">💾</div>
                                <h6>Backup</h6>
                                <small class="text-muted">Backup data</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>

        <!-- System Info -->
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="recent-activity" style="background: rgba(0,0,0,0.5); color: white;">
                        <h4 class="mb-4 text-white">🖥️ System Information</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Version:</strong> TPQ System 1.0
                            </div>
                            <div class="col-md-3">
                                <strong>Last Backup:</strong> <?php echo date('d M Y H:i'); ?>
                            </div>
                            <div class="col-md-3">
                                <!-- PERBAIKAN: Memberi ID untuk jam -->
                                <strong>Server Time:</strong> <span id="server-time-value"><?php echo date('H:i:s'); ?></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong> <span class="text-success">● Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade-slide" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-icon mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                </div>
                <h4>Apakah Anda yakin ingin keluar?</h4>
                <p class="text-muted">Anda akan dialihkan ke halaman login.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <!-- Tombol ini yang akan me-logout -->
                <a href="logout.php" class="btn btn-danger">Ya, Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
// Animated counter for statistics
function animateCounter(element, target, duration = 1500) {
    let start = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start);
        }
    }, 16);
}

// Real-time clock
function updateClock() {
    const now = new Date();
    // PERBAIKAN: Menggunakan ID selector yang lebih aman
    const clockElement = document.getElementById('server-time-value');
    if (clockElement) {
        clockElement.textContent = now.toLocaleTimeString('id-ID'); // Format Indonesia
    }
}

// Initialize counters and clock when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Example data - ganti dengan data dari database Anda jika perlu
    // Anda bisa mengganti angka ini dengan query PHP
    const stats = {
        santri: 215,
        guru: 12,   
        kelas: 8,
        tahun: <?php echo date('Y'); ?> // Ambil tahun saat ini
    };
    
    // Animasikan angka
    const totalSantriEl = document.getElementById('total-santri');
    const totalGuruEl = document.getElementById('total-guru');
    const totalKelasEl = document.getElementById('total-kelas');
    
    if (totalSantriEl) animateCounter(totalSantriEl, stats.santri);
    if (totalGuruEl) animateCounter(totalGuruEl, stats.guru);
    if (totalKelasEl) animateCounter(totalKelasEl, stats.kelas);
    
    // Untuk tahun, tidak perlu animasi
    const tahunAktifEl = document.getElementById('tahun-aktif');
    if (tahunAktifEl) tahunAktifEl.textContent = stats.tahun;

    // Jalankan jam
    setInterval(updateClock, 1000);
});
</script>

<?php include 'footerdev.php'; ?>