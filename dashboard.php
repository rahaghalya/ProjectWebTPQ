<?php
// dashboard.php
session_start();
include 'headerdev.php';

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<main class="main">
    
    <!-- Section untuk memberi padding -->
    <section class="section">
        <div class="container">
            <!-- 1. Tambahkan 'justify-content-center' untuk menengahkan kolom -->
            <div class="row justify-content-center">
                <!-- 2. Ubah col-lg-12 menjadi col-lg-8 dan tambahkan 'text-center' -->
                <div class="col-lg-8 text-center">

                    <!-- BARIS DIV YANG ERROR DI BAWAH INI SUDAH DIHAPUS -->
                    <div style="background-image: url('...');">

                        <!-- Ini adalah konten yang Anda berikan -->
                        <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                    
                        <p>Anda login sebagai: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>

                        <!-- (Opsional) Tampilkan User ID jika ada -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <p>User ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                        <?php endif; ?>
                        
                        <br>
                        
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                        <!-- / Akhir konten Anda -->
                    
                    <!-- </div> -->
                    <!-- PENUTUP DIV YANG ERROR JUGA SUDAH DIHAPUS -->


                </div>
            </div>
        </div>
    </section>

</main>