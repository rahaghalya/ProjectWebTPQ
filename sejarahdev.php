<?php
ob_start();
include 'headerdev.php';

if (!isset($koneksi)) {
    echo "<div class='alert alert-danger'>Variabel \$koneksi tidak ditemukan. Cek headerdev.php Anda.</div>";
}

$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

// --- LOGIKA PHP (TIDAK BERUBAH) ---
if (isset($_POST['simpan'])) {
    $tahun = $_POST['tahun'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $nama_file_unik = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "assets/img/sejarah/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_extension = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $nama_file_unik = "sejarah-" . time() . "." . $file_extension;
        $target_file = $target_dir . $nama_file_unik;
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_extension, $allowed)) {
            if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $_SESSION['pesan_error'] = "Gagal upload gambar.";
                echo "<script>window.location='sejarahdev.php?act=tambah';</script>";
                exit;
            }
        }
    }
    $stmt = $koneksi->prepare("INSERT INTO sejarah (tahun, judul, deskripsi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $tahun, $judul, $deskripsi, $nama_file_unik);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil ditambahkan.";
    else $_SESSION['pesan_error'] = "Gagal: " . $stmt->error;
    $stmt->close();
    echo "<script>window.location='sejarahdev.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tahun = $_POST['tahun'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar_lama = $_POST['gambar_lama'];
    $nama_gambar_baru = $gambar_lama;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "assets/img/sejarah/";
        $file_extension = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $nama_file_unik = "sejarah-" . time() . "." . $file_extension;
        $target_file = $target_dir . $nama_file_unik;
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_extension, $allowed)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $nama_gambar_baru = $nama_file_unik;
                if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) unlink($target_dir . $gambar_lama);
            }
        }
    }
    $stmt = $koneksi->prepare("UPDATE sejarah SET tahun=?, judul=?, deskripsi=?, gambar=? WHERE id=?");
    $stmt->bind_param("isssi", $tahun, $judul, $deskripsi, $nama_gambar_baru, $id);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil diupdate.";
    else $_SESSION['pesan_error'] = "Gagal update: " . $stmt->error;
    $stmt->close();
    echo "<script>window.location='sejarahdev.php';</script>";
    exit;
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $q = mysqli_query($koneksi, "SELECT gambar FROM sejarah WHERE id='$id'");
    if ($q) {
        $data = mysqli_fetch_assoc($q);
        if ($data && !empty($data['gambar']) && file_exists("assets/img/sejarah/" . $data['gambar'])) {
            unlink("assets/img/sejarah/" . $data['gambar']);
        }
    }
    $stmt = $koneksi->prepare("DELETE FROM sejarah WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil dihapus.";
    else $_SESSION['pesan_error'] = "Gagal menghapus.";
    echo "<script>window.location='sejarahdev.php';</script>";
    exit;
}
$act = $_GET['act'] ?? '';
?>

<main class="main">
    <section class="section">
        <div class="container mt-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">Manajemen Sejarah</h2>
                    <p class="text-muted mb-0">Kelola Jejak Langkah TPQ (Timeline)</p>
                </div>
                <?php if ($act == ''): ?>
                    <a href="?act=tambah" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Sejarah
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($pesan_sukses): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
                    <i class="bi bi-check-circle me-2"></i> <?= $pesan_sukses ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($pesan_error): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0">
                    <i class="bi bi-exclamation-circle me-2"></i> <?= $pesan_error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php switch ($act):
                case 'tambah': ?>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-4 fw-bold">Tambah Sejarah Baru</h4>
                            <form action="sejarahdev.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2020" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Peristiwa</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Awal Berdiri" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Singkat</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                </div>
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan</button>
                                    <a href="sejarahdev.php" class="btn btn-light border px-4">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php break; ?>

                <?php case 'edit':
                    $id = $_GET['id'];
                    $q = mysqli_query($koneksi, "SELECT * FROM sejarah WHERE id='$id'");
                    $data = mysqli_fetch_assoc($q);
                ?>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-4 fw-bold">Edit Data Sejarah</h4>
                            <form action="sejarahdev.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="<?= $data['tahun'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul</label>
                                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                         <?php if (!empty($data['gambar'])): ?>
                                            <label class="form-label d-block fw-bold">Gambar Saat Ini</label>
                                            <img src="assets/img/sejarah/<?= $data['gambar'] ?>" class="img-thumbnail rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <label class="form-label fw-bold">Ganti Gambar</label>
                                        <input type="file" name="gambar" class="form-control" accept="image/*">
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" name="update" class="btn btn-warning text-white px-4">Update</button>
                                    <a href="sejarahdev.php" class="btn btn-light border px-4">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php break; ?>

                <?php default: ?>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center py-3" width="5%">No</th>
                                            <th class="py-3" width="10%">Tahun</th>
                                            <th class="py-3" width="15%">Gambar</th>
                                            <th class="py-3" width="20%">Judul</th>
                                            <th class="py-3">Deskripsi</th>
                                            <th class="text-center py-3" width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT * FROM sejarah ORDER BY tahun ASC");
                                        $no = 1;
                                        if (mysqli_num_rows($q) > 0) {
                                            while ($r = mysqli_fetch_assoc($q)) {
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><span class="badge bg-light text-dark border"><?= $r['tahun'] ?></span></td>
                                                    <td>
                                                        <?php if (!empty($r['gambar'])): ?>
                                                            <img src="assets/img/sejarah/<?= $r['gambar'] ?>" class="rounded shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                                                        <?php else: ?> 
                                                            <span class="text-muted small">No Image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="fw-bold"><?= htmlspecialchars($r['judul']) ?></td>
                                                    <td class="text-muted small"><?= htmlspecialchars(substr($r['deskripsi'], 0, 80)) ?>...</td>
                                                    <td class="text-center">
                                                        <a href="?act=edit&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                                                        <a href="?act=hapus&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data sejarah.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>

            <?php endswitch; ?>

        </div>
    </section>
</main>

<?php
include 'footerdev.php';
ob_end_flush();
?>