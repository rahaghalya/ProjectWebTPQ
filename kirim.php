<?php
// 1. Memanggil file koneksi.php
include 'koneksi.php';

// 2. Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 3. Mengatur zona waktu dan bahasa
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID');

// 4. Menangkap data dari form
$nama        = mysqli_real_escape_string($koneksi, $_POST['Nama']);
$nama_ortu   = mysqli_real_escape_string($koneksi, $_POST['Nama_orang_tua']);
$tempat_lahir = mysqli_real_escape_string($koneksi, $_POST['Tempat_lahir']);
$tanggal_lahir_raw = mysqli_real_escape_string($koneksi, $_POST['Tanggal_lahir']);
$alamat      = mysqli_real_escape_string($koneksi, $_POST['Alamat']);

// 5. MEMPROSES DATA TANGGAL
$tanggal_formatted = strftime('%d %B %Y', strtotime($tanggal_lahir_raw));
$tempat_tanggal_lahir_final = $tempat_lahir . ", " . $tanggal_formatted;

// 6. MENGISI DATA DEFAULT
$jilid = "Belum Ada"; 
$nik = "0";
$no_kk = "0";
$tahun_masuk = date('Y');
$keterangan = "Aktif";

// 7. BARIS BARU: MENCARI NO_INDUK TERAKHIR SECARA MANUAL
$query_max_id = "SELECT MAX(no_induk) AS id_terbesar FROM santri";
$hasil_max_id = mysqli_query($koneksi, $query_max_id);
$data_max_id = mysqli_fetch_array($hasil_max_id);
$no_induk_baru = $data_max_id['id_terbesar'] + 1;


// 8. Membuat query INSERT
// PERHATIKAN: Kita tambahkan no_induk di sini
$sql = "INSERT INTO santri (
            no_induk,  
            Nama, 
            Tempat_tanggal_lahir, 
            Alamat, 
            jilid, 
            Nama_orang_tua, 
            NIK, 
            NO_KK, 
            Tahun_masuk, 
            Keterangan
        ) VALUES (
            '$no_induk_baru',
            '$nama', 
            '$tempat_tanggal_lahir_final', 
            '$alamat', 
            '$jilid', 
            '$nama_ortu', 
            '$nik', 
            '$no_kk', 
            '$tahun_masuk', 
            '$keterangan'
        )";

// 9. Menjalankan query dan memberikan feedback
if (mysqli_query($koneksi, $sql)) {
    // Jika berhasil
    echo "<script>
            alert('Pendaftaran santri baru atas nama: " . $nama . " berhasil terkirim.');
            window.location.href = 'index.php'; 
          </script>";
} else {
    // Jika gagal, tampilkan error MySQL (penting untuk debugging)
    echo "<script>
            alert('Pendaftaran Gagal: Terjadi error. " . mysqli_error($koneksi) . "');
            window.history.back(); 
          </script>";
}

// 10. Tutup koneksi
mysqli_close($koneksi);

?>