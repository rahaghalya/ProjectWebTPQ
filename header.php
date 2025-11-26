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

  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index">

  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center dark-background">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="#">tpqroudlotulilmirembang@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+62 83824275728</span></i>
        </div>
      </div>
    </div>
    <div class="branding d-flex align-items-cente">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ" style="height: 40px; margin-right: 10px;">
          <h1 class="sitename">TPQ Roudlotul ilmi</h1>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown"><a href="#"><span>Tentang Kami</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="about.php">Profil TPQ</a></li>
                <li><a href="Guru.php">Profil Guru</a></li>
                <li><a href="Pelajar.php">Profil Pelajar</a></li>
              </ul>
            </li>
            <li><a href="Sejarah.php">Sejarah</a></li>
            <li><a href="https://wa.me/message/I7EOQHDYJEXDL1 ">Kontak</a></li>
            <li><a href="login.html">Login</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>