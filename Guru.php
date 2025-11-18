<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';
// 2. Query untuk mengambil 4 berita terbaru dari database
$query_guru = "SELECT * FROM guru";
$result_guru = mysqli_query($koneksi, $query_guru);
?>

  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Daftar Guru</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Guru Kami</li>
          </ol>
        </nav>
      </div>
    </div>

<section id="team" class="team section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Tim Kami</h2>
    <p>Profil Guru dan Pengurus</p>
  </div>
  <div class="container">
<div class="row gy-4">

    <?php
    // Cek apakah ada data guru yang ditemukan
    if (mysqli_num_rows($result_guru) > 0) {
        
        // Loop (ulangi) untuk setiap baris data guru
        while ($guru = mysqli_fetch_assoc($result_guru)) {
            // $guru sekarang berisi data 1 guru, misal:
            // $guru['nama_guru']
            // $guru['foto_guru']
            // $guru['jabatan_guru']
            // $guru['deskripsi_guru']
    ?>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <img src="<?php echo htmlspecialchars($guru['foto']); ?>" class="img-fluid" alt="Foto <?php echo htmlspecialchars($guru['nama']); ?>">
                    
                    <div class="member-info">
                        <h4><?php echo htmlspecialchars($guru['nama']); ?></h4>
                        <h4><?php echo htmlspecialchars($guru['jabatan']); ?></h4>
                        
                        <span><?php echo htmlspecialchars($guru['keterangan']); ?></span>
                    </div>
                </div>
            </div>
            <?php
        } // Akhir dari loop while
    } else {
        // Jika tidak ada guru di database, tampilkan pesan
        echo "<p class='col-12 text-center'>Belum ada data guru untuk ditampilkan.</p>";
    }
    ?>
</div>
  </div>
</section>
    </main>
    <?php
// 3. Memanggil Footer
include 'footer.php';

// 4. Tutup koneksi
mysqli_close($koneksi);
?> 