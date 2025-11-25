<?php
// 1. Memanggil Header (CSS, Menu, dll)
include 'header.php';
?>

<!-- 
  ===============================================
  ===== KONTEN UNIK HALAMAN SEJARAH DIMULAI =====
  ===============================================
-->
<main class="main">
  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Sejarah</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Sejarah</li>
        </ol>
      </nav>
    </div>
  </div>
  <section id="sejarah" class="sejarah section">
    
    <!-- Judul Bagian -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Perkembangan Kami</h2>
      <p>Jejak Langkah TPQ Roudlotul Ilmi dari Tahun ke Tahun</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <ul class="timeline">
        <!-- Item 1: Tahun 2020 (Kiri) -->
        <li class="timeline-item">
          <div class="timeline-image">
            <img src="https://placehold.co/150x150/09947d/white?text=2020" class="img-fluid" alt="Awal Berdiri 2020">
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4>2020 - Awal Berdiri</h4>
            </div>
            <div class="timeline-body">
              <p>TPQ Roudlotul Ilmi didirikan dengan semangat untuk memberantas buta huruf Al-Qur'an. Pembelajaran dimulai dengan 5 santri di teras rumah pendiri.</p>
            </div>
          </div>
        </li>

        <!-- Item 2: Tahun 2021 (Kanan) -->
        <li class="timeline-item">
          <div class="timeline-image">
            <img src="https://placehold.co/150x150/09947d/white?text=2021" class="img-fluid" alt="Kegiatan 2021">
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4>2021 - Mulai Bertumbuh</h4>
            </div>
            <div class="timeline-body">
              <p>Jumlah santri bertambah menjadi 20 orang. Kegiatan belajar mengajar pindah ke Musholla terdekat untuk menampung lebih banyak santri.</p>
            </div>
          </div>
        </li>

        <!-- Item 3: Tahun 2022 (Kiri) -->
        <li class="timeline-item">
          <div class="timeline-image">
            <img src="https://placehold.co/150x150/09947d/white?text=2022" class="img-fluid" alt="Guru Baru 2022">
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4>2022 - Peresmian Metode</h4>
            </div>
            <div class="timeline-body">
              <p>Secara resmi mengadopsi metode pembelajaran (misal: Iqro' atau Ummi) dan menambah 2 tenaga pengajar baru untuk meningkatkan kualitas pengajaran.</p>
            </div>
          </div>
        </li>

        <!-- Item 4: Tahun 2024 (Kanan) -->
        <li class="timeline-item">
          <div class="timeline-image">
            <img src="https://placehold.co/150x150/09947d/white?text=2024" class="img-fluid" alt="Wisuda 2024">
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4>2024 - Lulusan Pertama</h4>
            </div>
            <div class="timeline-body">
              <p>Mengadakan acara wisuda dan kelulusan untuk 5 santri angkatan pertama yang telah menyelesaikan Al-Qur'an. Santri aktif mencapai 50 orang.</p>
            </div>
          </div>
        </li>

      </ul>
    </div>
  </section>
</main>
<?php
// 3. Memanggil Footer (JavaScript, dll)
include 'footer.php';
?>