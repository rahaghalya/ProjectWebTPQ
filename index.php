<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';

$query_santri = "SELECT COUNT(*) AS total_santri FROM santri WHERE keterangan = 'aktif' OR keterangan IS NULL";
$result_santri = mysqli_query($koneksi, $query_santri);
$data_santri = mysqli_fetch_assoc($result_santri);
$total_santri = $data_santri['total_santri'];

$query_alumni = "SELECT COUNT(*) AS total_alumni FROM santri WHERE Keterangan IN ('Lulus', 'Pindah')";
$result_alumni = mysqli_query($koneksi, $query_alumni);
$data_alumni = mysqli_fetch_assoc($result_alumni);
$total_alumni = $data_alumni['total_alumni'];
?>

<main class="main">
    <div class="page-title" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Home</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Home</li>
          </ol>
        </nav>
      </div>
    </div>

  <section id="home-description" class="home-description section">
    <div class="container section-title" data-aos="fade-up">
      <h2>TPQ Roudlotul Ilmi Rembang</h2>
      <p>Membina Generasi Qur'ani yang Cerdas dan Berakhlak Mulia</p>
    </div>
      <div class="container" data-aos="fade-up">
        <div class="row gy-4 align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
              <img src="assets/img/about/adab25a7-7552-4623-abcb-273b2a31d9fa.jpg" class="img-fluid rounded" alt="Ilustrasi Metode Pembelajaran" style="height: auto;">
              <p class="small text-muted mt-2">Suasana belajar yang interaktif dan menyenangkan.</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h4 style="font-weight: 600; color: var(--heading-color); margin-top: 1.5rem;">Metode Pembelajaran Kami</h4>
              <p>
                Kami berkomitmen untuk menciptakan lingkungan belajar Al-Qur'an yang nyaman, menyenangkan, dan Islami.
              </p>
                <p>
                  Didukung oleh tenaga pengajar yang sabar dan kompeten, kami siap membimbing para santri untuk cinta Al-Qur'an, cerdas, dan berakhlak mulia.
                </p>
                  <p>
                    Fokus kami adalah pada pembelajaran yang efektif dan praktis, mencakup:
                  </p>
                   <ul>
                    <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Pembelajaran Baca Tulis Al-Qur'an (BTA).</li>
                    <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Hafalan surat-surat pendek dan doa harian.</li>
                    <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Praktek ibadah praktis (Wudhu, Sholat).</li>
                    <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Pengenalan Fiqih dasar dan Akhlak.</li>
                  </ul>
              <br>
          </div>
        </div>
      </div>
  </section>

    <section id="home-description" class="home-description section">
        <div class="container" data-aos="fade-up">
          <div class="row gy-4 align-items-center">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <p>
                Kami berkomitmen untuk menciptakan lingkungan belajar Al-Qur'an yang nyaman, menyenangkan, dan Islami.
              </p>
              <p>
                Didukung oleh tenaga pengajar yang sabar dan kompeten, kami siap membimbing para santri untuk cinta Al-Qur'an, cerdas, dan berakhlak mulia.
              </p>
              <h4 style="font-weight: 600; color: var(--heading-color); margin-top: 1.5rem;">Metode Pembelajaran</h4>
              <p>
                Fokus kami adalah pada pembelajaran yang efektif dan praktis, mencakup:
              </p>
              <ul>
                <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Pembelajaran Baca Tulis Al-Qur'an (BTA).</li>
                <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Hafalan surat-surat pendek dan doa harian.</li>
                <li><i class="bi bi-check-circle-fill" style="color: var(--accent-color);"></i> Praktek ibadah praktis (Wudhu, Sholat).</li>
              </ul>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
              <h4 style="font-weight: 600; color: var(--heading-color); margin-top: 1.5rem;" class="text-center">Izin Mengajar Resmi</h4>
              <div class="text-center my-3">
                <img src="assets/img/about/1.webp" 
                    class="img-fluid rounded" 
                    alt="Sertifikat Izin Mengajar" 
                    style="height: auto; border: 1px solid #ddd; padding: 5px; max-height: 400px; background-color: #f9f9f9;">
                <p class="small text-muted mt-2">Sertifikat Izin Operasional Mengajar.</p>
              </div>
            </div>
          </div>
        </div>
    </section>
    
<section id="fakta-tpq" class="stats-counter section">
    <div class="container" data-aos="fade-up">
      <div class="container section-title" data-aos="fade-up">
        <h2>Riwayat Study</h2>
        <p>TPQ Roudlotul Ilmi</p>
      </div>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="stats-item text-center">
            <span data-purecounter-start="0" 
                  data-purecounter-end="<?php echo $total_santri; ?>" 
                  data-purecounter-duration="1" 
                  class="purecounter"></span>
            <p>santri</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="stats-item text-center">
            <span data-purecounter-start="0" 
                  data-purecounter-end="<?php echo $total_alumni; ?>" 
                  data-purecounter-duration="1" 
                  class="purecounter"></span>
            <p>Alumni</p>
          </div>
        </div>
      </div>
    </div>
  </section>

<section id="berita" class="portfolio section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Berita Terbaru</h2>
    <p>Berita dan Kegiatan Terbaru dari TPQ Roudlotul Ilmi</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 portfolio-container">

      <?php
      // Query untuk ambil 4 berita terbaru
      $query_berita = "SELECT * FROM tabel_berita ORDER BY tanggal_upload DESC LIMIT 4";
      $result_berita = mysqli_query($koneksi, $query_berita);

      // Cek apakah ada data
      if (mysqli_num_rows($result_berita) > 0) {
        while ($row = mysqli_fetch_assoc($result_berita)) {
          $id_berita = $row['id_berita'];
          $judul = $row['judul_berita'];
          $gambar = $row['gambar_berita'];
          $tanggal = date('d F Y', strtotime($row['tanggal_upload'])); // format: 25 Oktober 2025
      ?>
          <div class="col-lg-3 col-md-6 portfolio-item">
            <div class="portfolio-card">
              <div class="image-container">
                <img src="uploads/berita/<?php echo $gambar; ?>" 
                     class="img-fluid" 
                     alt="<?php echo $judul; ?>">
                <div class="overlay">
                  <div class="overlay-content">
                    <a href="uploads/berita/<?php echo $gambar; ?>" 
                       data-gallery="portfolio-gallery-berita" 
                       class="glightbox" 
                       title="Lihat Gambar"><i class="bi bi-zoom-in"></i></a>
                    <a href="berita-detail.php?id=<?php echo $id_berita; ?>" 
                       title="Selengkapnya"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div>
              </div>
              <div class="content" style="text-align: left; padding: 15px;">
                <h3 style="font-size: 1.1rem; font-weight: 600;">
                  <a href="berita-detail.php?id=<?php echo $id_berita; ?>">
                    <?php echo $judul; ?>
                  </a>
                </h3>
                <p style="font-size: 0.8rem; color: #888; margin-bottom: 0;">
                  <i class="bi bi-calendar-event"></i> <?php echo $tanggal; ?>
                </p>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        echo '<p class="text-center">Belum ada berita yang diunggah.</p>';
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