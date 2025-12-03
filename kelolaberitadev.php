<?php
session_start();
include 'headerdev.php';

$upload_dir = 'assets/img/berita/';

if (isset($_POST['simpan_berita'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']); 
    $tanggal = date('Y-m-d H:i:s');

    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_unik = time() . '_' . $gambar_nama;
    $target_file = $upload_dir . $gambar_unik;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($gambar_tmp, $target_file)) {
        $query_insert = "INSERT INTO tabel_berita (judul_berita, isi_berita, gambar_berita, tanggal_upload) 
                         VALUES ('$judul', '$isi', '$gambar_unik', '$tanggal')";

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

if (isset($_POST['update_berita'])) {
    $id_berita = $_POST['id_berita'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_nama = $_FILES['gambar']['name'];

    if (!empty($gambar_nama)) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_unik = time() . '_' . $gambar_nama;
        $target_file = $upload_dir . $gambar_unik;

        if (move_uploaded_file($gambar_tmp, $target_file)) {
            if (file_exists($upload_dir . $gambar_lama) && $gambar_lama != '') {
                unlink($upload_dir . $gambar_lama);
            }
            $query_update = "UPDATE tabel_berita SET 
                                judul_berita = '$judul', 
                                isi_berita = '$isi',
                                gambar_berita = '$gambar_unik' 
                             WHERE id_berita = '$id_berita'";
        }
    } else {
        $query_update = "UPDATE tabel_berita SET 
                            judul_berita = '$judul',
                            isi_berita = '$isi'
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

if (isset($_GET['hapus_id'])) {
    $id_berita = $_GET['hapus_id'];

    $query_select = "SELECT gambar_berita FROM tabel_berita WHERE id_berita = '$id_berita'";
    $result_select = mysqli_query($koneksi, $query_select);
    $data_gambar = mysqli_fetch_assoc($result_select);
    $gambar_lama = $data_gambar['gambar_berita'];

    if (file_exists($upload_dir . $gambar_lama) && $gambar_lama != '') {
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
    .img-thumbnail-custom {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>

<div class="container mt-5 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Manajemen Berita</h2>
            <p class="text-muted">Kelola berita dan kegiatan TPQ di sini.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-plus-lg"></i> Tambah Berita
        </button>
    </div>

    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $msg = '';
        $type = '';
        
        if ($status == 'tambah_sukses') { $msg = 'Berita berhasil ditambahkan!'; $type = 'success'; }
        elseif ($status == 'update_sukses') { $msg = 'Berita berhasil diperbarui!'; $type = 'success'; }
        elseif ($status == 'hapus_sukses') { $msg = 'Berita berhasil dihapus!'; $type = 'success'; }
        elseif ($status == 'upload_gagal') { $msg = 'Gagal mengupload gambar!'; $type = 'danger'; }
        else { $msg = 'Terjadi kesalahan!'; $type = 'danger'; }

        echo '<div class="alert alert-'.$type.' alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> '.$msg.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="py-3">Gambar</th>
                            <th class="py-3">Info Berita</th>
                            <th class="py-3">Tanggal</th>
                            <th class="px-4 py-3 text-end">Aksi</th>
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
                                $isi = $data['isi_berita']; 
                                $gambar = $data['gambar_berita'];
                                $tanggal = date('d M Y, H:i', strtotime($data['tanggal_upload']));
                                
                                $cuplikan = substr(strip_tags($isi), 0, 50) . '...';
                        ?>
                                <tr>
                                    <td class="px-4"><?php echo $no++; ?></td>
                                    <td>
                                        <img src="<?php echo $upload_dir . $gambar; ?>" alt="Img" class="img-thumbnail-custom">
                                    </td>
                                    <td>
                                        <h6 class="mb-1 fw-bold"><?php echo $judul; ?></h6>
                                        <small class="text-muted"><?php echo $cuplikan; ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-calendar-event me-1"></i> <?php echo $tanggal; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 text-end">
                                        <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $id; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="kelolaberitadev.php?hapus_id=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Berita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="kelolaberitadev.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_berita" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Judul Berita</label>
                                                        <input type="text" class="form-control" name="judul" value="<?php echo $judul; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Isi Berita</label>
                                                        <textarea class="form-control" name="isi" rows="5" required><?php echo $isi; ?></textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Gambar Saat Ini:</label><br>
                                                            <img src="<?php echo $upload_dir . $gambar; ?>" class="img-fluid rounded border">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="form-label fw-bold mt-3 mt-md-0">Ganti Gambar (Opsional)</label>
                                                            <input class="form-control" type="file" name="gambar">
                                                            <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="update_berita" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center py-5 text-muted">Belum ada berita yang diunggah.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="kelolaberitadev.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul berita..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Berita</label>
                        <textarea class="form-control" name="isi" rows="5" placeholder="Tulis detail berita di sini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Gambar</label>
                        <input class="form-control" type="file" name="gambar" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal ukuran wajar.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_berita" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footerdev.php';
?>