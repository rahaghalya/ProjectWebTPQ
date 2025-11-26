<?php
// 1. Panggil koneksi (asumsi file ini di folder 'admin')
include '../koneksi.php';

// 2. Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 3. Ambil data TEKS dari formulir
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    // (Tidak ada $deskripsi)

    // 4. Ambil data FILE
    $foto_tmp_name = $_FILES['foto_upload']['tmp_name'];
    $foto_name = $_FILES['foto_upload']['name'];

    // 5. Tentukan folder tujuan (keluar dari 'admin', masuk ke 'assets/img/Guru/')
    $folder_tujuan_server = "../assets/img/Guru/";

    // 6. Buat nama file unik
    $nama_file_unik = time() . '-' . strtolower(str_replace(' ', '-', $foto_name));
    $path_tujuan_server = $folder_tujuan_server . $nama_file_unik;

    // 7. Pindahkan file
    if (move_uploaded_file($foto_tmp_name, $path_tujuan_server)) {

        // --- JIKA UPLOAD FOTO BERHASIL, SIMPAN KE DATABASE ---

        // 8. Siapkan path untuk disimpan di DATABASE
        $path_untuk_database = "assets/img/Guru/" . $nama_file_unik;

        // 9. Siapkan query SQL (TANPA deskripsi)
        $stmt = $koneksi->prepare(
            "INSERT INTO guru_tpq (nama, keterangan, foto) VALUES (?, ?, ?)"
        );

        // 10. "sss" berarti 3 variabel ini bertipe String
        $stmt->bind_param("sss", $nama, $keterangan, $path_untuk_database);

        // 11. Eksekusi query
        if ($stmt->execute()) {
            // Berhasil, kembali ke form
            header("Location: tambah_guru.php?status=sukses");
        } else {
            echo "Gagal menyimpan data ke database: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Gagal meng-upload file foto.";
    }

    $koneksi->close();
} else {
    echo "Akses dilarang.";
}
