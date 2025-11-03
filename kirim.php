<?php
/**
 * Ini adalah script PHP sederhana untuk memproses formulir.
 * Script ini didesain untuk bekerja dengan 'validate.js' dari template BootstrapMade.
 */

// Cek apakah data dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. UBAH INI: Masukkan alamat email tujuan Anda
    $tujuan_email = "tpqroudlotulilmirembang@gmail.com";

    // 2. Ambil data dari formulir dan bersihkan
    $nama_santri = strip_tags(trim($_POST["nama_santri"]));
    $nama_ortu = strip_tags(trim($_POST["nama_ortu"]));
    $no_hp = strip_tags(trim($_POST["no_hp"]));
    $tgl_lahir = strip_tags(trim($_POST["tgl_lahir"]));
    $alamat = strip_tags(trim($_POST["alamat"]));
    $pesan = strip_tags(trim($_POST["pesan"]));

    // 3. Validasi data (cek jika kolom wajib kosong)
    if (empty($nama_santri) OR empty($nama_ortu) OR empty($no_hp) OR empty($alamat)) {
        // Jika ada data wajib yang kosong, kirim respon error
        http_response_code(400);
        echo "Data tidak lengkap. Silakan isi semua kolom yang wajib diisi.";
        exit;
    }

    // 4. Susun isi (body) email yang akan dikirim
    $subject = "Pendaftaran Santri Baru: $nama_santri";
    
    $body = "Ada pendaftaran santri baru melalui website TPQ Roudlotul Ilmi:\n\n";
    $body .= "=================================\n";
    $body .= "Nama Santri: $nama_santri\n";
    $body .= "Nama Ortu/Wali: $nama_ortu\n";
    $body .= "No. HP/WA: $no_hp\n";
    $body .= "Tgl. Lahir: $tgl_lahir\n";
    $body .= "Alamat: \n$alamat\n\n";
    $body .= "Pesan Tambahan: \n$pesan\n";
    $body .= "=================================\n";

    // 5. Susun header email
    // Ganti 'noreply@domain-website-anda.com' saat Anda sudah punya hosting asli
    $headers = "From: Website TPQ <noreply@website-tpq.com>\r\n";
    $headers .= "Reply-To: $no_hp\r\n"; // Memudahkan Anda membalas ke nomor HP (atau email jika ada)

    // 6. Kirim email
    if (mail($tujuan_email, $subject, $body, $headers)) {
        // Jika email berhasil terkirim, kirim respon "OK"
        http_response_code(200);
        // Script 'validate.js' akan menangkap "OK" ini dan menampilkan pesan sukses
        echo "OK"; 
    } else {
        // Jika email gagal terkirim (masalah server)
        http_response_code(500);
        echo "Gagal mengirim pendaftaran. Terjadi masalah pada server kami.";
    }

} else {
    // Jika file 'kirim.php' diakses langsung (bukan via form)
    http_response_code(403);
    echo "Dilarang mengakses halaman ini secara langsung.";
}
?>