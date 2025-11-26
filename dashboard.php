<?php
session_start();
include 'headerdev.php';

// Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// =================================================================
// LOGIKA HITUNG STATISTIK DARI DATABASE
// =================================================================

// 1. Hitung Total Santri (Hanya yang Aktif)
$q_santri = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM santri WHERE Keterangan = 'Aktif'");
$d_santri = mysqli_fetch_assoc($q_santri);
$jumlah_santri = $d_santri['total'];

// 2. Hitung Total Guru (Hanya yang Aktif)
$q_guru = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM guru WHERE keterangan = 'Aktif'");
$d_guru = mysqli_fetch_assoc($q_guru);
$jumlah_guru = $d_guru['total'];

// 3. Hitung Total Kelas (Menghitung variasi 'jilid' yang ada di data santri)
$q_kelas = mysqli_query($koneksi, "SELECT COUNT(DISTINCT jilid) as total FROM santri");
$d_kelas = mysqli_fetch_assoc($q_kelas);
$jumlah_kelas = $d_kelas['total'];

// =================================================================
?>

<body>

    <div class="fullpage-background">
        <div class="content-overlay">

            <section class="dashboard-header mb-5">
                <div class="container">
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

            <section class="container mb-5">
                <div class="row">
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
                            <div class="stat-number" id="tahun-aktif"><?php echo date('Y'); ?></div>
                            <h5>Tahun Ajaran</h5>
                            <p class="text-muted small">Tahun aktif</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="container-fluid px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 mb-4">
                            <h4 class="mb-4" style="color: var(--heading-color, #333);">Aksi Cepat</h4>
                            <div class="row">
                                <div class="col-6 col-md-3 mb-4">
                                    <a href="data_santri.php" class="quick-action text-decoration-none d-block h-100">
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
                                    <a href="kelolaberitadev.php" class="quick-action text-decoration-none d-block h-100">
                                        <div class="mb-2">📰</div>
                                        <h6>Kelola Berita</h6>
                                        <small class="text-muted">Kelola berita</small>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mb-4">
                                    <a href="sejarahdev.php" class="quick-action text-decoration-none d-block h-100">
                                        <div class="mb-2">🏛️</div>
                                        <h6>Kelola Sejarah</h6>
                                        <small class="text-muted">Kelola Sejarah</small>
                                    </a>
                                </div>

                                <div class="col-6 col-md-3 mb-4">
                                    <a href="laporanguru.php" class="quick-action text-decoration-none d-block h-100">
                                        <div class="mb-2">📈</div>
                                        <h6>Lihat Laporan</h6>
                                        <small class="text-muted">Lihat laporan Guru</small>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mb-4">
                                    <a href="laporan.php" class="quick-action text-decoration-none d-block h-100">
                                        <div class="mb-2">📈</div>
                                        <h6>Lihat Laporan</h6>
                                        <small class="text-muted">Lihat Laporan Santri</small>
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
            const clockElement = document.getElementById('server-time-value');
            if (clockElement) {
                clockElement.textContent = now.toLocaleTimeString('id-ID'); // Format Indonesia
            }
        }

        // Initialize counters and clock when page loads
        document.addEventListener('DOMContentLoaded', function() {

            // --- DATA DINAMIS DARI PHP DATABASE ---
            const stats = {
                santri: <?php echo $jumlah_santri; ?>, // Total santri dari database
                guru: <?php echo $jumlah_guru; ?>, // Total guru dari database
                kelas: <?php echo $jumlah_kelas; ?>, // Total kelas dari database
                tahun: <?php echo date('Y'); ?> // Tahun saat ini
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