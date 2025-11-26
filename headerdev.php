<?php
// File: headerdev.php
include_once 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TPQ Roudlotulilmi Rembang</title>
  <meta name="description" content="Website resmi TPQ Roudlotul Ilmi Rembang">
  <meta name="keywords" content="TPQ, Roudlotul Ilmi">

  <link href="assets/img/LOGO.jpg" rel="icon">
  <link href="assets/img/LOGO.jpg" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/maindev.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css" rel="stylesheet">


  <style>

  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
      if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function(event) {
          event.preventDefault();
          event.stopPropagation();
          document.body.classList.toggle('mobile-nav-active');
          this.classList.toggle('bi-list');
          this.classList.toggle('bi-x');
        });
      }
      const navMenu = document.querySelector('#navmenu');
      if (navMenu) {
        navMenu.addEventListener('click', (event) => {
          if (!event.target.classList.contains('toggle-dropdown')) {
            event.stopPropagation();
          }
        });
      }
    });
  </script>
</head>

<body class="index">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="#" class="logo d-flex align-items-center">
          <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ" style="height: 40px; margin-right: 10px;">
          <h1 class="sitename">TPQ Roudlotul ilmi</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="data_santri.php">Siswa</a></li>
            <li><a href="gurudev.php">Guru</a></li>
            <li><a href="beritadev.php">Berita</a></li>
          </ul>

          <?php
          // 1. Ambil nama file saat ini
          $currentPage = basename($_SERVER['PHP_SELF']);

          // 2. Tentukan nama file Dashboard utama Anda
          // PENTING: Jika file dashboard Anda bernama 'dashboard.php', GANTI 'index.php' DI BAWAH MENJADI 'dashboard.php'
          $dashboardPage = 'dashboard.php';

          // 3. Cek Kondisi
          if ($currentPage == $dashboardPage) {
            // Jika di Dashboard: Jangan tampilkan apa-apa (Hamburger hilang sesuai request)
          } else {
            // Jika BUKAN di Dashboard: Tampilkan Tombol Kembali
            // Saya hapus 'd-xl-none' supaya muncul di HP DAN KOMPUTER
            echo '<a href="' . $dashboardPage . '" class="tombol-kembali-custom bi bi-arrow-left" title="Kembali ke Dashboard"></a>';
          }
          ?>
        </nav>
      </div>
    </div>
  </header>