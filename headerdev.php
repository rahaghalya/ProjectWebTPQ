<?php
// File ini akan dipanggil oleh semua halaman .php Anda
// Kita mulai koneksi di sini agar bisa dipakai di semua halaman
include_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TPQ Roudlotulilmi Rembang - Tentang Kami</title>
  <meta name="description" content="Website resmi TPQ Roudlotul Ilmi Rembang ">
  <meta name="keywords" content="TPQ, Roudlotul Ilmi">

  <link href="assets/img/LOGO.jpg" rel="icon">
  <link href="assets/img/LOGO.jpg" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/maindev.css" rel="stylesheet">

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
      const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
      if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function(event) {
          event.preventDefault();
          event.stopPropagation(); // Ini kodenya

          document.body.classList.toggle('mobile-nav-active');
          this.classList.toggle('bi-list');
          this.classList.toggle('bi-x');
        });
      }

      // Mencegah menu menutup saat diklik di dalam
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
    <div class="branding d-flex align-items-cente">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
          <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ" style="height: 40px; margin-right: 10px;">
          <h1 class="sitename">TPQ Roudlotul ilmi</h1>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="siswadev.php">Siswa</a></li>
            <li><a href="gurudev.php">guru</a></li>
            <li><a href="beritadev.php">berita</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>