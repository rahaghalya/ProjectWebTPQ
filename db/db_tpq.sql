-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 10:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tpq`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru_tpq`
--

CREATE TABLE `guru_tpq` (
  `Id_guru` int(3) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `keterangan` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_history` int(5) DEFAULT NULL,
  `skor` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(5) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `username`, `pass`, `role`) VALUES
(1, 'raha', 'raha1234', 'SUPER ADMIN'),
(2, 'adim', '12345', 'admin biasa');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `no_induk` int(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `Tempat_tanggal_lahir` varchar(50) DEFAULT NULL,
  `Alamat` varchar(30) DEFAULT NULL,
  `jilid` varchar(255) NOT NULL,
  `Nama_orang_tua` varchar(50) DEFAULT NULL,
  `NIK` int(20) DEFAULT NULL,
  `NO_KK` int(20) DEFAULT NULL,
  `Tahun_masuk` int(10) DEFAULT NULL,
  `Keterangan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`no_induk`, `nama`, `Tempat_tanggal_lahir`, `Alamat`, `jilid`, `Nama_orang_tua`, `NIK`, `NO_KK`, `Tahun_masuk`, `Keterangan`) VALUES
(1, 'Akhmad Zukhruf Ferdiansyah', 'Surabaya, 27 Februari 2007', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Abdul Jabar', 0, 0, 2020, ''),
(2, 'Puteri Lintang Kinaseh', 'Gresik, 01 Maret 2009', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Moch Sandi', 0, 0, 2024, ''),
(3, 'Livia Luna Azahra', 'Surabaya, 12 Mei 2008', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', 'Eko Budi Mariyanto', 0, 0, 2018, ''),
(7, 'Aka Hasif Rafsyanjani', 'Pasuruan, 25 September 2017', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Achnad Nurrudin', 0, 0, 2025, 'Keluar'),
(8, 'Muhammad Abdul Aziz', 'Pasuruan , 05 Oktober 2017', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Supriadi', 0, 0, 2016, ''),
(9, 'Muhammad Alvin Torikhi', 'PAsuruan, 05 Desember 2016', 'Perumahan Anggun Sejahtera Rem', 'Jilid 5', 'Susilo', 0, 0, 2024, ''),
(10, 'Raisa Aqila Wijaya', 'Malang, 04 September 2013', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', 'Herman Jodhie Wijaya', 0, 0, 2015, ''),
(11, 'Azkadina Clarabella Wijaya', 'Malang, 02 April 2017', 'Perumahan Anggun Sejahtera Rem', 'Jilid 5', 'Herman Jodhie Wijaya', 0, 0, 2011, ''),
(12, 'Kahyla Afsheen Myesha R', 'Malang, 23 Juli 2013', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Lukas Susanto', 0, 0, 2014, ''),
(13, 'M. Arjuna arya Satya Adhiasta Putra Susanto', 'Malang, 20 November 2015', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Lukas Susanto', 0, 0, 2013, ''),
(14, 'Zahirah Azalia Mujahidafillah ', 'Gresik, 12 Januari 2007', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Soetris Dianto', 0, 0, 2015, ''),
(15, 'Zemirah Azaria Mujahidafillah', 'Surabaya, 01 Desember 2011', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Soetris Dianto', 0, 0, 2024, ''),
(16, 'Asisyah Nurul Lathifah ', 'Tulungagung, 28 April 2016', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'David Berry Minton', 0, 0, 2018, ''),
(17, 'Alesha Putri Maulidia', 'Pasuruan,18 Januari 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'waris Maulidi', 0, 0, 2010, ''),
(18, 'Mohammad Dzaky Dzulhilmi', 'Suarabaya, 13 Oktober 2015', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Moch Nasikin', 0, 0, 2018, ''),
(19, 'Vanessa Nadira R', 'Malang, 04 September 2009', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Ferry Wahono S', 0, 0, 2020, ''),
(20, 'Syarfaras Naufal Prasetyo', 'Lebar, 18 April 2012', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Doddy Prasetyo', 0, 0, 2019, ''),
(21, 'Zaskia Manda Saputri', 'Yogyakarta, 12 Januari 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Herito', 0, 0, 2010, ''),
(22, 'Atha Fauzan Mahdafi', 'Malang, 19 November 2012', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', 'Yuli Siswanto', 0, 0, 2016, ''),
(23, 'Rayhan Ramadhan', 'Papua, 18 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Sabdar', 0, 0, 2010, ''),
(24, 'Tyara Amanda ', 'Malang,29 Desember 2012', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Sabdar', 0, 0, 2024, ''),
(25, 'Mutiya Naela Sari', 'Malang, 24 Juli 2016', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Sabdar', 0, 0, 2014, ''),
(26, 'Aisyah Aulia Putri ', 'Pasuruan,21 Oktober 2015', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'Nidi Hidayat', 0, 0, 2021, ''),
(27, 'Mutiara Putri Balqis', 'Sidoarjo,14 Juni 2010', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Heri Israwan', 0, 0, 2023, ''),
(28, 'Zahira Aura Rengganies', 'Surabaya, 27 Maret 2012', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'Heri Israwan', 0, 0, 2011, ''),
(29, 'Annisa Hayfa Zhafira', 'Surabaya,23 Januari 2017', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Lutfi', 0, 0, 2022, ''),
(30, 'Aqiela Firly Mahfiro', 'Sueabaya, 25 Desember 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Eko Budi Mariyanto', 0, 0, 2021, ''),
(31, 'Rizky Putra Fajar ', 'Surabaya,02 Seotember 2012', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Moch Sandi', 0, 0, 2013, ''),
(32, 'Aurelia Hacinta Putri Garay', '23,Desember 2013', '', 'Al-Qur’an', 'M.Johar Nur Zaman', 0, 0, 2010, ''),
(33, 'Sheikha Kirelna Erlynda', '14 Juni 2017', '', 'Tajwid', 'M.Johar Nur Zaman', 0, 0, 2017, ''),
(34, 'Zhian Raffasya Al-Farizqy', 'Pasuruan, 22 Januari 2014', '', 'Jilid 1', 'Altegra Cahyo Arbiyanto', 0, 0, 2014, ''),
(35, 'Afika Agustin Ramadani', 'Pasuruan, 17 Agustus 2012', '', 'Jilid 6', 'Wahyudi Agustrianto', 0, 0, 2023, ''),
(36, 'Whisnu Adi Perwira ', 'Surabaya,14 Januari 2010', '', 'Jilid 3', 'Basuki', 0, 0, 2019, ''),
(37, 'Mutiara Keiko Abdillah ', 'Pasuruan,10 April 2012', '', 'Jilid 2', 'Farid Sukron A', 0, 0, 2013, ''),
(38, 'M. Syarif Afif Abdillah', 'Klaten, 06 Juli 2013', '', 'Jilid 2', 'Farid Sukron A', 0, 0, 2017, ''),
(39, 'Evan Ardiyanto', 'Malang, 09 Juni 2013', '', 'Jilid 3', 'Robin Arif A', 0, 0, 2019, ''),
(40, 'Ciko Putra Nur Herlambang', '', '', 'Jilid 1', 'Heriyanto', 0, 0, 2019, ''),
(41, 'Alvaro Dzaky Nur Heriansyah', '', '', 'Jilid 2', 'Heriyanto', 0, 0, 2013, ''),
(42, 'Aqita Cinta Nur Herlina', '', '', 'Jilid 6', 'Heriyanto', 0, 0, 2014, ''),
(43, 'Tian', '', '', 'Ghorib', '', 0, 0, 2020, ''),
(44, 'Risqi Ramadhan Ardiansyah', '', '', 'Jilid 5', 'Harsono', 0, 0, 2020, ''),
(45, 'Iqbal', '', '', 'Jilid 6', '', 0, 0, 2011, ''),
(46, 'M. Daffa Ridho Alvaro ', 'Surabaya, 28 Mei 2009', '', 'Jilid 3', 'Kikie Prahara', 0, 0, 2018, ''),
(47, 'M. Fadhullah Akbar Alvaro', 'Surabaya,26 Desember 2014', '', 'Al-Qur’an', 'Kikie Prahara', 0, 0, 2018, ''),
(48, 'Stevanny Resya Putri', 'Surabaya,18,januari', '', 'Jilid 6', 'Anton Abdul Ghafur', 0, 0, 2025, ''),
(49, 'Valentino Rossi', 'Surabaya,31 Desember 2014', '', 'Jilid 4', 'A Fahrul Rozy', 0, 0, 2013, ''),
(50, 'Vino Agil Saputra', '', '', 'Jilid 2', 'Indrajid', 0, 0, 2015, ''),
(51, 'Abim Adam Firmansyah', 'Nganjuk ,31 Oktober 2010', '', 'Jilid 6', 'Susanto', 0, 0, 2025, ''),
(52, 'Zora Az-Zahra Kirana', 'Surabaya, 20 November 2012', '', 'Jilid 6', 'Oneas Ari Arofa', 0, 0, 2023, ''),
(53, 'Ilmira Savoury Islamidina', 'Surabaya,24 November 2013', '', 'Jilid 4', 'Oneas Ari Arofa', 0, 0, 2013, ''),
(54, 'Hasan Agung Setiawan', 'Surabaya,28 September 2012', '', 'Jilid 1', 'Budi Harianto', 0, 0, 2020, ''),
(55, 'Abigail Ghania Wijaya', 'Banyuwangi, 10 September 2018', '', 'Al-Qur’an', 'Wandha Primartys Wijaya', 0, 0, 2020, ''),
(56, 'Bilqis', '', '', 'Ghorib', '', 0, 0, 2014, ''),
(57, 'Salma Bafage', '', '', 'Ghorib', 'Ali', 0, 0, 2017, ''),
(58, 'Muhammad Syahrur Roby ', 'PAsuruan, 26 Desember 2010', '', 'Jilid 6', 'Sudurduri', 0, 0, 2016, ''),
(59, 'Daffa Maulana Zidane Al-S', 'Surabaya, 1 Oktober 2010', '', 'Jilid 6', 'Heriadi', 0, 0, 2022, ''),
(60, 'Nandina Zalzabila Ayu W', 'Jember,10 Mei 2013', '', 'Jilid 3', 'Fendik Susanto', 0, 0, 2019, ''),
(61, 'Anandita Keisha Zahra', 'Madiun, 03 Oktober 2015', '', 'Jilid 4', 'Heri Siswanto', 0, 0, 2018, ''),
(62, 'M. Alvin Pratama ', 'Pasuruan,11 Desember 2015', '', 'Jilid 3', 'Muhammad Samsul Arifin', 0, 0, 2025, ''),
(63, 'M. Rafie', '', '', 'Jilid 2', 'Riyantoko', 0, 0, 2014, ''),
(64, 'M. Rafa Azka Ramadhan', 'Lamongan,07 Juli 2015', '', 'Jilid 1', 'Budi Feriyanto', 0, 0, 2017, ''),
(65, 'Jiha Shielu Khumaira ', 'Malang,01 Februari 2015', '', 'Ghorib', 'Totok Harianto', 0, 0, 2016, ''),
(66, 'Dzaki Maulana Ilham ', 'Surabaya, 18 Juli 2009', '', 'Jilid 6', 'Wasis Sumiyanto', 0, 0, 2022, ''),
(67, 'Aliyana Mirzha', 'Pasuruan,10 Juni 2015', '', 'Al-Qur’an', 'Muhammad Faruqi', 0, 0, 2017, ''),
(68, 'Anindya Hikari Assyifa', 'Surabaya, 13 April 20217', '', 'Tajwid', 'M. Acep Bahrudin', 0, 0, 2013, ''),
(69, 'Ragil Putra Maldini', 'Surabaya,06 April 2014', '', 'Jilid 4', 'Andi Susilo', 0, 0, 2019, ''),
(70, 'Adam Zakaria Firmansyah Putra Ariesmanto', '23 Agustus 2013', '', 'Jilid 6', 'Deby Ariesmanto', 0, 0, 2013, ''),
(71, 'Rezky Ramadhan Taufik', 'Sidoarjo,21 Agustus 2009', '', 'Jilid 6', 'Ivan Taufik', 0, 0, 2017, ''),
(72, 'Vicky Handa Antoni', 'Sidoarjo, 23 Oktober 2012', '', 'Jilid 4', 'Anton Cahyono', 0, 0, 2019, ''),
(73, 'Saskia Samha Fauzia', 'Pasuruan,30 Maret 2014', '', 'Jilid 2', 'Rochman Fauzi', 0, 0, 2019, ''),
(74, 'Muhammad Agam El Dzaky', 'Lumajang, 17 Februari 2017', '', 'Ghorib', 'Achmad Mahmudi', 0, 0, 2012, ''),
(75, 'Sakia Ayu El Dzaky', '', '', 'Jilid 1', 'Achmad Mahmudi', 0, 0, 2011, ''),
(76, 'Mieke Khaira Wildha', 'Surakarta, 13 Mei 2017', '', 'Al-Qur’an', 'Miftachul Giri', 0, 0, 2010, 'Pindah Rumah'),
(77, 'Achmad Farid Al-Farizi', 'Surabaya, 08 Desember 2016', '', 'Jilid 4', 'Achmad Faisol', 0, 0, 2025, 'Keluar'),
(78, 'Reyshallah Nurfebian', 'Lamongan, 11 Juli 2012', '', 'Jilid 5', 'Febrianto', 0, 0, 2018, 'Pindah Rumah'),
(79, 'Yanuar Pangestu Fabian', 'Pasuruan, 12 Januari 2017', '', 'Jilid 2', 'Febrianto', 0, 0, 2023, 'Pindah Rumah'),
(80, 'Achmad Fathoni Fatahillah', 'Surabaya, 12 September 2014', '', 'Jilid 5', 'Achmad Faisol', 0, 0, 2021, 'Pindah Rumah'),
(81, 'M. Ibnu Abdul Jabar M.', 'Pasuruan, 22 Januari 2018', '', 'Al-Qur’an', 'Saikhu Roji\'in', 0, 0, 2011, ''),
(82, 'Fiorenza Divya Beby F.', 'Surabaya, 06 Januari 2015', '', 'Jilid 1', 'Ony Yuwanto', 0, 0, 2012, 'Keluar Tanpa Keteran'),
(83, 'Nira Airlangga', 'Pasuruan, 15 Januari 2013', '', 'Jilid 4', 'Nanang Budi Utomo', 0, 0, 2018, 'Keluar'),
(84, 'Arsy Azahra Saula Andrias', 'Sidoarjo, 31 Maret 2017', '', 'Jilid 1', 'Afriandi Johan W.', 0, 0, 2015, 'Keluar'),
(85, 'Zahra Aisyah Marwa A.', 'Jember, 06 April 2013', '', 'Jilid 2', 'Afriandi Johan W.', 0, 0, 2024, 'Keluar'),
(86, 'Janeta Zain Sava Andrias', 'Jember, 13 Juni 2011', '', 'Tajwid', 'Afriandi Johan W.', 0, 0, 2019, 'Keluar'),
(87, 'Adeeva Varisha Afseen', 'Banyuwangi, 08 Juni 2015', '', 'Jilid 3', 'Achmad Nurdiyali S', 0, 0, 2011, 'Keluar'),
(88, 'Adzkia Nadhira Rafana Putri A.', '', '', 'Tajwid', '', 0, 0, 2024, ''),
(89, 'Ardi', '', '', 'Jilid 5', '', 0, 0, 2013, 'Keluar Thn 2020'),
(90, 'Naurinda Muta\'allimah Wibowo', 'Sidoarjo, 24 November 2014', '', 'Tajwid', 'Andik Wibowo', 0, 0, 2015, 'Keluar'),
(91, 'Arka Nalendra Pratama Wibowo', 'Surabaya, 22 April 2010', '', 'Al-Qur’an', 'Andik Wibowo', 0, 0, 2010, ''),
(92, 'Rivaldo Mahardika Putra Pratama', 'Surabaya,27 Maret 20', '', 'Jilid 2', 'Guntur Indra Nata', 0, 0, 2013, ''),
(93, 'Aiko Maezurra Himeka A.P.S', 'SUrabaya,12 Juli 2016', '', 'Al-Qur’an', 'Heriadi', 0, 0, 2011, ''),
(94, 'Zahra ', '', '', 'Jilid 3', '', 0, 0, 2019, ''),
(95, 'Muhammad Jazilul Fawaidh', '', '', 'Jilid 6', 'Widi Hidayat', 0, 0, 2022, ''),
(96, 'Ibrahim', '', '', 'Jilid 2', '', 0, 0, 2010, ''),
(97, 'Shafira Putri Kusuma ', 'Surabaya, 11 Februari 2010', '', 'Tajwid', 'Yusuf Imam Kusuma', 0, 0, 2023, ''),
(98, 'Aisyah Zahra ', 'Surabaya, 28 September 2016', '', 'Tajwid', 'Yusuf Imam Kusuma', 0, 0, 2011, ''),
(99, 'Rafanda Zahra Lituhayu', 'Surabaya, 29 April 2014', '', 'Jilid 5', 'I Prasetya Aji', 0, 0, 2010, ''),
(100, 'Akifa Shakila Nur Sifa ', 'PAsuruan,20 Mei 2016', '', 'Al-Qur’an', 'I Prasetya Aji', 0, 0, 2023, ''),
(101, 'Dannies Akbar Yusuf Calief', 'Malang, 14 Oktober 2013', '', 'Jilid 5', 'Wisnu Yudha Sanjaya', 0, 0, 2012, ''),
(102, 'Salsabila Putri Azahra ', 'Malang, 07 Agustus 2012', '', 'Ghorib', 'Wisnu Yudha Sanjaya', 0, 0, 2013, ''),
(103, 'Muhammad Harsa Pratama ', '', '', 'Tajwid', 'Muhammad Kharisun', 0, 0, 2018, ''),
(104, 'Deswita Aulia Rachma ', 'Surabaya, 30 Desember 2013', '', 'Jilid 2', 'Teguh Mulyo ', 0, 0, 2010, ''),
(105, 'Risty Keyla Noviyanti ', 'Surabaya, 24 November 2011', '', 'Jilid 4', 'Teguh Mulyo ', 0, 0, 2018, ''),
(106, 'Trintanisa Chairunnisa Zahra ', 'Pasuruan,03 Februari 2016', '', 'Jilid 4', 'Sutrisno', 0, 0, 2020, ''),
(107, 'Daviana Fara Azzahra', 'Surabaya, 07 Maret 2014', '', 'Al-Qur’an', 'Agus Waluyo', 0, 0, 2020, ''),
(108, 'Anisa Nur Salsabila', 'Surabaya, 11 Juni 2015', '', 'Jilid 4', 'Agus Waluyo', 0, 0, 2015, ''),
(109, 'Septia Rengganis NAtalia Putri ', 'Surabaya,26 Desember 2009', '', 'Jilid 3', 'Agus Hariyanto', 0, 0, 2021, ''),
(110, 'Adnan Rasya Arrafif', '', '', 'Al-Qur’an', 'Putra', 0, 0, 2019, ''),
(111, 'Zahira Azzahra Fathiyyaturahma', 'Surabaya, 29 April 2013', '', 'Jilid 1', 'Amir Kuswoyo', 0, 0, 2023, ''),
(112, 'Muhammad Aliff Miftahul Fakhri ', 'Surabaya, 20 Desember 2009', '', 'Jilid 6', 'Amir Kuswoyo', 0, 0, 2015, ''),
(113, 'Hafidzah Inara Maheswari', 'Tegal, 5 Februari 2018', '', 'Al-Qur’an', 'Sofyan Husain Achmari Yanto', 0, 0, 2013, ''),
(114, 'Arka Mahadana Hartata Putra ', 'Pasuruan , 13 April 2015', '', 'Jilid 6', 'Prakoso Hadi Hartata', 0, 0, 2025, ''),
(115, 'Raza Aqila Pradipta Romansyah', 'Grobogan,20 Oktober 2011', '', 'Jilid 3', 'Enarko Romansyah ', 0, 0, 2012, ''),
(116, 'Faiqotus Shofa ', 'PAsuruan, 8 Agustus 2015', '', 'Jilid 6', 'Asnawi', 0, 0, 2010, ''),
(117, 'Chandra Kirana Tunggadhewi', 'Kediri, 11 Juni 2012', '', 'Jilid 2', 'Denny Setyawan ', 0, 0, 2021, ''),
(118, 'Aisyah Fadilah Az-zahra', 'Pasuruan, 27 Juni 2018', '', 'Jilid 2', 'Lupi Susanggi', 0, 0, 2017, ''),
(119, 'Afrida Dya Auliyah ', 'Pasuruan, 16 Agustus 2010', '', 'Jilid 1', 'Supri adi', 0, 0, 2010, ''),
(120, 'Rafie Putra Arieyanto', 'Blitar, 11 Januari 2016', '', 'Al-Qur’an', 'Fx Andhi Arieyanto', 0, 0, 2024, ''),
(121, 'Sheryl Azzahra Shahira Yusuf ', 'Pasuruan , 24 Juni 2018', '', 'Jilid 5', 'Yusuf  Zainuri', 0, 0, 2015, ''),
(122, 'Muhmmad Zidane Pradipta Santoso', 'Sidoarjo, 24 Desember 2016', '', 'Ghorib', 'Eko Budi Santoso', 0, 0, 2025, ''),
(123, 'Muhammad Haikal Ramadhan ', 'Sidoarjo,2 Juni 2019', '', 'Jilid 3', 'Arie Ardiansyah', 0, 0, 2021, ''),
(124, 'Galang Faqih Rey Alteza ', 'SUrabaya,26 Juni 2013', '', 'Tajwid', 'Abdul Hafiz', 0, 0, 2024, ''),
(125, 'Nur Ainy Fitria Wati', 'Lumajang, 19 September 2009', '', 'Ghorib', 'M.Nurhayadi', 0, 0, 2013, ''),
(126, 'Agrata Razal Al-amin Al-alim', '', '', 'Jilid 1', 'Dedi Agus Febriyanto', 0, 0, 2018, ''),
(127, 'Felizia Yulaiba Azizi Cantika ', '', '', 'Jilid 2', 'Dedi Agus Febriyanto', 0, 0, 2024, ''),
(128, 'Fareza Juli Alfaro Azami', '', '', 'Jilid 5', 'Dedi Agus Febriyanto', 0, 0, 2023, ''),
(129, 'Arsya', '', '', 'Al-Qur’an', '', 0, 0, 2021, ''),
(130, 'Yudhistira RIski Wiriyawan', '', '', 'Jilid 3', 'Agus Handoko', 0, 0, 2024, ''),
(131, 'Marvel Owen Maulana Raditya ', '', '', 'Jilid 6', 'Aditya Rahman', 0, 0, 2016, ''),
(132, 'Rafanda Athalla Aditya ', '', '', 'Al-Qur’an', 'Aditya Rahman', 0, 0, 2016, ''),
(133, 'Septiano Keisha Raditya ', '', '', 'Jilid 3', 'Aditya Rahman ', 0, 0, 2021, ''),
(134, 'Najwa Seirlin Nuzulia Mubarak', 'Pasuruan, 15 Juli 2014', '', 'Jilid 3', 'Muhammad Husni', 0, 0, 2018, ''),
(135, 'Mukhammad Zidan Pradana', '20 September 2014', '', 'Tajwid', 'Alm.Nurul Yatim', 0, 0, 2014, ''),
(136, 'Annindita Putrianto ', 'Surabaya, 11 Juli 2015', '', 'Jilid 1', 'Oska Trianto', 0, 0, 2024, ''),
(137, 'Muhammad ', '', '', 'Al-Qur’an', '', 0, 0, 2019, ''),
(138, 'Ayyash Djava Putra Nurhadi', 'Jember, 13 Juni 2011', '', 'Jilid 6', '', 0, 0, 2016, ''),
(139, 'Hanifah Indah Ardiyanti ', 'PAsuruan, 31 Juli 2015', '', 'Jilid 2', 'M. Yusuf', 0, 0, 2011, ''),
(140, 'khadijah', '', '', 'Al-Qur’an', '', 0, 0, 2013, ''),
(141, 'Ainayya Fitria Putri Nurhadi', 'Jember, 05 Juli 2016', '', 'Jilid 4', '', 0, 0, 2010, ''),
(142, 'Kafha Revan El Fatih', 'Sidoarjo, 28 September 2016', '', 'Tajwid', 'Fajirul Anam', 0, 0, 2014, ''),
(143, 'Asmarahayu Wirawan', 'Jambi, 30 September ', '', 'Al-Qur’an', 'Arya Wirawan', 0, 0, 2018, ''),
(144, 'Radelia Qurrota Ayuni', 'Malang, 13 Oktober 2011', '', 'Jilid 6', 'Afif Usnan', 0, 0, 2019, ''),
(145, 'Raiqa Ayeshanata Firmansyah ', 'Surabaya, 21 mei 2019', '', 'Tajwid', 'Pujanata Wahyu Firmansyah ', 0, 0, 2019, ''),
(146, 'Nabeel IbrahimKuddah', 'Sampang, 15 Mei 2020', '', 'Jilid 4', 'Ibrahim Djakfar Kuddah', 0, 0, 2010, ''),
(147, 'Abdul Latif Saputra ', 'Pasuruan,18 September 2018', '', 'Jilid 6', 'M. Yusuf', 0, 0, 2018, ''),
(148, 'Alecia Naura Vahrudin ', 'Surabaya,05 Juli 2017', '', 'Tajwid', 'Johan Vahrudin', 0, 0, 2015, ''),
(149, 'Azka Cio Naufal Al Farizi', 'Surabaya, 12 September 2013', '', 'Jilid 3', 'Johan Vahrudin', 0, 0, 2015, ''),
(150, 'M. Maulana Yusuf Habibullah ', 'Surabaya, 08 Januari 2015`', '', 'Al-Qur’an', 'Zariya', 0, 0, 2019, ''),
(151, 'M. Hafiz Rizqi Ramadhan', 'Surabya, 23 Juni 2017', '', 'Tajwid', 'Zakaria', 0, 0, 2023, ''),
(152, 'Kayla Eka Putri Kriswanto', 'Sidoarjo, 04 Desember 2008', '', 'Jilid 5', 'Hengky Kriswanto', 0, 0, 2017, 'Keluar'),
(153, 'Aurel Putri Ramadhani Kriswanto', 'Sidoarjo 01 September 2010', '', 'Jilid 1', 'Hengky Kriswanto', 0, 0, 2024, 'Keluar'),
(154, 'Ahmad Gusti Annizzar\'', 'Surabaya. 02 Agustus 2013', '', 'Jilid 6', 'Mochamamad Irfan', 0, 0, 2025, ''),
(155, 'Humaira Rasya Nurdiansyah', 'Sidoarjo. 27 Mei 2018', '', 'Ghorib', 'Nurdin Alamsyah', 0, 0, 2013, 'Keluar'),
(156, 'Brian Ega Pratama Riyanto', 'Surabaya, 21 Mei 2010', '', 'Al-Qur’an', 'Surianto', 0, 0, 2011, 'Keluar'),
(157, 'Harir Husna', 'Surabya, 25 Maret 2016', '', 'Ghorib', 'Muhammad Yasir', 0, 0, 2022, 'Keluar'),
(158, 'Queensha Vindy Meiqhaela', 'Sidoarjo, 21 Mei 2013', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Andi Sarial', 0, 0, 2020, 'Keluar'),
(159, 'Ahmad Fatih Syamsudin', 'Pasuruan, 14 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Abu samsudin', 0, 0, 2024, 'Keluar'),
(160, 'Al-Fatih Akbar Rizki A', 'Malang, 8 Juli 2017', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Nugroho Rizki E.', 0, 0, 2018, 'Keluar'),
(161, 'Anandya Putri Kirana', 'Pasuruan 18 Maret 2020', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Laksono Rahmat P', 0, 0, 2010, 'Keluar'),
(162, 'Shazfa Ohafania A', 'Lumajang, 1 Mei 2018', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Susanto', 0, 0, 2017, ''),
(163, 'Najwa Azka Alya Putri', 'Pasuruan, 4 Juli 2019', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Abdul Jabar', 0, 0, 2014, ''),
(164, 'Arsyila Chavia Humaira', 'Surabaya, 23 November 2019', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'M. Chaninul', 0, 0, 2010, ''),
(165, 'Tiger Ghazalii Putra', 'Bondowoso, 15 April 2015', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Rio Aditya Wardana', 0, 0, 2013, 'Keluar'),
(166, 'Adelia Fairuz Zafirah P', 'Malang, 23 Februari 2014', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Ahmad Khoirudin', 0, 0, 2010, 'Pindah'),
(167, 'Erlista Wijayanti', 'Sidoarjo, 31 Mei 2014 ', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Erwan Nuryadi', 0, 0, 2016, ''),
(168, 'Audy Ayuwandira Putri A', 'Surabaya, 02 Juni 2012', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Arisman Budi Arifin', 0, 0, 2025, 'Lulus'),
(169, 'Nazriel Ahmad Octyonanda', 'Sidoarjo, 08 Oktober 2016', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Ahmad Roji', 0, 0, 2020, ''),
(170, 'Meysha Keyrananda Ahmad', 'Sidoarjo, 16 Mei 2015', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Ahmad Roji', 0, 0, 2016, ''),
(171, 'Azkia Khansa Syafeera P', 'Jombang, 01 April 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Sulung Gilang Kurniawan', 0, 0, 2011, ''),
(172, 'Sayyidah Ummu Hafshah', 'Surabaya, 12 Oktober 2019', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'M. Shahrul Saleh', 0, 0, 2015, 'Keluar'),
(173, 'Qanita Aulia Rahma  ', 'Pasuruan, 26 Mei 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Mohammad Rif\'an', 0, 0, 2013, ''),
(174, 'Naura Alysa Azzahra', 'Pasuruan, 14 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', 'Mukhamad Nasrulloh', 0, 0, 2011, 'Keluar'),
(175, 'Ausha Putri fauziah', 'Pasuruan, 28 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Indah Prasetyo Aji', 0, 0, 2025, ''),
(176, 'Kaela Filzah Rizdyah N', '26 Agustus 2016', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'M. Rizal', 0, 0, 2018, 'Keluar'),
(177, 'M. Azzami Syauqi ', '', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Moch Sandi', 0, 0, 2022, ''),
(178, 'Nadine Pradipta Mubarok', 'Pasuruan, 30 Desember 2018', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Mohammad Husnu', 0, 0, 2016, 'KELUAR'),
(179, 'Aurora Putri', 'Bondowoso, 11 Maret 2018', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Rio Aditya Wardana', 0, 0, 2018, 'KELUAR'),
(180, 'Muhammad Aimer Shafa\'el', 'Malang, 16 Oktober 2020', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'M. Sylvan Adz Dzikri', 0, 0, 2018, 'KELUAR'),
(181, 'Anbar aric Hidayat', 'Surabaya, 23 April 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Jefry Hidayat Suyudi', 0, 0, 2011, ''),
(182, 'Hilya Juvana Magaza', 'Pasuruan, 24 Juli 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'David Bery Mustom', 0, 0, 2022, ''),
(183, 'Aileen Nathania Pratiwi', 'Pasuruan, 27 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Fey Eko Prastia', 0, 0, 2020, ''),
(184, 'Shakila Nafeeza Azzahra', 'Surabaya, 19 Februari 2017', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Mulyono', 0, 0, 2024, ''),
(185, 'Rafa Ramania Almeta Praja', 'Surabaya, 18 Juli 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Respati Bayu Praja', 0, 0, 2019, ''),
(186, 'Kamayel Araka Wijaya', '', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'Wandha Primartys W', 0, 0, 2015, ''),
(187, 'Najwa ', '', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', ' Rifai', 0, 0, 2021, ''),
(188, 'Alesha Syera Sunarno', 'Sidoarjo, 20 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', ' Nano Sunarno', 0, 0, 2021, ''),
(189, 'Kinanti Aulia Fitriwati', 'Tegal, 12 Mei 2021', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Sofyan Husain A', 0, 0, 2018, ''),
(190, 'Safa Aulia Ul Haq', 'Surabaya, 13 November 2014', 'Perumahan Anggun Sejahtera Rem', 'Jilid 5', 'Suwardi', 0, 0, 2015, ''),
(191, 'Annasya Adreena Suwisitiyo', 'Surabaya, 29 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', ' Denny Jefri Sudarja', 0, 0, 2013, ''),
(192, 'Al Faruq Aradhana Suwisitiyo', 'Surabaya, 11 Mei 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', ' Denny Jefri Sudarja', 0, 0, 2011, ''),
(193, 'Fathah Irsyad Maulana Rezky', 'Surabaya, 08 Mei 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Rudi Rukimin', 0, 0, 2021, ''),
(194, 'Elvinur Nabila Fitri', 'Surabaya, 29 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Eko Wantoro', 0, 0, 2014, ''),
(195, 'Elvanur Nabila Fitira', 'Surabaya, 29 Agustus 2011', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Eko Wantoro', 0, 0, 2015, ''),
(196, 'Wahyu Ilmi', 'Banyuwangi, 21 Mei 2012', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Mahfud Sodik', 0, 0, 2023, ''),
(197, 'Bayu Sastro Negoro', 'Banyuwangi, 21 Mei 2012', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Mahfud Sodik', 0, 0, 2014, ''),
(198, 'Muhammad Fadlan Ali Firdaus', 'Pasuruan, 07 Mei 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Qidam Tegar Wardhana', 0, 0, 2021, ''),
(199, 'Muhammad Syabil Aufa', 'Pasuruan, 17 Desember 2013', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Muhammad Rif’an', 0, 0, 2023, ''),
(200, 'Syahwa Delisha Arayah', 'Surabaya, 28 Februari 2015', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Moch Adi Ayani', 0, 0, 2024, ''),
(201, 'M. Azka Aldirick', 'Surabaya, 03 Maret 2014', 'Perumahan Anggun Sejahtera Rem', 'Tajwid', 'Moch Adi Ayani', 0, 0, 2012, ''),
(202, 'Putri Nafisa Zahra', 'Surabaya, 10 Mei 2013', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Wahyudi', 0, 0, 2011, ''),
(203, 'Fairuz Arizqi', 'Surabaya, 20 April 2019', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Wahyudi', 0, 0, 2023, ''),
(204, 'Aisyah Almahyra Cantika', 'Surabaya, 15 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Muchamad Choirun', 0, 0, 2011, ''),
(205, 'Aira Zara Pratama', 'Bangkalan, 27 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Budi Putra Pratama', 0, 0, 2023, ''),
(206, 'Shanum Benazir', 'Pasuruan, 30 Oktober 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Ody Reza', 0, 0, 2025, ''),
(207, 'Zaidan Al Hafidz', 'Malang, 13 Januari 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 2', 'Abiey Rahmat Wijaya', 0, 0, 2013, ''),
(208, 'Ayra Haadzaa Min Fadlillaah', 'Sidoarjo, 26 Februari 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 6', 'Endra Budi Irawanto', 0, 0, 2013, ''),
(209, 'Ayrin Angel Lica Liliana Rahmawan', 'Lumajang, 18 Agustus 2013', 'Perumahan Anggun Sejahtera Rem', 'Jilid 5', '', 0, 0, 2015, ''),
(210, 'Shavira Azkadina Setiawan', 'Pasuruan, 2 Maret 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Agus Setiawan', 0, 0, 2012, ''),
(211, 'Kalistha Azri Setiawati', 'Pasuruan, 5 Juli 2015', 'Perumahan Anggun Sejahtera Rem', 'Ghorib', 'Agus Setiawan', 0, 0, 2021, ''),
(212, 'Muhammad Rafisqi Zade Arraihan', 'Pasuruan 20 Juli 2021', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Muhammad Anang Zainudin', 0, 0, 2012, ''),
(213, 'Aishwa Nahla Azzahra', 'Surabaya, 13 Januari 2021', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Zakaria', 0, 0, 2021, ''),
(214, 'Gempita Noura Azzahra', 'Pasuruan, 14 Februari 2022', 'Perumahan Anggun Sejahtera Rem', 'Jilid 3', 'Laksono Rahmat Putranto', 0, 0, 2011, ''),
(215, 'Muhammad Uwais Al-Qorni', 'Sampang, 12 Februari 2018', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'Mohammad Bayhet', 0, 0, 2016, ''),
(216, 'Langit Wahyu Raffasya', 'Surabaya, 24 Agustus 2020', 'Perumahan Anggun Sejahtera Rem', 'Jilid 1', 'Aziz Sumantri', 0, 0, 2021, ''),
(217, 'Hilyatun Nafisah Ramadhani', 'Pasuruan, 15 April 2022', 'Perumahan Anggun Sejahtera Rem', 'Jilid 4', 'Muhammad Sefrizal', 0, 0, 2013, ''),
(218, 'Ashfiyah Nuril Chusna', 'Sidarjo, 14 Juli 2021', 'Perumahan Anggun Sejahtera Rem', 'Al-Qur’an', 'Endra Budi Irawanto', 0, 0, 2011, ''),
(0, 'Nama ', 'Tempat_tanggal_lahir', 'Alamat', 'Jilid 3', 'Nama_orang_tua', 0, 0, 2023, 'Keterangan');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(5) DEFAULT NULL,
  `isi_soal` varchar(100) DEFAULT NULL,
  `jawaban` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_berita`
--

CREATE TABLE `tabel_berita` (
  `id_berita` int(3) NOT NULL,
  `judul_berita` varchar(11) NOT NULL,
  `gambar_berita` varchar(225) NOT NULL,
  `tanggal_upload` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id_ujian` int(5) DEFAULT NULL,
  `Tanggal_ujian` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru_tpq`
--
ALTER TABLE `guru_tpq`
  ADD PRIMARY KEY (`Id_guru`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  ADD PRIMARY KEY (`id_berita`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
