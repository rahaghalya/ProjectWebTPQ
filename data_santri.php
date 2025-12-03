<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) session_start();
include 'headerdev.php';
include 'koneksi.php';

$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

$act = $_GET['act'] ?? 'list';
function input_get($k, $default = '') { return isset($_POST[$k]) ? trim($_POST[$k]) : $default; }

// --- LOGIKA CREATE, UPDATE, DELETE ---

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $act === 'create') {
    $q = $koneksi->query("SELECT MAX(no_induk) AS max_id FROM santri");
    $data = $q->fetch_assoc();
    $no_induk = $data['max_id'] ? ((int)$data['max_id'] + 1) : 1;
    $nama = input_get('nama');
    $tempat_tanggal_lahir = input_get('Tempat_tanggal_lahir');
    $alamat = input_get('Alamat');
    $jilid = input_get('jilid');
    $tahun_masuk = (int) input_get('Tahun_masuk');
    $keterangan = input_get('Keterangan', 'Aktif');

    if ($nama === '' || $jilid === '') {
        $_SESSION['pesan_error'] = 'Nama dan Jilid wajib diisi.';
        header('Location: data_santri.php?act=add'); exit;
    }
    $stmt = $koneksi->prepare("INSERT INTO santri (no_induk, nama, Tempat_tanggal_lahir, Alamat, jilid, Tahun_masuk, Keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssis", $no_induk, $nama, $tempat_tanggal_lahir, $alamat, $jilid, $tahun_masuk, $keterangan);
    if ($stmt->execute()) { $_SESSION['pesan_sukses'] = 'Data santri berhasil ditambahkan.'; header('Location: data_santri.php'); exit; }
    else { $_SESSION['pesan_error'] = 'Gagal menambah data: ' . $stmt->error; header('Location: data_santri.php?act=add'); exit; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $act === 'edit') {
    $no_induk = (int) input_get('no_induk');
    $nama = input_get('nama');
    $tempat_tanggal_lahir = input_get('Tempat_tanggal_lahir');
    $alamat = input_get('Alamat');
    $jilid = input_get('jilid');
    $tahun_masuk = (int) input_get('Tahun_masuk');
    $keterangan = input_get('Keterangan', 'Aktif');

    if ($no_induk <= 0 || $nama === '') { $_SESSION['pesan_error'] = 'No Induk tidak valid.'; header('Location: data_santri.php'); exit; }
    $stmt = $koneksi->prepare("UPDATE santri SET nama = ?, Tempat_tanggal_lahir = ?, Alamat = ?, jilid = ?, Tahun_masuk = ?, Keterangan = ? WHERE no_induk = ?");
    $stmt->bind_param("sssissi", $nama, $tempat_tanggal_lahir, $alamat, $jilid, $tahun_masuk, $keterangan, $no_induk);
    if ($stmt->execute()) $_SESSION['pesan_sukses'] = 'Data santri berhasil diperbarui.';
    else $_SESSION['pesan_error'] = 'Gagal update: ' . $stmt->error;
    header('Location: data_santri.php'); exit;
}

if ($act === 'delete' && isset($_GET['no_induk'])) {
    $no_induk = (int) $_GET['no_induk'];
    if ($no_induk > 0) {
        $stmt = $koneksi->prepare("DELETE FROM santri WHERE no_induk = ?");
        $stmt->bind_param('i', $no_induk);
        if ($stmt->execute()) $_SESSION['pesan_sukses'] = 'Data santri berhasil dihapus.';
        else $_SESSION['pesan_error'] = 'Gagal hapus: ' . $stmt->error;
    }
    header('Location: data_santri.php'); exit;
}

// LIST QUERY
$limit = 25;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';
$where_sql = $search !== '' ? "WHERE nama LIKE ? OR Alamat LIKE ? OR jilid LIKE ?" : '';
$like = "%" . $search . "%";

if ($where_sql !== '') {
    $stmtc = $koneksi->prepare("SELECT COUNT(*) as total FROM santri $where_sql");
    $stmtc->bind_param('sss', $like, $like, $like);
    $stmtc->execute();
    $total_data = (int)$stmtc->get_result()->fetch_assoc()['total'];
} else {
    $res_c = $koneksi->query("SELECT COUNT(*) as total FROM santri");
    $total_data = (int)$res_c->fetch_assoc()['total'];
}
$total_pages = max(1, ceil($total_data / $limit));

$sql = "SELECT * FROM santri $where_sql ORDER BY no_induk ASC LIMIT ? OFFSET ?";
if ($where_sql !== '') {
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('ssiii', $like, $like, $like, $limit, $offset);
} else {
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('ii', $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="main">
    <section class="section">
        <div class="container mt-4">

            <?php if ($pesan_sukses): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
                    <i class="bi bi-check-circle me-2"></i> <?= htmlspecialchars($pesan_sukses); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($pesan_error): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3">
                    <i class="bi bi-exclamation-circle me-2"></i> <?= htmlspecialchars($pesan_error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($act === 'add'): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-4 fw-bold">Tambah Santri Baru</h4>
                        <form method="POST" action="data_santri.php?act=create">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat, Tgl Lahir</label>
                                    <input type="text" name="Tempat_tanggal_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <input type="text" name="Alamat" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jilid</label>
                                    <select name="jilid" class="form-select" required>
                                        <option value="1">1</option><option value="2">2</option>
                                        <option value="3">3</option><option value="4">4</option>
                                        <option value="5">5</option><option value="6">6</option>
                                        <option value="ghorib">Ghorib</option><option value="tajwid">Tajwid</option>
                                        <option value="alquran">Al-Quran</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Tahun Masuk</label>
                                    <input type="number" name="Tahun_masuk" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="Keterangan" class="form-select">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary px-4" type="submit">Simpan</button>
                                <a href="data_santri.php" class="btn btn-light border px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($act === 'edit' && isset($_GET['no_induk'])):
                $no = (int) $_GET['no_induk'];
                $stmtE = $koneksi->prepare("SELECT * FROM santri WHERE no_induk = ?");
                $stmtE->bind_param('i', $no); $stmtE->execute();
                $resE = $stmtE->get_result()->fetch_assoc();
            ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-4 fw-bold">Edit Santri</h4>
                        <form method="POST" action="data_santri.php?act=edit">
                            <input type="hidden" name="no_induk" value="<?= $resE['no_induk']; ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($resE['nama']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <input type="text" name="Alamat" class="form-control" value="<?= htmlspecialchars($resE['Alamat']); ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jilid</label>
                                    <select name="jilid" class="form-select">
                                        <?php $opts = ['1', '2', '3', '4', '5', '6', 'ghorib', 'tajwid', 'alquran'];
                                        foreach ($opts as $o) { $sel = ($resE['jilid'] == $o) ? 'selected' : ''; echo "<option value=\"$o\" $sel>$o</option>"; } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="Keterangan" class="form-select">
                                        <option value="Aktif" <?= $resE['Keterangan']=='Aktif'?'selected':''; ?>>Aktif</option>
                                        <option value="Lulus" <?= $resE['Keterangan']=='Lulus'?'selected':''; ?>>Lulus</option>
                                        <option value="Nonaktif" <?= $resE['Keterangan']=='Nonaktif'?'selected':''; ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-warning text-white px-4" type="submit">Update</button>
                                <a href="data_santri.php" class="btn btn-light border px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($act === 'view' && isset($_GET['no_induk'])): 
                // --- BAGIAN INI DIKEMBALIKAN (VIEW DETAIL) ---
                $no = (int) $_GET['no_induk'];
                $stmtV = $koneksi->prepare("SELECT * FROM santri WHERE no_induk = ?");
                $stmtV->bind_param('i', $no);
                $stmtV->execute();
                $resV = $stmtV->get_result()->fetch_assoc();
            ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Detail Santri</h4>
                            <a href="data_santri.php" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                        
                        <?php if($resV): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-light w-25">No Induk</th>
                                        <td><?= $resV['no_induk']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Nama Lengkap</th>
                                        <td class="fw-bold"><?= htmlspecialchars($resV['nama']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tempat, Tgl Lahir</th>
                                        <td><?= htmlspecialchars($resV['Tempat_tanggal_lahir']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Alamat</th>
                                        <td><?= htmlspecialchars($resV['Alamat']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jilid</th>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($resV['jilid']); ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tahun Masuk</th>
                                        <td><?= htmlspecialchars($resV['Tahun_masuk']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            <?php $bg = match($resV['Keterangan']) { 'Aktif'=>'bg-success', 'Lulus'=>'bg-primary', 'Nonaktif'=>'bg-danger', default=>'bg-secondary' }; ?>
                                            <span class="badge <?= $bg ?>"><?= htmlspecialchars($resV['Keterangan']); ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="data_santri.php?act=edit&no_induk=<?= $resV['no_induk']; ?>" class="btn btn-warning text-white"><i class="bi bi-pencil-square"></i> Edit Data</a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">Data tidak ditemukan.</div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark">Data Santri</h2>
                        <p class="text-muted mb-0">Manajemen data siswa TPQ</p>
                    </div>
                    <a href="data_santri.php?act=add" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Santri</a>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <form class="d-flex gap-2" method="GET" action="data_santri.php">
                            <input type="hidden" name="act" value="list">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, alamat, atau jilid..." value="<?= htmlspecialchars($search); ?>">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3 px-3">No. Induk</th>
                                        <th class="py-3">Nama</th>
                                        <th class="py-3">Jilid</th>
                                        <th class="py-3">Alamat</th>
                                        <th class="py-3 text-center">Status</th>
                                        <th class="py-3 text-end px-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): 
                                        $bg = match($row['Keterangan']) { 'Aktif'=>'bg-success', 'Lulus'=>'bg-primary', 'Nonaktif'=>'bg-danger', default=>'bg-secondary' };
                                    ?>
                                        <tr>
                                            <td class="px-3"><?= $row['no_induk']; ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($row['nama']); ?></td>
                                            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['jilid']); ?></span></td>
                                            <td class="text-muted small"><?= htmlspecialchars($row['Alamat']); ?></td>
                                            <td class="text-center"><span class="badge <?= $bg ?> rounded-pill"><?= htmlspecialchars($row['Keterangan']); ?></span></td>
                                            <td class="text-end px-3">
                                                <a class="btn btn-sm btn-outline-info me-1" href="data_santri.php?act=view&no_induk=<?= $row['no_induk']; ?>" title="Lihat Detail"><i class="bi bi-eye"></i></a>
                                                <a class="btn btn-sm btn-outline-warning me-1" href="data_santri.php?act=edit&no_induk=<?= $row['no_induk']; ?>" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a class="btn btn-sm btn-outline-danger" href="data_santri.php?act=delete&no_induk=<?= $row['no_induk']; ?>" onclick="return confirm('Hapus?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($total_pages > 1): ?>
                            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                <small class="text-muted">Total: <?= $total_data; ?> Santri</small>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                            <li class="page-item <?= ($p == $page) ? 'active' : ''; ?>"><a class="page-link" href="data_santri.php?page=<?= $p; ?>"><?= $p; ?></a></li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </section>
</main>
<?php include 'footerdev.php'; ?>