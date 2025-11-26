<?php
session_start();

// 1. Cek Login Admin (Sesuai tabel 'pengguna')
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// 2. Hubungkan ke Database
include 'koneksi.php';

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 3. Konfigurasi Nama File Download
// Nama file: backup_db_tpq_TANGGAL_JAM.sql
$nama_file = 'backup_db_tpq_' . date("Y-m-d_H-i-s") . '.sql';

// 4. Header HTTP untuk memicu download
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . $nama_file . "\"");

// 5. Mulai Proses Backup
$return = "";

// Header file SQL
$return .= "-- Backup Database TPQ Roudlotul Ilmi\n";
$return .= "-- Waktu Pembuatan: " . date("Y-m-d H:i:s") . "\n";
$return .= "-- Host: localhost\n";
$return .= "-- Database: db_tpq\n\n";
$return .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$return .= "START TRANSACTION;\n";
$return .= "SET time_zone = \"+00:00\";\n\n";

// Ambil daftar semua tabel
$tables = array();
$result = mysqli_query($koneksi, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

// Loop melalui setiap tabel
foreach ($tables as $table) {

    // A. Dapatkan struktur tabel (CREATE TABLE)
    $row2 = mysqli_fetch_row(mysqli_query($koneksi, "SHOW CREATE TABLE " . $table));
    $return .= "\n\n" . "-- --------------------------------------------------------\n";
    $return .= "-- Struktur dari tabel `" . $table . "`\n";
    $return .= "-- --------------------------------------------------------\n\n";
    $return .= "DROP TABLE IF EXISTS `" . $table . "`;\n";
    $return .= $row2[1] . ";\n\n";

    // B. Dapatkan data tabel (INSERT INTO)
    $result = mysqli_query($koneksi, "SELECT * FROM " . $table);
    $num_fields = mysqli_num_fields($result);

    if (mysqli_num_rows($result) > 0) {
        $return .= "-- Dumping data untuk tabel `" . $table . "`\n\n";
        $return .= "INSERT INTO `" . $table . "` VALUES";

        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $return .= ($i == 0) ? "(" : ",(";
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]); // Tambahkan slash pada tanda kutip
                $row[$j] = str_replace("\n", "\\n", $row[$j]); // Handle baris baru

                if (isset($row[$j])) {
                    $return .= '"' . $row[$j] . '"';
                } else {
                    $return .= '""';
                }
                if ($j < ($num_fields - 1)) {
                    $return .= ',';
                }
            }
            $return .= ")";
            $i++;
        }
        $return .= ";\n\n";
    }
}

$return .= "COMMIT;";

// 6. Cetak hasil (akan terdownload oleh browser)
echo $return;
exit;
