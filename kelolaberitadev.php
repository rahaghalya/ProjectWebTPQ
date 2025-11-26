<?php
session_start();
include 'headerdev.php'; // Sertakan Header

// --- PENTING: Sesi Admin ---
/*
if (empty($_SESSION['admin_username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!');
    window.location.href='login_admin.php';</script>";
    exit;
}
*/

$upload_dir = 'assets/img/berita/';

// =================================================================
// --- LOGIKA BACKEND (CREATE, UPDATE, DELETE) ---
// =================================================================

// --- 1. PROSES TAMBAH BERITA (CREATE) ---
if (isset($_POST['simpan_berita'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    // $isi dihapus
    $tanggal = date('Y-m-d H:i:s');

    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_unik = time() . '_' . $gambar_nama;
    $target_file = $upload_dir . $gambar_unik;

    if (move_uploaded_file($gambar_tmp, $target_file)) {
        // Query disesuaikan, 'isi_berita' dihapus
        $query_insert = "INSERT INTO tabel_berita (judul_berita, gambar_berita, tanggal_upload) 
                         VALUES ('$judul', '$gambar_unik', '$tanggal')";

        $result_insert = mysqli_query($koneksi, $query_insert);

        if ($result_insert) {
            header('Location: kelolaberitadev.php?status=tambah_sukses');
        } else {
            header('Location: kelolaberitadev.php?status=tambah_gagal');
        }
    } else {
        header('Location: kelolaberitadev.php?status=upload_gagal');
    }
    exit;
}

// --- 2. PROSES UPDATE BERITA (UPDATE) ---
if (isset($_POST['update_berita'])) {
    $id_berita = $_POST['id_berita'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    // $isi dihapus
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_nama = $_FILES['gambar']['name'];

    if (!empty($gambar_nama)) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_unik = time() . '_' . $gambar_nama;
        $target_file = $upload_dir . $gambar_unik;

        if (move_uploaded_file($gambar_tmp, $target_file)) {
            if (file_exists($upload_dir . $gambar_lama)) {
                unlink($upload_dir . $gambar_lama);
            }
            // Query update disesuaikan, 'isi_berita' dihapus
            $query_update = "UPDATE tabel_berita SET 
                                judul_berita = '$judul', 
                                gambar_berita = '$gambar_unik' 
                             WHERE id_berita = '$id_berita'";
        }
    } else {
        // Query update disesuaikan, 'isi_berita' dihapus
        $query_update = "UPDATE tabel_berita SET 
                            judul_berita = '$judul'
                         WHERE id_berita = '$id_berita'";
    }

    $result_update = mysqli_query($koneksi, $query_update);

    if ($result_update) {
        header('Location: kelolaberitadev.php?status=update_sukses');
    } else {
        header('Location: kelolaberitadev.php?status=update_gagal');
    }
    exit;
}

// --- 3. PROSES HAPUS BERITA (DELETE) ---
if (isset($_GET['hapus_id'])) {
    // (Logika Hapus tidak berubah)
    $id_berita = $_GET['hapus_id'];

    $query_select = "SELECT gambar_berita FROM tabel_berita WHERE id_berita = '$id_berita'";
    $result_select = mysqli_query($koneksi, $query_select);
    $data_gambar = mysqli_fetch_assoc($result_select);
    $gambar_lama = $data_gambar['gambar_berita'];

    if (file_exists($upload_dir . $gambar_lama)) {
        unlink($upload_dir . $gambar_lama);
    }

    $query_delete = "DELETE FROM tabel_berita WHERE id_berita = '$id_berita'";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        header('Location: kelolaberitadev.php?status=hapus_sukses');
    } else {
        header('Location: kelolaberitadev.php?status=hapus_gagal');
    }
    exit;
}
?>

<style>
    .table img {
        max-width: 150px;
        height: auto;
        border-radius: 5px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }
</style>

<div class="container mt-5">
    <h2 class="mb-4">📰 Manajemen Berita</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="bi bi-plus-circle"></i> Tambah Berita Baru
    </button>

    <?php
    if (isset($_GET['status'])) {
        // (Logika notifikasi tidak berubah)
        $status = $_GET['status'];
        if ($status == 'tambah_sukses') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Berita baru telah ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } elseif ($status == 'update_sukses') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Berita telah diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } elseif ($status == 'hapus_sukses') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Berita telah dihapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } elseif (str_contains($status, 'gagal')) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> Terjadi kesalahan. Silakan coba lagi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    }
    ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Daftar Berita</h5>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Judul Berita</th>
                            <th scope="col">Tanggal Upload</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_select_all = "SELECT * FROM tabel_berita ORDER BY tanggal_upload DESC";
                        $result_select_all = mysqli_query($koneksi, $query_select_all);
                        $no = 1;

                        if (mysqli_num_rows($result_select_all) > 0) {
                            while ($data = mysqli_fetch_assoc($result_select_all)) {
                                $id = $data['id_berita'];
                                $judul = $data['judul_berita'];
                                // $isi dihapus
                                $gambar = $data['gambar_berita'];
                                $tanggal = date('d F Y, H:i', strtotime($data['tanggal_upload']));
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><img src="<?php echo $upload_dir . $gambar; ?>" alt="<?php echo $judul; ?>"></td>
                                    <td><?php echo $judul; ?></td>
                                    <td><?php echo $tanggal; ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $id; ?>">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <a href="kelolaberitadev.php?hapus_id=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $id; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?php echo $id; ?>">Edit Berita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="kelolaberitadev.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_berita" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">

                                                    <div class="mb-3">
                                                        <label for="judul_edit" class="form-label">Judul Berita</label>
                                                        <input type="text" class="form-control" id="judul_edit" name="judul" value="<?php echo $judul; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Gambar Saat Ini:</label><br>
                                                        <img src="<?php echo $upload_dir . $gambar; ?>" alt="Gambar saat ini" style="max-width: 200px; margin-bottom: 10px;">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="gambar_edit" class="form-label">Ganti Gambar (Opsional)</label>
                                                        <input class="form-control" type="file" id="gambar_edit" name="gambar">
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="update_berita" class="btn btn-warning">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">Belum ada berita.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="kelolaberitadev.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Berita</ganti>
                            <input class="form-control" type="file" id="gambar" name="gambar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_berita" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Sertakan Footer
include 'footerdev.php';
?>