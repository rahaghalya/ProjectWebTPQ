<?php
// 1. Memanggil Header & Koneksi
include 'header.php';

// 2. Query untuk mengambil data guru
// (Saya ubah nama variabelnya jadi $result_guru biar lebih nyambung)
$query_guru = "SELECT * FROM guru ORDER BY id_guru ASC"; 
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
      <p>Profil Guru dan Pengurus TPQ Roudlotul Ilmi</p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <?php
        // 3. CEK APAKAH ADA DATA GURU?
        if (mysqli_num_rows($result_guru) > 0) {
            
            // Variabel untuk efek delay animasi
            $delay = 100;

            // 4. MULAI LOOPING (PERULANGAN)
            while ($row = mysqli_fetch_assoc($result_guru)) {
                
                // Logika Foto: Jika foto kosong atau file tidak ada, pakai foto default
                $foto_path = $row['foto'];
                if (empty($foto_path) || !file_exists($foto_path)) {
                    $foto_path = "assets/img/person/default-profile.webp"; // Pastikan Anda punya gambar default ini atau ganti pathnya
                }
        ?>
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
              <div class="member">
                
                <div class="member-img">
                    <img src="<?php echo htmlspecialchars($foto_path); ?>" class="img-fluid" alt="Foto <?php echo htmlspecialchars($row['nama']); ?>" style="width: 100%; height: 300px; object-fit: cover;">
                </div>

                <div class="member-info">
                  <h4><?php echo htmlspecialchars($row['nama']); ?></h4>
                  
                  <span><?php echo htmlspecialchars($row['jabatan']); ?></span>
                  
                  <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                </div>

              </div>
            </div>
            <?php
                // Tambah delay animasi agar muncul bergantian
                $delay += 100;
            } // Akhir While

        } else {
            // Jika data kosong
            echo '<div class="col-12 text-center"><p>Belum ada data guru yang tersedia.</p></div>';
        }
        ?>

      </div>
    </div>

  </section>

</main>

<?php
// 5. Memanggil Footer & Tutup Koneksi
include 'footer.php';
// mysqli_close($koneksi); // Opsional, PHP akan menutup otomatis di akhir
?>