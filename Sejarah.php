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
      <!-- 
        CATATAN: 
        Style untuk 'timeline' ini belum ada di 'main.css' Anda.
        Saya akan tambahkan style dasarnya agar rapi.
      -->
      <style>
        .timeline { list-style: none; padding: 20px 0 20px; position: relative; }
        .timeline:before { top: 0; bottom: 0; position: absolute; content: " "; width: 3px; background-color: #eee; left: 50%; margin-left: -1.5px; }
        .timeline-item { margin-bottom: 20px; position: relative; }
        .timeline-item:before, .timeline-item:after { content: " "; display: table; }
        .timeline-item:after { clear: both; }
        .timeline-item .timeline-panel { width: 46%; float: left; border: 1px solid #ddd; border-radius: 8px; padding: 20px; position: relative; box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05); background: var(--surface-color); }
        .timeline-item:nth-child(even) .timeline-panel { float: right; }
        .timeline-item .timeline-image { width: 150px; height: 150px; position: absolute; left: 50%; top: 15px; margin-left: -75px; z-index: 10; background-color: #09947d; border-radius: 50%; padding: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.2); }
        .timeline-item .timeline-image img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
        .timeline-heading h4 { margin-top: 0; color: var(--accent-color); font-weight: 700; }
        .timeline-body p { margin-bottom: 0; }
        
        /* Panah kecil di panel */
        .timeline-item .timeline-panel:before { position: absolute; top: 26px; right: -15px; display: inline-block; border-top: 15px solid transparent; border-left: 15px solid #ccc; border-right: 0 solid #ccc; border-bottom: 15px solid transparent; content: " "; }
        .timeline-item .timeline-panel:after { position: absolute; top: 27px; right: -14px; display: inline-block; border-top: 14px solid transparent; border-left: 14px solid #fff; border-right: 0 solid #fff; border-bottom: 14px solid transparent; content: " "; }
        .timeline-item:nth-child(even) .timeline-panel:before { right: auto; left: -15px; border-left-width: 0; border-right-width: 15px; }
        .timeline-item:nth-child(even) .timeline-panel:after { right: auto; left: -14px; border-left-width: 0; border-right-width: 14px; }
        
        /* Media Query untuk HP */
        @media (max-width: 767px) {
          .timeline:before { left: 30px; }
          .timeline-item .timeline-panel { width: calc(100% - 60px); float: right; }
          .timeline-item .timeline-image { left: 0; margin-left: 0; width: 60px; height: 60px; top: 16px; }
          .timeline-item .timeline-panel { padding-left: 30px; }
          .timeline-item .timeline-panel:before { right: auto; left: -15px; border-left-width: 0; border-right-width: 15px; }
          .timeline-item .timeline-panel:after { right: auto; left: -14px; border-left-width: 0; border-right-width: 14px; }
        }
      </style>

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
<!-- 
  ===============================================
  ===== KONTEN UNIK HALAMAN SEJARAH SELESAI =====
  ===============================================
-->

<?php
// 3. Memanggil Footer (JavaScript, dll)
include 'footer.php';
?>