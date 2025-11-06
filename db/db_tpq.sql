-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Nov 2025 pada 15.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpq_roudlotul_ilmi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id_history` int(5) DEFAULT NULL,
  `skor` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(5) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `No_telp` int(14) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(5) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `no_induk` int(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(50) DEFAULT NULL,
  `Alamat` varchar(30) DEFAULT NULL,
  `Nama_orang_tua` varchar(50) DEFAULT NULL,
  `NIK` int(20) DEFAULT NULL,
  `NO_KK` int(20) DEFAULT NULL,
  `Tahun_masuk` int(10) DEFAULT NULL,
  `Keterangan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`no_induk`, `nama`, `Tempat_tanggal_lahir`, `Alamat`, `Nama_orang_tua`, `NIK`, `NO_KK`, `Tahun_masuk`, `Keterangan`) VALUES
(1, 'Akhmad Zukhruf Ferdiansyah', 'Surabaya, 27 Februari 2007', 'Perumahan Anggun Sejahtera Rem', 'Abdul Jabar', 0, 0, 0, ''),
(2, 'Puteri Lintang Kinaseh', 'Gresik, 01 Maret 2009', 'Perumahan Anggun Sejahtera Rem', 'Moch Sandi', 0, 0, 0, ''),
(3, 'Livia Luna Azahra', 'Surabaya, 12 Mei 2008', 'Perumahan Anggun Sejahtera Rem', 'Eko Budi Mariyanto', 0, 0, 0, ''),
(7, 'Aka Hasif Rafsyanjani', 'Pasuruan, 25 September 2017', 'Perumahan Anggun Sejahtera Rem', 'Achnad Nurrudin', 0, 0, 0, 'Keluar'),
(8, 'Muhammad Abdul Aziz', 'Pasuruan , 05 Oktober 2017', 'Perumahan Anggun Sejahtera Rem', 'Supriadi', 0, 0, 0, ''),
(9, 'Muhammad Alvin Torikhi', 'PAsuruan, 05 Desember 2016', 'Perumahan Anggun Sejahtera Rem', 'Susilo', 0, 0, 0, ''),
(10, 'Raisa Aqila Wijaya', 'Malang, 04 September 2013', 'Perumahan Anggun Sejahtera Rem', 'Herman Jodhie Wijaya', 0, 0, 0, ''),
(11, 'Azkadina Clarabella Wijaya', 'Malang, 02 April 2017', 'Perumahan Anggun Sejahtera Rem', 'Herman Jodhie Wijaya', 0, 0, 0, ''),
(12, 'Kahyla Afsheen Myesha R', 'Malang, 23 Juli 2013', 'Perumahan Anggun Sejahtera Rem', 'Lukas Susanto', 0, 0, 0, ''),
(13, 'M. Arjuna arya Satya Adhiasta Putra Susanto', 'Malang, 20 November 2015', 'Perumahan Anggun Sejahtera Rem', 'Lukas Susanto', 0, 0, 0, ''),
(14, 'Zahirah Azalia Mujahidafillah ', 'Gresik, 12 Januari 2007', 'Perumahan Anggun Sejahtera Rem', 'Soetris Dianto', 0, 0, 0, ''),
(15, 'Zemirah Azaria Mujahidafillah', 'Surabaya, 01 Desember 2011', 'Perumahan Anggun Sejahtera Rem', 'Soetris Dianto', 0, 0, 0, ''),
(16, 'Asisyah Nurul Lathifah ', 'Tulungagung, 28 April 2016', 'Perumahan Anggun Sejahtera Rem', 'David Berry Minton', 0, 0, 0, ''),
(17, 'Alesha Putri Maulidia', 'Pasuruan,18 Januari 2018', 'Perumahan Anggun Sejahtera Rem', 'waris Maulidi', 0, 0, 0, ''),
(18, 'Mohammad Dzaky Dzulhilmi', 'Suarabaya, 13 Oktober 2015', 'Perumahan Anggun Sejahtera Rem', 'Moch Nasikin', 0, 0, 0, ''),
(19, 'Vanessa Nadira R', 'Malang, 04 September 2009', 'Perumahan Anggun Sejahtera Rem', 'Ferry Wahono S', 0, 0, 0, ''),
(20, 'Syarfaras Naufal Prasetyo', 'Lebar, 18 April 2012', 'Perumahan Anggun Sejahtera Rem', 'Doddy Prasetyo', 0, 0, 0, ''),
(21, 'Zaskia Manda Saputri', 'Yogyakarta, 12 Januari 2011', 'Perumahan Anggun Sejahtera Rem', 'Herito', 0, 0, 0, ''),
(22, 'Atha Fauzan Mahdafi', 'Malang, 19 November 2012', 'Perumahan Anggun Sejahtera Rem', 'Yuli Siswanto', 0, 0, 0, ''),
(23, 'Rayhan Ramadhan', 'Papua, 18 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Sabdar', 0, 0, 0, ''),
(24, 'Tyara Amanda ', 'Malang,29 Desember 2012', 'Perumahan Anggun Sejahtera Rem', 'Sabdar', 0, 0, 0, ''),
(25, 'Mutiya Naela Sari', 'Malang, 24 Juli 2016', 'Perumahan Anggun Sejahtera Rem', 'Sabdar', 0, 0, 0, ''),
(26, 'Aisyah Aulia Putri ', 'Pasuruan,21 Oktober 2015', 'Perumahan Anggun Sejahtera Rem', 'Nidi Hidayat', 0, 0, 0, ''),
(27, 'Mutiara Putri Balqis', 'Sidoarjo,14 Juni 2010', 'Perumahan Anggun Sejahtera Rem', 'Heri Israwan', 0, 0, 0, ''),
(28, 'Zahira Aura Rengganies', 'Surabaya, 27 Maret 2012', 'Perumahan Anggun Sejahtera Rem', 'Heri Israwan', 0, 0, 0, ''),
(29, 'Annisa Hayfa Zhafira', 'Surabaya,23 Januari 2017', 'Perumahan Anggun Sejahtera Rem', 'Lutfi', 0, 0, 0, ''),
(30, 'Aqiela Firly Mahfiro', 'Sueabaya, 25 Desember 2011', 'Perumahan Anggun Sejahtera Rem', 'Eko Budi Mariyanto', 0, 0, 0, ''),
(31, 'Rizky Putra Fajar ', 'Surabaya,02 Seotember 2012', 'Perumahan Anggun Sejahtera Rem', 'Moch Sandi', 0, 0, 0, ''),
(32, 'Aurelia Hacinta Putri Garay', '23,Desember 2013', '', 'M.Johar Nur Zaman', 0, 0, 0, ''),
(33, 'Sheikha Kirelna Erlynda', '14 Juni 2017', '', 'M.Johar Nur Zaman', 0, 0, 0, ''),
(34, 'Zhian Raffasya Al-Farizqy', 'Pasuruan, 22 Januari 2014', '', 'Altegra Cahyo Arbiyanto', 0, 0, 0, ''),
(35, 'Afika Agustin Ramadani', 'Pasuruan, 17 Agustus 2012', '', 'Wahyudi Agustrianto', 0, 0, 0, ''),
(36, 'Whisnu Adi Perwira ', 'Surabaya,14 Januari 2010', '', 'Basuki', 0, 0, 0, ''),
(37, 'Mutiara Keiko Abdillah ', 'Pasuruan,10 April 2012', '', 'Farid Sukron A', 0, 0, 0, ''),
(38, 'M. Syarif Afif Abdillah', 'Klaten, 06 Juli 2013', '', 'Farid Sukron A', 0, 0, 0, ''),
(39, 'Evan Ardiyanto', 'Malang, 09 Juni 2013', '', 'Robin Arif A', 0, 0, 0, ''),
(40, 'Ciko Putra Nur Herlambang', '', '', 'Heriyanto', 0, 0, 0, ''),
(41, 'Alvaro Dzaky Nur Heriansyah', '', '', 'Heriyanto', 0, 0, 0, ''),
(42, 'Aqita Cinta Nur Herlina', '', '', 'Heriyanto', 0, 0, 0, ''),
(43, 'Tian', '', '', '', 0, 0, 0, ''),
(44, 'Risqi Ramadhan Ardiansyah', '', '', 'Harsono', 0, 0, 0, ''),
(45, 'Iqbal', '', '', '', 0, 0, 0, ''),
(46, 'M. Daffa Ridho Alvaro ', 'Surabaya, 28 Mei 2009', '', 'Kikie Prahara', 0, 0, 0, ''),
(47, 'M. Fadhullah Akbar Alvaro', 'Surabaya,26 Desember 2014', '', 'Kikie Prahara', 0, 0, 0, ''),
(48, 'Stevanny Resya Putri', 'Surabaya,18,januari', '', 'Anton Abdul Ghafur', 0, 0, 0, ''),
(49, 'Valentino Rossi', 'Surabaya,31 Desember 2014', '', 'A Fahrul Rozy', 0, 0, 0, ''),
(50, 'Vino Agil Saputra', '', '', 'Indrajid', 0, 0, 0, ''),
(51, 'Abim Adam Firmansyah', 'Nganjuk ,31 Oktober 2010', '', 'Susanto', 0, 0, 0, ''),
(52, 'Zora Az-Zahra Kirana', 'Surabaya, 20 November 2012', '', 'Oneas Ari Arofa', 0, 0, 0, ''),
(53, 'Ilmira Savoury Islamidina', 'Surabaya,24 November 2013', '', 'Oneas Ari Arofa', 0, 0, 0, ''),
(54, 'Hasan Agung Setiawan', 'Surabaya,28 September 2012', '', 'Budi Harianto', 0, 0, 0, ''),
(55, 'Abigail Ghania Wijaya', 'Banyuwangi, 10 September 2018', '', 'Wandha Primartys Wijaya', 0, 0, 0, ''),
(56, 'Bilqis', '', '', '', 0, 0, 0, ''),
(57, 'Salma Bafage', '', '', 'Ali', 0, 0, 0, ''),
(58, 'Muhammad Syahrur Roby ', 'PAsuruan, 26 Desember 2010', '', 'Sudurduri', 0, 0, 0, ''),
(59, 'Daffa Maulana Zidane Al-S', 'Surabaya, 1 Oktober 2010', '', 'Heriadi', 0, 0, 0, ''),
(60, 'Nandina Zalzabila Ayu W', 'Jember,10 Mei 2013', '', 'Fendik Susanto', 0, 0, 0, ''),
(61, 'Anandita Keisha Zahra', 'Madiun, 03 Oktober 2015', '', 'Heri Siswanto', 0, 0, 0, ''),
(62, 'M. Alvin Pratama ', 'Pasuruan,11 Desember 2015', '', 'Muhammad Samsul Arifin', 0, 0, 0, ''),
(63, 'M. Rafie', '', '', 'Riyantoko', 0, 0, 0, ''),
(64, 'M. Rafa Azka Ramadhan', 'Lamongan,07 Juli 2015', '', 'Budi Feriyanto', 0, 0, 0, ''),
(65, 'Jiha Shielu Khumaira ', 'Malang,01 Februari 2015', '', 'Totok Harianto', 0, 0, 0, ''),
(66, 'Dzaki Maulana Ilham ', 'Surabaya, 18 Juli 2009', '', 'Wasis Sumiyanto', 0, 0, 0, ''),
(67, 'Aliyana Mirzha', 'Pasuruan,10 Juni 2015', '', 'Muhammad Faruqi', 0, 0, 0, ''),
(68, 'Anindya Hikari Assyifa', 'Surabaya, 13 April 20217', '', 'M. Acep Bahrudin', 0, 0, 0, ''),
(69, 'Ragil Putra Maldini', 'Surabaya,06 April 2014', '', 'Andi Susilo', 0, 0, 0, ''),
(70, 'Adam Zakaria Firmansyah Putra Ariesmanto', '23 Agustus 2013', '', 'Deby Ariesmanto', 0, 0, 0, ''),
(71, 'Rezky Ramadhan Taufik', 'Sidoarjo,21 Agustus 2009', '', 'Ivan Taufik', 0, 0, 0, ''),
(72, 'Vicky Handa Antoni', 'Sidoarjo, 23 Oktober 2012', '', 'Anton Cahyono', 0, 0, 0, ''),
(73, 'Saskia Samha Fauzia', 'Pasuruan,30 Maret 2014', '', 'Rochman Fauzi', 0, 0, 0, ''),
(74, 'Muhammad Agam El Dzaky', 'Lumajang, 17 Februari 2017', '', 'Achmad Mahmudi', 0, 0, 0, ''),
(75, 'Sakia Ayu El Dzaky', '', '', 'Achmad Mahmudi', 0, 0, 0, ''),
(76, 'Mieke Khaira Wildha', 'Surakarta, 13 Mei 2017', '', 'Miftachul Giri', 0, 0, 0, 'Pindah Rumah'),
(77, 'Achmad Farid Al-Farizi', 'Surabaya, 08 Desember 2016', '', 'Achmad Faisol', 0, 0, 0, 'Keluar'),
(78, 'Reyshallah Nurfebian', 'Lamongan, 11 Juli 2012', '', 'Febrianto', 0, 0, 0, 'Pindah Rumah'),
(79, 'Yanuar Pangestu Fabian', 'Pasuruan, 12 Januari 2017', '', 'Febrianto', 0, 0, 0, 'Pindah Rumah'),
(80, 'Achmad Fathoni Fatahillah', 'Surabaya, 12 September 2014', '', 'Achmad Faisol', 0, 0, 0, 'Pindah Rumah'),
(81, 'M. Ibnu Abdul Jabar M.', 'Pasuruan, 22 Januari 2018', '', 'Saikhu Roji\'in', 0, 0, 0, ''),
(82, 'Fiorenza Divya Beby F.', 'Surabaya, 06 Januari 2015', '', 'Ony Yuwanto', 0, 0, 0, 'Keluar Tanpa Keteran'),
(83, 'Nira Airlangga', 'Pasuruan, 15 Januari 2013', '', 'Nanang Budi Utomo', 0, 0, 0, 'Keluar'),
(84, 'Arsy Azahra Saula Andrias', 'Sidoarjo, 31 Maret 2017', '', 'Afriandi Johan W.', 0, 0, 0, 'Keluar'),
(85, 'Zahra Aisyah Marwa A.', 'Jember, 06 April 2013', '', 'Afriandi Johan W.', 0, 0, 0, 'Keluar'),
(86, 'Janeta Zain Sava Andrias', 'Jember, 13 Juni 2011', '', 'Afriandi Johan W.', 0, 0, 0, 'Keluar'),
(87, 'Adeeva Varisha Afseen', 'Banyuwangi, 08 Juni 2015', '', 'Achmad Nurdiyali S', 0, 0, 0, 'Keluar'),
(88, 'Adzkia Nadhira Rafana Putri A.', '', '', '', 0, 0, 0, ''),
(89, 'Ardi', '', '', '', 0, 0, 0, 'Keluar Thn 2020'),
(90, 'Naurinda Muta\'allimah Wibowo', 'Sidoarjo, 24 November 2014', '', 'Andik Wibowo', 0, 0, 0, 'Keluar'),
(91, 'Arka Nalendra Pratama Wibowo', 'Surabaya, 22 April 2010', '', 'Andik Wibowo', 0, 0, 0, ''),
(92, 'Rivaldo Mahardika Putra Pratama', 'Surabaya,27 Maret 20', '', 'Guntur Indra Nata', 0, 0, 0, ''),
(93, 'Aiko Maezurra Himeka A.P.S', 'SUrabaya,12 Juli 2016', '', 'Heriadi', 0, 0, 0, ''),
(94, 'Zahra ', '', '', '', 0, 0, 0, ''),
(95, 'Muhammad Jazilul Fawaidh', '', '', 'Widi Hidayat', 0, 0, 0, ''),
(96, 'Ibrahim', '', '', '', 0, 0, 0, ''),
(97, 'Shafira Putri Kusuma ', 'Surabaya, 11 Februari 2010', '', 'Yusuf Imam Kusuma', 0, 0, 0, ''),
(98, 'Aisyah Zahra ', 'Surabaya, 28 September 2016', '', 'Yusuf Imam Kusuma', 0, 0, 0, ''),
(99, 'Rafanda Zahra Lituhayu', 'Surabaya, 29 April 2014', '', 'I Prasetya Aji', 0, 0, 0, ''),
(100, 'Akifa Shakila Nur Sifa ', 'PAsuruan,20 Mei 2016', '', 'I Prasetya Aji', 0, 0, 0, ''),
(101, 'Dannies Akbar Yusuf Calief', 'Malang, 14 Oktober 2013', '', 'Wisnu Yudha Sanjaya', 0, 0, 0, ''),
(102, 'Salsabila Putri Azahra ', 'Malang, 07 Agustus 2012', '', 'Wisnu Yudha Sanjaya', 0, 0, 0, ''),
(103, 'Muhammad Harsa Pratama ', '', '', 'Muhammad Kharisun', 0, 0, 0, ''),
(104, 'Deswita Aulia Rachma ', 'Surabaya, 30 Desember 2013', '', 'Teguh Mulyo ', 0, 0, 0, ''),
(105, 'Risty Keyla Noviyanti ', 'Surabaya, 24 November 2011', '', 'Teguh Mulyo ', 0, 0, 0, ''),
(106, 'Trintanisa Chairunnisa Zahra ', 'Pasuruan,03 Februari 2016', '', 'Sutrisno', 0, 0, 0, ''),
(107, 'Daviana Fara Azzahra', 'Surabaya, 07 Maret 2014', '', 'Agus Waluyo', 0, 0, 0, ''),
(108, 'Anisa Nur Salsabila', 'Surabaya, 11 Juni 2015', '', 'Agus Waluyo', 0, 0, 0, ''),
(109, 'Septia Rengganis NAtalia Putri ', 'Surabaya,26 Desember 2009', '', 'Agus Hariyanto', 0, 0, 0, ''),
(110, 'Adnan Rasya Arrafif', '', '', 'Putra', 0, 0, 0, ''),
(111, 'Zahira Azzahra Fathiyyaturahma', 'Surabaya, 29 April 2013', '', 'Amir Kuswoyo', 0, 0, 0, ''),
(112, 'Muhammad Aliff Miftahul Fakhri ', 'Surabaya, 20 Desember 2009', '', 'Amir Kuswoyo', 0, 0, 0, ''),
(113, 'Hafidzah Inara Maheswari', 'Tegal, 5 Februari 2018', '', 'Sofyan Husain Achmari Yanto', 0, 0, 0, ''),
(114, 'Arka Mahadana Hartata Putra ', 'Pasuruan , 13 April 2015', '', 'Prakoso Hadi Hartata', 0, 0, 0, ''),
(115, 'Raza Aqila Pradipta Romansyah', 'Grobogan,20 Oktober 2011', '', 'Enarko Romansyah ', 0, 0, 0, ''),
(116, 'Faiqotus Shofa ', 'PAsuruan, 8 Agustus 2015', '', 'Asnawi', 0, 0, 0, ''),
(117, 'Chandra Kirana Tunggadhewi', 'Kediri, 11 Juni 2012', '', 'Denny Setyawan ', 0, 0, 0, ''),
(118, 'Aisyah Fadilah Az-zahra', 'Pasuruan, 27 Juni 2018', '', 'Lupi Susanggi', 0, 0, 0, ''),
(119, 'Afrida Dya Auliyah ', 'Pasuruan, 16 Agustus 2010', '', 'Supri adi', 0, 0, 0, ''),
(120, 'Rafie Putra Arieyanto', 'Blitar, 11 Januari 2016', '', 'Fx Andhi Arieyanto', 0, 0, 0, ''),
(121, 'Sheryl Azzahra Shahira Yusuf ', 'Pasuruan , 24 Juni 2018', '', 'Yusuf  Zainuri', 0, 0, 0, ''),
(122, 'Muhmmad Zidane Pradipta Santoso', 'Sidoarjo, 24 Desember 2016', '', 'Eko Budi Santoso', 0, 0, 0, ''),
(123, 'Muhammad Haikal Ramadhan ', 'Sidoarjo,2 Juni 2019', '', 'Arie Ardiansyah', 0, 0, 0, ''),
(124, 'Galang Faqih Rey Alteza ', 'SUrabaya,26 Juni 2013', '', 'Abdul Hafiz', 0, 0, 0, ''),
(125, 'Nur Ainy Fitria Wati', 'Lumajang, 19 September 2009', '', 'M.Nurhayadi', 0, 0, 0, ''),
(126, 'Agrata Razal Al-amin Al-alim', '', '', 'Dedi Agus Febriyanto', 0, 0, 0, ''),
(127, 'Felizia Yulaiba Azizi Cantika ', '', '', 'Dedi Agus Febriyanto', 0, 0, 0, ''),
(128, 'Fareza Juli Alfaro Azami', '', '', 'Dedi Agus Febriyanto', 0, 0, 0, ''),
(129, 'Arsya', '', '', '', 0, 0, 0, ''),
(130, 'Yudhistira RIski Wiriyawan', '', '', 'Agus Handoko', 0, 0, 0, ''),
(131, 'Marvel Owen Maulana Raditya ', '', '', 'Aditya Rahman', 0, 0, 0, ''),
(132, 'Rafanda Athalla Aditya ', '', '', 'Aditya Rahman', 0, 0, 0, ''),
(133, 'Septiano Keisha Raditya ', '', '', 'Aditya Rahman ', 0, 0, 0, ''),
(134, 'Najwa Seirlin Nuzulia Mubarak', 'Pasuruan, 15 Juli 2014', '', 'Muhammad Husni', 0, 0, 0, ''),
(135, 'Mukhammad Zidan Pradana', '20 September 2014', '', 'Alm.Nurul Yatim', 0, 0, 0, ''),
(136, 'Annindita Putrianto ', 'Surabaya, 11 Juli 2015', '', 'Oska Trianto', 0, 0, 0, ''),
(137, 'Muhammad ', '', '', '', 0, 0, 0, ''),
(138, 'Ayyash Djava Putra Nurhadi', 'Jember, 13 Juni 2011', '', '', 0, 0, 0, ''),
(139, 'Hanifah Indah Ardiyanti ', 'PAsuruan, 31 Juli 2015', '', 'M. Yusuf', 0, 0, 0, ''),
(140, 'khadijah', '', '', '', 0, 0, 0, ''),
(141, 'Ainayya Fitria Putri Nurhadi', 'Jember, 05 Juli 2016', '', '', 0, 0, 0, ''),
(142, 'Kafha Revan El Fatih', 'Sidoarjo, 28 September 2016', '', 'Fajirul Anam', 0, 0, 0, ''),
(143, 'Asmarahayu Wirawan', 'Jambi, 30 September ', '', 'Arya Wirawan', 0, 0, 0, ''),
(144, 'Radelia Qurrota Ayuni', 'Malang, 13 Oktober 2011', '', 'Afif Usnan', 0, 0, 0, ''),
(145, 'Raiqa Ayeshanata Firmansyah ', 'Surabaya, 21 mei 2019', '', 'Pujanata Wahyu Firmansyah ', 0, 0, 0, ''),
(146, 'Nabeel IbrahimKuddah', 'Sampang, 15 Mei 2020', '', 'Ibrahim Djakfar Kuddah', 0, 0, 0, ''),
(147, 'Abdul Latif Saputra ', 'Pasuruan,18 September 2018', '', 'M. Yusuf', 0, 0, 0, ''),
(148, 'Alecia Naura Vahrudin ', 'Surabaya,05 Juli 2017', '', 'Johan Vahrudin', 0, 0, 0, ''),
(149, 'Azka Cio Naufal Al Farizi', 'Surabaya, 12 September 2013', '', 'Johan Vahrudin', 0, 0, 0, ''),
(150, 'M. Maulana Yusuf Habibullah ', 'Surabaya, 08 Januari 2015`', '', 'Zariya', 0, 0, 0, ''),
(151, 'M. Hafiz Rizqi Ramadhan', 'Surabya, 23 Juni 2017', '', 'Zakaria', 0, 0, 0, ''),
(152, 'Kayla Eka Putri Kriswanto', 'Sidoarjo, 04 Desember 2008', '', 'Hengky Kriswanto', 0, 0, 0, 'Keluar'),
(153, 'Aurel Putri Ramadhani Kriswanto', 'Sidoarjo 01 September 2010', '', 'Hengky Kriswanto', 0, 0, 0, 'Keluar'),
(154, 'Ahmad Gusti Annizzar\'', 'Surabaya. 02 Agustus 2013', '', 'Mochamamad Irfan', 0, 0, 0, ''),
(155, 'Humaira Rasya Nurdiansyah', 'Sidoarjo. 27 Mei 2018', '', 'Nurdin Alamsyah', 0, 0, 0, 'Keluar'),
(156, 'Brian Ega Pratama Riyanto', 'Surabaya, 21 Mei 2010', '', 'Surianto', 0, 0, 0, 'Keluar'),
(157, 'Harir Husna', 'Surabya, 25 Maret 2016', '', 'Muhammad Yasir', 0, 0, 0, 'Keluar'),
(158, 'Queensha Vindy Meiqhaela', 'Sidoarjo, 21 Mei 2013', 'Perumahan Anggun Sejahtera Rem', 'Andi Sarial', 0, 0, 0, 'Keluar'),
(159, 'Ahmad Fatih Syamsudin', 'Pasuruan, 14 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Abu samsudin', 0, 0, 0, 'Keluar'),
(160, 'Al-Fatih Akbar Rizki A', 'Malang, 8 Juli 2017', 'Perumahan Anggun Sejahtera Rem', 'Nugroho Rizki E.', 0, 0, 0, 'Keluar'),
(161, 'Anandya Putri Kirana', 'Pasuruan 18 Maret 2020', 'Perumahan Anggun Sejahtera Rem', 'Laksono Rahmat P', 0, 0, 0, 'Keluar'),
(162, 'Shazfa Ohafania A', 'Lumajang, 1 Mei 2018', 'Perumahan Anggun Sejahtera Rem', 'Susanto', 0, 0, 0, ''),
(163, 'Najwa Azka Alya Putri', 'Pasuruan, 4 Juli 2019', 'Perumahan Anggun Sejahtera Rem', 'Abdul Jabar', 0, 0, 0, ''),
(164, 'Arsyila Chavia Humaira', 'Surabaya, 23 November 2019', 'Perumahan Anggun Sejahtera Rem', 'M. Chaninul', 0, 0, 0, ''),
(165, 'Tiger Ghazalii Putra', 'Bondowoso, 15 April 2015', 'Perumahan Anggun Sejahtera Rem', 'Rio Aditya Wardana', 0, 0, 0, 'Keluar'),
(166, 'Adelia Fairuz Zafirah P', 'Malang, 23 Februari 2014', 'Perumahan Anggun Sejahtera Rem', 'Ahmad Khoirudin', 0, 0, 0, 'Pindah'),
(167, 'Erlista Wijayanti', 'Sidoarjo, 31 Mei 2014 ', 'Perumahan Anggun Sejahtera Rem', 'Erwan Nuryadi', 0, 0, 0, ''),
(168, 'Audy Ayuwandira Putri A', 'Surabaya, 02 Juni 2012', 'Perumahan Anggun Sejahtera Rem', 'Arisman Budi Arifin', 0, 0, 0, 'Lulus'),
(169, 'Nazriel Ahmad Octyonanda', 'Sidoarjo, 08 Oktober 2016', 'Perumahan Anggun Sejahtera Rem', 'Ahmad Roji', 0, 0, 0, ''),
(170, 'Meysha Keyrananda Ahmad', 'Sidoarjo, 16 Mei 2015', 'Perumahan Anggun Sejahtera Rem', 'Ahmad Roji', 0, 0, 0, ''),
(171, 'Azkia Khansa Syafeera P', 'Jombang, 01 April 2018', 'Perumahan Anggun Sejahtera Rem', 'Sulung Gilang Kurniawan', 0, 0, 0, ''),
(172, 'Sayyidah Ummu Hafshah', 'Surabaya, 12 Oktober 2019', 'Perumahan Anggun Sejahtera Rem', 'M. Shahrul Saleh', 0, 0, 0, 'Keluar'),
(173, 'Qanita Aulia Rahma  ', 'Pasuruan, 26 Mei 2020', 'Perumahan Anggun Sejahtera Rem', 'Mohammad Rif\'an', 0, 0, 0, ''),
(174, 'Naura Alysa Azzahra', 'Pasuruan, 14 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Mukhamad Nasrulloh', 0, 0, 0, 'Keluar'),
(175, 'Ausha Putri fauziah', 'Pasuruan, 28 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Indah Prasetyo Aji', 0, 0, 0, ''),
(176, 'Kaela Filzah Rizdyah N', '26 Agustus 2016', 'Perumahan Anggun Sejahtera Rem', 'M. Rizal', 0, 0, 0, 'Keluar'),
(177, 'M. Azzami Syauqi ', '', 'Perumahan Anggun Sejahtera Rem', 'Moch Sandi', 0, 0, 0, ''),
(178, 'Nadine Pradipta Mubarok', 'Pasuruan, 30 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Mohammad Husnu', 0, 0, 0, 'KELUAR'),
(179, 'Aurora Putri', 'Bondowoso, 11 Maret 2018', 'Perumahan Anggun Sejahtera Rem', 'Rio Aditya Wardana', 0, 0, 0, 'KELUAR'),
(180, 'Muhammad Aimer Shafa\'el', 'Malang, 16 Oktober 2020', 'Perumahan Anggun Sejahtera Rem', 'M. Sylvan Adz Dzikri', 0, 0, 0, 'KELUAR'),
(181, 'Anbar aric Hidayat', 'Surabaya, 23 April 2018', 'Perumahan Anggun Sejahtera Rem', 'Jefry Hidayat Suyudi', 0, 0, 0, ''),
(182, 'Hilya Juvana Magaza', 'Pasuruan, 24 Juli 2018', 'Perumahan Anggun Sejahtera Rem', 'David Bery Mustom', 0, 0, 0, ''),
(183, 'Aileen Nathania Pratiwi', 'Pasuruan, 27 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Fey Eko Prastia', 0, 0, 0, ''),
(184, 'Shakila Nafeeza Azzahra', 'Surabaya, 19 Februari 2017', 'Perumahan Anggun Sejahtera Rem', 'Mulyono', 0, 0, 0, ''),
(185, 'Rafa Ramania Almeta Praja', 'Surabaya, 18 Juli 2011', 'Perumahan Anggun Sejahtera Rem', 'Respati Bayu Praja', 0, 0, 0, ''),
(186, 'Kamayel Araka Wijaya', '', 'Perumahan Anggun Sejahtera Rem', 'Wandha Primartys W', 0, 0, 0, ''),
(187, 'Najwa ', '', 'Perumahan Anggun Sejahtera Rem', ' Rifai', 0, 0, 0, ''),
(188, 'Alesha Syera Sunarno', 'Sidoarjo, 20 Januari 2020', 'Perumahan Anggun Sejahtera Rem', ' Nano Sunarno', 0, 0, 0, ''),
(189, 'Kinanti Aulia Fitriwati', 'Tegal, 12 Mei 2021', 'Perumahan Anggun Sejahtera Rem', 'Sofyan Husain A', 0, 0, 0, ''),
(190, 'Safa Aulia Ul Haq', 'Surabaya, 13 November 2014', 'Perumahan Anggun Sejahtera Rem', 'Suwardi', 0, 0, 0, ''),
(191, 'Annasya Adreena Suwisitiyo', 'Surabaya, 29 Januari 2020', 'Perumahan Anggun Sejahtera Rem', ' Denny Jefri Sudarja', 0, 0, 0, ''),
(192, 'Al Faruq Aradhana Suwisitiyo', 'Surabaya, 11 Mei 2018', 'Perumahan Anggun Sejahtera Rem', ' Denny Jefri Sudarja', 0, 0, 0, ''),
(193, 'Fathah Irsyad Maulana Rezky', 'Surabaya, 08 Mei 2011', 'Perumahan Anggun Sejahtera Rem', 'Rudi Rukimin', 0, 0, 0, ''),
(194, 'Elvinur Nabila Fitri', 'Surabaya, 29 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Eko Wantoro', 0, 0, 0, ''),
(195, 'Elvanur Nabila Fitira', 'Surabaya, 29 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Eko Wantoro', 0, 0, 0, ''),
(196, 'Wahyu Ilmi', 'Banyuwangi, 21 Mei 2012', 'Perumahan Anggun Sejahtera Rem', 'Mahfud Sodik', 0, 0, 0, ''),
(197, 'Bayu Sastro Negoro', 'Banyuwangi, 21 Mei 2012', 'Perumahan Anggun Sejahtera Rem', 'Mahfud Sodik', 0, 0, 0, ''),
(198, 'Muhammad Fadlan Ali Firdaus', 'Pasuruan, 07 Mei 2018', 'Perumahan Anggun Sejahtera Rem', 'Qidam Tegar Wardhana', 0, 0, 0, ''),
(199, 'Muhammad Syabil Aufa', 'Pasuruan, 17 Desember 2013', 'Perumahan Anggun Sejahtera Rem', 'Muhammad Rif’an', 0, 0, 0, ''),
(200, 'Syahwa Delisha Arayah', 'Surabaya, 28 Februari 2015', 'Perumahan Anggun Sejahtera Rem', 'Moch Adi Ayani', 0, 0, 0, ''),
(201, 'M. Azka Aldirick', 'Surabaya, 03 Maret 2014', 'Perumahan Anggun Sejahtera Rem', 'Moch Adi Ayani', 0, 0, 0, ''),
(202, 'Putri Nafisa Zahra', 'Surabaya, 10 Mei 2013', 'Perumahan Anggun Sejahtera Rem', 'Wahyudi', 0, 0, 0, ''),
(203, 'Fairuz Arizqi', 'Surabaya, 20 April 2019', 'Perumahan Anggun Sejahtera Rem', 'Wahyudi', 0, 0, 0, ''),
(204, 'Aisyah Almahyra Cantika', 'Surabaya, 15 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Muchamad Choirun', 0, 0, 0, ''),
(205, 'Aira Zara Pratama', 'Bangkalan, 27 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Budi Putra Pratama', 0, 0, 0, ''),
(206, 'Shanum Benazir', 'Pasuruan, 30 Oktober 2020', 'Perumahan Anggun Sejahtera Rem', 'Ody Reza', 0, 0, 0, ''),
(207, 'Zaidan Al Hafidz', 'Malang, 13 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Abiey Rahmat Wijaya', 0, 0, 0, ''),
(208, 'Ayra Haadzaa Min Fadlillaah', 'Sidoarjo, 26 Februari 2020', 'Perumahan Anggun Sejahtera Rem', 'Endra Budi Irawanto', 0, 0, 0, ''),
(209, 'Ayrin Angel Lica Liliana Rahmawan', 'Lumajang, 18 Agustus 2013', 'Perumahan Anggun Sejahtera Rem', '', 0, 0, 0, ''),
(210, 'Shavira Azkadina Setiawan', 'Pasuruan, 2 Maret 2020', 'Perumahan Anggun Sejahtera Rem', 'Agus Setiawan', 0, 0, 0, ''),
(211, 'Kalistha Azri Setiawati', 'Pasuruan, 5 Juli 2015', 'Perumahan Anggun Sejahtera Rem', 'Agus Setiawan', 0, 0, 0, ''),
(212, 'Muhammad Rafisqi Zade Arraihan', 'Pasuruan 20 Juli 2021', 'Perumahan Anggun Sejahtera Rem', 'Muhammad Anang Zainudin', 0, 0, 0, ''),
(213, 'Aishwa Nahla Azzahra', 'Surabaya, 13 Januari 2021', 'Perumahan Anggun Sejahtera Rem', 'Zakaria', 0, 0, 0, ''),
(214, 'Gempita Noura Azzahra', 'Pasuruan, 14 Februari 2022', 'Perumahan Anggun Sejahtera Rem', 'Laksono Rahmat Putranto', 0, 0, 0, ''),
(215, 'Muhammad Uwais Al-Qorni', 'Sampang, 12 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Mohammad Bayhet', 0, 0, 0, ''),
(216, 'Langit Wahyu Raffasya', 'Surabaya, 24 Agustus 2020', 'Perumahan Anggun Sejahtera Rem', 'Aziz Sumantri', 0, 0, 0, ''),
(217, 'Hilyatun Nafisah Ramadhani', 'Pasuruan, 15 April 2022', 'Perumahan Anggun Sejahtera Rem', 'Muhammad Sefrizal', 0, 0, 0, ''),
(218, 'Ashfiyah Nuril Chusna', 'Sidarjo, 14 Juli 2021', 'Perumahan Anggun Sejahtera Rem', 'Endra Budi Irawanto', 0, 0, 0, ''),
(0, 'Nama ', 'Tempat_tanggal_lahir', 'Alamat', 'Nama_orang_tua', 0, 0, 0, 'Keterangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(5) DEFAULT NULL,
  `isi_soal` varchar(100) DEFAULT NULL,
  `jawaban` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id_ujian` int(5) DEFAULT NULL,
  `Tanggal_ujian` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
