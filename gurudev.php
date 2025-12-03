<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'koneksi.php';

if (!$koneksi) die("Koneksi Database Gagal: " . mysqli_connect_error());

$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

// PARAMETER & FILTER (TIDAK BERUBAH)
$limit = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;
$sort_by = $_GET['sort'] ?? 'nama';
$sort_order = $_GET['order'] ?? 'ASC';
$allowed_sort_columns = ['id_guru', 'nama', 'jabatan', 'keterangan'];
$allowed_orders = ['ASC', 'DESC'];
if (!in_array($sort_by, $allowed_sort_columns)) $sort_by = 'nama';
if (!in_array($sort_order, $allowed_orders)) $sort_order = 'ASC';

$filter_nama = $_GET['filter_nama'] ?? '';
$filter_jabatan = $_GET['filter_jabatan'] ?? '';
$filter_keterangan = $_GET['filter_keterangan'] ?? '';

// LOGIKA CRUD (TIDAK BERUBAH)
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $keterangan = $_POST['keterangan'] ?? 'Aktif';
    if (empty($nama)) { $_SESSION['pesan_error'] = "Nama tidak boleh kosong."; header("Location: gurudev.php?act=tambah"); exit; }
    $path_untuk_database = "";
    if (isset($_FILES['foto_upload']) && $_FILES['foto_upload']['error'] == 0) {
        $folder_tujuan = "assets/img/Guru/";
        if (!file_exists($folder_tujuan)) mkdir($folder_tujuan, 0777, true);
        $nama_file_asli = basename($_FILES['foto_upload']['name']);
        $nama_file_unik = time() . '-' . preg_replace("/[^a-zA-Z0-9.]/", "-", $nama_file_asli);
        $path_tujuan = $folder_tujuan . $nama_file_unik;
        if (move_uploaded_file($_FILES['foto_upload']['tmp_name'], $path_tujuan)) $path_untuk_database = $path_tujuan;
        else { $_SESSION['pesan_error'] = "Gagal upload foto."; header("Location: gurudev.php?act=tambah"); exit; }
    } else { $_SESSION['pesan_error'] = "Foto wajib diupload."; header("Location: gurudev.php?act=tambah"); exit; }
    $stmt = $koneksi->prepare("INSERT INTO guru (nama, jabatan, keterangan, foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $jabatan, $keterangan, $path_untuk_database);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil disimpan.";
    else $_SESSION['pesan_error'] = "Gagal simpan: " . $stmt->error;
    $stmt->close(); header("Location: gurudev.php"); exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_guru_asli'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $keterangan = $_POST['keterangan'];
    $foto_baru_diupload = (isset($_FILES['foto_upload']) && $_FILES['foto_upload']['error'] == 0);

    if (!empty($id)) {
        if ($foto_baru_diupload) {
            $q_cek = $koneksi->prepare("SELECT foto FROM guru WHERE id_guru = ?");
            $q_cek->bind_param("i", $id); $q_cek->execute();
            $data_lama = $q_cek->get_result()->fetch_assoc(); $q_cek->close();

            $folder_tujuan = "assets/img/Guru/";
            if (!file_exists($folder_tujuan)) mkdir($folder_tujuan, 0777, true);
            $nama_file_asli = basename($_FILES['foto_upload']['name']);
            $nama_file_unik = time() . '-' . preg_replace("/[^a-zA-Z0-9.]/", "-", $nama_file_asli);
            $path_tujuan = $folder_tujuan . $nama_file_unik;

            if (move_uploaded_file($_FILES['foto_upload']['tmp_name'], $path_tujuan)) {
                if (!empty($data_lama['foto']) && file_exists($data_lama['foto'])) unlink($data_lama['foto']);
                $stmt = $koneksi->prepare("UPDATE guru SET nama=?, jabatan=?, keterangan=?, foto=? WHERE id_guru=?");
                $stmt->bind_param("ssssi", $nama, $jabatan, $keterangan, $path_tujuan, $id);
            }
        } else {
            $stmt = $koneksi->prepare("UPDATE guru SET nama=?, jabatan=?, keterangan=? WHERE id_guru=?");
            $stmt->bind_param("sssi", $nama, $jabatan, $keterangan, $id);
        }
        if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil diupdate.";
        else $_SESSION['pesan_error'] = "Gagal update: " . $stmt->error;
        $stmt->close();
    }
    header("Location: gurudev.php"); exit;
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $koneksi->prepare("SELECT foto FROM guru WHERE id_guru = ?");
    $stmt->bind_param("i", $id); $stmt->execute();
    $res = $stmt->get_result();
    if ($r = $res->fetch_assoc()) { if (!empty($r['foto']) && file_exists($r['foto'])) unlink($r['foto']); }
    $stmt->close();
    $stmt = $koneksi->prepare("DELETE FROM guru WHERE id_guru = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = "Data berhasil dihapus.";
    else $_SESSION['pesan_error'] = "Gagal hapus: " . $stmt->error;
    $stmt->close(); header("Location: gurudev.php"); exit;
}

// QUERY DATA
$where_cond = []; $params = []; $types = "";
if ($filter_nama) { $where_cond[] = "nama LIKE ?"; $params[] = "%$filter_nama%"; $types .= "s"; }
$where_clause = $where_cond ? "WHERE " . implode(" AND ", $where_cond) : "";
$q_count = "SELECT COUNT(*) as total FROM guru $where_clause";
$stmt = $koneksi->prepare($q_count);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total_data = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);
$stmt->close();
$q_data = "SELECT * FROM guru $where_clause ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";
$stmt_data = $koneksi->prepare($q_data);
$params_lim = $params; $params_lim[] = $limit; $params_lim[] = $offset; $types_lim = $types . "ii";
$stmt_data->bind_param($types_lim, ...$params_lim);
$stmt_data->execute();
$result_tabel = $stmt_data->get_result();

include 'headerdev.php';
$act = $_GET['act'] ?? '';
?>

<main class="main">
    <section class="section">
        <div class="container mt-4">

            <?php if ($pesan_sukses): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3">
                     <i class="bi bi-check-circle me-2"></i> <?= $pesan_sukses ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php switch ($act): 
                case 'tambah': ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold text-dark">Tambah Guru</h2>
                        <a href="gurudev.php" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <form action="gurudev.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan" placeholder="Kepala TPQ, Guru...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-control" name="keterangan">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                        <option value="Cuti">Cuti</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload Foto</label>
                                    <input type="file" class="form-control" name="foto_upload" required>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php break; ?>

                <?php case 'edit':
                    $id = $_GET['id'] ?? 0;
                    $stmt = $koneksi->prepare("SELECT * FROM guru WHERE id_guru = ?");
                    $stmt->bind_param("i", $id); $stmt->execute();
                    $data_edit = $stmt->get_result()->fetch_assoc();
                    if ($data_edit) { ?>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold text-dark">Edit Data Guru</h2>
                            <a href="gurudev.php" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form action="gurudev.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_guru_asli" value="<?= $data_edit['id_guru'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data_edit['nama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" value="<?= htmlspecialchars($data_edit['jabatan']) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <select class="form-control" name="keterangan">
                                            <option value="Aktif" <?= ($data_edit['keterangan'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                            <option value="Nonaktif" <?= ($data_edit['keterangan'] == 'Nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                            <option value="Cuti" <?= ($data_edit['keterangan'] == 'Cuti') ? 'selected' : '' ?>>Cuti</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
                                        <input type="file" class="form-control" name="foto_upload">
                                    </div>
                                    <div class="mb-3">
                                        <?php if (!empty($data_edit['foto']) && file_exists($data_edit['foto'])): ?>
                                            <img src="<?= htmlspecialchars($data_edit['foto']) ?>" class="img-thumbnail rounded" style="width: 100px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" name="update" class="btn btn-warning text-white px-4">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } break; ?>

                <?php default: ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold text-dark">Data Guru</h2>
                            <p class="text-muted mb-0">Manajemen Pengajar TPQ</p>
                        </div>
                        <a href="?act=tambah" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Guru</a>
                    </div>
                    
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <form method="GET" class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label class="col-form-label fw-bold">Cari:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="filter_nama" class="form-control" placeholder="Nama Guru..." value="<?= htmlspecialchars($filter_nama) ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-primary">Search</button>
                                    <a href="gurudev.php" class="btn btn-link text-decoration-none text-muted">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3 px-3"><a href="?sort=id_guru" class="text-dark text-decoration-none">ID</a></th>
                                            <th class="py-3"><a href="?sort=nama" class="text-dark text-decoration-none">Nama Guru</a></th>
                                            <th class="py-3"><a href="?sort=jabatan" class="text-dark text-decoration-none">Jabatan</a></th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3 text-end px-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result_tabel && $result_tabel->num_rows > 0): ?>
                                            <?php while ($row = $result_tabel->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="px-3"><?= htmlspecialchars($row['id_guru']) ?></td>
                                                    <td class="fw-bold"><?= htmlspecialchars($row['nama']) ?></td>
                                                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                                                    <td>
                                                        <?php
                                                        $badge = 'bg-secondary';
                                                        if ($row['keterangan'] == 'Aktif') $badge = 'bg-success';
                                                        elseif ($row['keterangan'] == 'Nonaktif') $badge = 'bg-danger';
                                                        elseif ($row['keterangan'] == 'Cuti') $badge = 'bg-warning text-dark';
                                                        ?>
                                                        <span class="badge <?= $badge ?> rounded-pill"><?= htmlspecialchars($row['keterangan']) ?></span>
                                                    </td>
                                                    <td class="text-end px-3">
                                                        <a href="?act=edit&id=<?= $row['id_guru'] ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                                                        <a href="?act=hapus&id=<?= $row['id_guru'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr><td colspan="5" class="text-center py-5 text-muted">Tidak ada data guru.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($total_pages > 1): ?>
                                <div class="p-3 border-top">
                                    <nav>
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a></li>
                                            <li class="page-item active"><span class="page-link"><?= $page ?></span></li>
                                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php break; ?>
            <?php endswitch; ?>

        </div>
    </section>
</main>
<?php if ($stmt_data) $stmt_data->close(); include 'footerdev.php'; ?>