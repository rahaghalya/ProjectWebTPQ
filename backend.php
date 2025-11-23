<?php
// backend.php
// File ini menangani semua logika CRUD (Create, Update, Delete)
// dan permintaan data (Read) dari AJAX (JavaScript).

// 1. Sertakan koneksi database
include 'koneksi.php'; // Mengasumsikan $koneksi ada di sini

// 2. Tentukan header output sebagai JSON
header('Content-Type: application/json');

// 3. Ambil 'action' dari permintaan GET atau POST
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// 4. Inisialisasi array respons
$response = [
    'status' => 'error',
    'message' => 'Aksi tidak diketahui.'
];

// 5. Gunakan 'switch' untuk menangani berbagai aksi
switch ($action) {

    // --- CREATE ---
    case 'tambah':
        // Ambil data dari form POST
        $no_induk = $_POST['no_induk'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $jilid = $_POST['jilid'] ?? '';
        $tahun_masuk = $_POST['tahun_masuk'] ?? date('Y');

        // Validasi sederhana
        if (empty($no_induk) || empty($nama)) {
            $response['message'] = 'No. Induk dan Nama tidak boleh kosong.';
        } else {
            // Gunakan prepared statements untuk keamanan
            $stmt = $koneksi->prepare("INSERT INTO santri (no_induk, nama, Alamat, jilid, Tahun_masuk) VALUES (?, ?, ?, ?, ?)");
            // Hati-hati: Kolom di DB Anda (dari query) adalah 'Alamat' dan 'Tahun_masuk' (kapital)
            $stmt->bind_param("sssss", $no_induk, $nama, $alamat, $jilid, $tahun_masuk);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Data santri berhasil ditambahkan.';
            } else {
                $response['message'] = 'Gagal menambahkan data: ' . $stmt->error;
            }
            $stmt->close();
        }
        break;

    // --- READ (untuk form Edit) ---
    case 'ambil_data':
        $no_induk = $_GET['no_induk'] ?? '';
        
        if (empty($no_induk)) {
            $response['message'] = 'No. Induk tidak ada.';
        } else {
            $stmt = $koneksi->prepare("SELECT no_induk, nama, Alamat, jilid, Tahun_masuk FROM santri WHERE no_induk = ?");
            $stmt->bind_param("s", $no_induk);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($data = $result->fetch_assoc()) {
                $response['status'] = 'success';
                $response['data'] = $data;
                $response['message'] = 'Data berhasil diambil.';
            } else {
                $response['message'] = 'Data tidak ditemukan.';
            }
            $stmt->close();
        }
        break;

    // --- UPDATE ---
    case 'edit':
        // Ambil data dari form POST
        $no_induk_asli = $_POST['no_induk_asli'] ?? '';
        $no_induk = $_POST['no_induk'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $jilid = $_POST['jilid'] ?? '';
        $tahun_masuk = $_POST['tahun_masuk'] ?? '';

        if (empty($no_induk_asli) || empty($no_induk) || empty($nama)) {
            $response['message'] = 'Data tidak lengkap untuk update.';
        } else {
            // Query update
            $stmt = $koneksi->prepare("UPDATE santri SET no_induk = ?, nama = ?, Alamat = ?, jilid = ?, Tahun_masuk = ? WHERE no_induk = ?");
            $stmt->bind_param("ssssss", $no_induk, $nama, $alamat, $jilid, $tahun_masuk, $no_induk_asli);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Data santri berhasil diupdate.';
            } else {
                $response['message'] = 'Gagal mengupdate data: ' . $stmt->error;
            }
            $stmt->close();
        }
        break;

    // --- DELETE ---
    case 'hapus':
        $no_induk = $_POST['no_induk'] ?? '';

        if (empty($no_induk)) {
            $response['message'] = 'No. Induk tidak ada.';
        } else {
            $stmt = $koneksi->prepare("DELETE FROM santri WHERE no_induk = ?");
            $stmt->bind_param("s", $no_induk);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Data santri berhasil dihapus.';
            } else {
                $response['message'] = 'Gagal menghapus data: ' . $stmt->error;
            }
            $stmt->close();
        }
        break;
}

// 6. Tutup koneksi
$koneksi->close();

// 7. Kembalikan respons sebagai JSON
echo json_encode($response);