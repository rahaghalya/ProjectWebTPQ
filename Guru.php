<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';
// 2. Query untuk mengambil 4 berita terbaru dari database
$query_berita = "SELECT * FROM guru_tpq";
$result_berita = mysqli_query($koneksi, $query_berita);
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
  </div><div class="container">

    <div class="row gy-4">

      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
        <div class="member">
          <img src="assets/img/person/person-f-10.webp" class="img-fluid" alt="Foto Ahmad Yani">
          <div class="member-info">
            <h4>Ahmad Yani</h4>
            <span>Kepala TPQ</span>
            <p>Bertanggung jawab atas manajemen dan kurikulum TPQ.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
        <div class="member">
          <img src="assets/img/person/person-f-1.webp" class="img-fluid" alt="Foto Siti Aminah">
          <div class="member-info">
            <h4>Siti Aminah</h4>
            <span>Guru BTA (Baca Tulis Al-Qur'an)</span>
            <p>Mengajar santri metode baca tulis Al-Qur'an dengan sabar.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
        <div class="member">
          <img src="assets/img/person/person-f-3.webp" class="img-fluid" alt="Foto Muhammad Idris">
          <div class="member-info">
            <h4>Muhammad Idris</h4>
            <span>Guru Hafalan & Fiqih</span>
            <p>Membimbing santri dalam hafalan surat pendek dan praktek ibadah.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
        <div class="member">
          <img src="assets/img/person/person-f-10.webp" class="img-fluid" alt="Foto Ahmad Yani">
          <div class="member-info">
            <h4>Ahmad Yani</h4>
            <span>Kepala TPQ</span>
            <p>Bertanggung jawab atas manajemen dan kurikulum TPQ.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
        <div class="member">
          <img src="assets/img/person/person-f-1.webp" class="img-fluid" alt="Foto Siti Aminah">
          <div class="member-info">
            <h4>Siti Aminah</h4>
            <span>Guru BTA (Baca Tulis Al-Qur'an)</span>
            <p>Mengajar santri metode baca tulis Al-Qur'an dengan sabar.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
        <div class="member">
          <img src="assets/img/person/person-f-3.webp" class="img-fluid" alt="Foto Muhammad Idris">
          <div class="member-info">
            <h4>Muhammad Idris</h4>
            <span>Guru Hafalan & Fiqih</span>
            <p>Membimbing santri dalam hafalan surat pendek dan praktek ibadah.</p>
          </div>
        </div>
      </div>
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