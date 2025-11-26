<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// INCLUDE HEADER & KONEKSI (pastikan file ini ada di folder yang sama)
include 'headerdev.php';
include 'koneksi.php';

// --------------------------------------------------
// Data Santri - CRUD Lengkap (List / Create / Read / Update / Delete)
// - Primary key menggunakan `no_induk` (tipe INT)
// - No_induk akan auto-generate dengan mengambil MAX(no_induk)+1
// - Form sederhana untuk input dan edit
// - Notifikasi menggunakan alert JS standar
// --------------------------------------------------

// Pesan dari session
$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

// Routing sederhana via ?act=
$act = $_GET['act'] ?? 'list';

// Common: validasi input sederhana
function input_get($k, $default = '')
{
  return isset($_POST[$k]) ? trim($_POST[$k]) : $default;
}

// ------------- CREATE -------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $act === 'create') {
  // Auto-generate no_induk (ambil max + 1)
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
    header('Location: data_santri.php?act=add');
    exit;
  }

  $stmt = $koneksi->prepare("INSERT INTO santri (no_induk, nama, Tempat_tanggal_lahir, Alamat, jilid, Tahun_masuk, Keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("issssis", $no_induk, $nama, $tempat_tanggal_lahir, $alamat, $jilid, $tahun_masuk, $keterangan);

  if ($stmt->execute()) {
    $_SESSION['pesan_sukses'] = 'Data santri berhasil ditambahkan.';
    header('Location: data_santri.php');
    exit;
  } else {
    $_SESSION['pesan_error'] = 'Gagal menambah data: ' . $stmt->error;
    header('Location: data_santri.php?act=add');
    exit;
  }
}

// ------------- UPDATE -------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $act === 'edit') {
  $no_induk = (int) input_get('no_induk');
  $nama = input_get('nama');
  $tempat_tanggal_lahir = input_get('Tempat_tanggal_lahir');
  $alamat = input_get('Alamat');
  $jilid = input_get('jilid');
  $tahun_masuk = (int) input_get('Tahun_masuk');
  $keterangan = input_get('Keterangan', 'Aktif');

  if ($no_induk <= 0 || $nama === '') {
    $_SESSION['pesan_error'] = 'No Induk tidak valid atau nama kosong.';
    header('Location: data_santri.php');
    exit;
  }

  $stmt = $koneksi->prepare("UPDATE santri SET nama = ?, Tempat_tanggal_lahir = ?, Alamat = ?, jilid = ?, Tahun_masuk = ?, Keterangan = ? WHERE no_induk = ?");
  $stmt->bind_param("sssissi", $nama, $tempat_tanggal_lahir, $alamat, $jilid, $tahun_masuk, $keterangan, $no_induk);

  if ($stmt->execute()) {
    $_SESSION['pesan_sukses'] = 'Data santri berhasil diperbarui.';
  } else {
    $_SESSION['pesan_error'] = 'Gagal memperbarui data: ' . $stmt->error;
  }
  header('Location: data_santri.php');
  exit;
}

// ------------- DELETE -------------
if ($act === 'delete' && isset($_GET['no_induk'])) {
  $no_induk = (int) $_GET['no_induk'];
  if ($no_induk > 0) {
    $stmt = $koneksi->prepare("DELETE FROM santri WHERE no_induk = ?");
    $stmt->bind_param('i', $no_induk);
    if ($stmt->execute()) {
      $_SESSION['pesan_sukses'] = 'Data santri berhasil dihapus.';
    } else {
      $_SESSION['pesan_error'] = 'Gagal menghapus: ' . $stmt->error;
    }
  }
  header('Location: data_santri.php');
  exit;
}

// ------------- READ / LIST -------------
// Pagination, sorting, and search
$limit = 25;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$sort_by = $_GET['sort_by'] ?? 'no_induk';
$sort_order = (isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'DESC') ? 'DESC' : 'ASC';
$valid_sort = ['no_induk', 'nama', 'Tahun_masuk', 'jilid'];
if (!in_array($sort_by, $valid_sort)) $sort_by = 'no_induk';

$search = $_GET['search'] ?? '';
$where_sql = '';
$params = [];

if ($search !== '') {
  $where_sql = "WHERE nama LIKE ? OR Alamat LIKE ? OR jilid LIKE ?";
}

// Count total
if ($where_sql !== '') {
  $like = "%" . $search . "%";
  $stmtc = $koneksi->prepare("SELECT COUNT(*) as total FROM santri $where_sql");
  $stmtc->bind_param('sss', $like, $like, $like);
  $stmtc->execute();
  $res_c = $stmtc->get_result()->fetch_assoc();
  $total_data = (int)$res_c['total'];
} else {
  $res_c = $koneksi->query("SELECT COUNT(*) as total FROM santri");
  $total_data = (int)$res_c->fetch_assoc()['total'];
}

$total_pages = max(1, ceil($total_data / $limit));

// Fetch rows
$sql = "SELECT no_induk, nama, Tempat_tanggal_lahir, Alamat, jilid, Tahun_masuk, Keterangan FROM santri";
if ($where_sql !== '') $sql .= " $where_sql";
$sql .= " ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";


if ($where_sql !== '') {
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param('ssiii', $like, $like, $like, $limit, $offset);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param('ii', $limit, $offset);
  $stmt->execute();
  $result = $stmt->get_result();
}

?>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="container">

      <div class="section-title">
        <h2>Manajemen Data Santri (CRUD)</h2>
        <p>Daftar dan kelola data santri</p>
      </div>

      <?php if ($pesan_sukses): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($pesan_sukses); ?></div>
      <?php endif; ?>
      <?php if ($pesan_error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($pesan_error); ?></div>
      <?php endif; ?>

      <div class="mb-3 d-flex justify-content-between">
        <form class="d-flex" method="GET" action="data_santri.php">
          <input type="hidden" name="act" value="list">
          <input type="text" name="search" class="form-control me-2" placeholder="Cari nama / alamat / jilid" value="<?php echo htmlspecialchars($search); ?>">
          <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>

        <div>
          <a href="data_santri.php?act=add" class="btn btn-primary">Tambah Santri</a>
        </div>
      </div>

      <?php if ($act === 'add'): ?>
        <!-- FORM TAMBAH -->
        <div class="card mb-4">
          <div class="card-body">
            <h5>Tambah Santri</h5>
            <form method="POST" action="data_santri.php?act=create">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Tempat &amp; Tgl Lahir</label>
                <input type="text" name="Tempat_tanggal_lahir" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="Alamat" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Jilid</label>
                <select name="jilid" class="form-control" required>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="ghorib">Ghorib</option>
                  <option value="tajwid">Tajwid</option>
                  <option value="alquran">Al-Quran</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Tahun Masuk</label>
                <input type="number" name="Tahun_masuk" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <select name="Keterangan" class="form-control">
                  <option value="Aktif">Aktif</option>
                  <option value="Nonaktif">Nonaktif</option>
                </select>
              </div>
              <button class="btn btn-success" type="submit">Simpan</button>
              <a href="data_santri.php" class="btn btn-secondary">Batal</a>
            </form>
          </div>
        </div>
        <?php elseif ($act === 'edit' && isset($_GET['no_induk'])):
        $no = (int) $_GET['no_induk'];
        $stmtE = $koneksi->prepare("SELECT * FROM santri WHERE no_induk = ?");
        $stmtE->bind_param('i', $no);
        $stmtE->execute();
        $resE = $stmtE->get_result()->fetch_assoc();
        if (!$resE) {
          echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        } else {
        ?>
          <!-- FORM EDIT -->
          <div class="card mb-4">
            <div class="card-body">
              <h5>Edit Santri (No: <?php echo $resE['no_induk']; ?>)</h5>
              <form method="POST" action="data_santri.php?act=edit">
                <input type="hidden" name="no_induk" value="<?php echo $resE['no_induk']; ?>">
                <div class="mb-3">
                  <label class="form-label">Nama</label>
                  <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($resE['nama']); ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tempat &amp; Tgl Lahir</label>
                  <input type="text" name="Tempat_tanggal_lahir" class="form-control" value="<?php echo htmlspecialchars($resE['Tempat_tanggal_lahir']); ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Alamat</label>
                  <input type="text" name="Alamat" class="form-control" value="<?php echo htmlspecialchars($resE['Alamat']); ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Jilid</label>
                  <select name="jilid" class="form-control" required>
                    <?php
                    $opts = ['1', '2', '3', '4', '5', '6', 'ghorib', 'tajwid', 'alquran'];
                    foreach ($opts as $o) {
                      $sel = ($resE['jilid'] == $o) ? 'selected' : '';
                      echo "<option value=\"$o\" $sel>$o</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tahun Masuk</label>
                  <input type="number" name="Tahun_masuk" class="form-control" value="<?php echo htmlspecialchars($resE['Tahun_masuk']); ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Keterangan</label>
                  <select name="Keterangan" class="form-control">
                    <option value="Aktif" <?php echo (isset($resE) && $resE['Keterangan'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="Lulus" <?php echo (isset($resE) && $resE['Keterangan'] == 'Lulus') ? 'selected' : ''; ?>>Lulus</option>
                    <option value="Pindah" <?php echo (isset($resE) && $resE['Keterangan'] == 'Pindah') ? 'selected' : ''; ?>>Pindah</option>
                    <option value="Nonaktif" <?php echo (isset($resE) && $resE['Keterangan'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                  </select>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="data_santri.php" class="btn btn-secondary">Batal</a>
              </form>
            </div>
          </div>
        <?php }

      elseif ($act === 'view' && isset($_GET['no_induk'])):
        $no = (int) $_GET['no_induk'];
        $stmtV = $koneksi->prepare("SELECT * FROM santri WHERE no_induk = ?");
        $stmtV->bind_param('i', $no);
        $stmtV->execute();
        $resV = $stmtV->get_result()->fetch_assoc();
        if (!$resV) {
          echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        } else {
        ?>
          <!-- VIEW DETAIL -->
          <div class="card mb-4">
            <div class="card-body">
              <h5>Detail Santri (No: <?php echo $resV['no_induk']; ?>)</h5>
              <table class="table table-bordered">
                <tr>
                  <th>No Induk</th>
                  <td><?php echo $resV['no_induk']; ?></td>
                </tr>
                <tr>
                  <th>Nama</th>
                  <td><?php echo htmlspecialchars($resV['nama']); ?></td>
                </tr>
                <tr>
                  <th>Tempat &amp; Tgl Lahir</th>
                  <td><?php echo htmlspecialchars($resV['Tempat_tanggal_lahir']); ?></td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td><?php echo htmlspecialchars($resV['Alamat']); ?></td>
                </tr>
                <tr>
                  <th>Jilid</th>
                  <td><?php echo htmlspecialchars($resV['jilid']); ?></td>
                </tr>
                <tr>
                  <th>Tahun Masuk</th>
                  <td><?php echo htmlspecialchars($resV['Tahun_masuk']); ?></td>
                </tr>
                <tr>
                  <th>Keterangan</th>
                  <td><?php echo htmlspecialchars($resV['Keterangan']); ?></td>
                </tr>
              </table>
              <a href="data_santri.php" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        <?php }

      else:
        // DEFAULT: LIST
        ?>

        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No Induk</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jilid</th>
                    <th>Tahun Masuk</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $status = $row['Keterangan'];
                    $badge_class = 'bg-secondary'; // Default

                    if ($status === 'Aktif') $badge_class = 'bg-success'; // Hijau
                    elseif ($status === 'Lulus') $badge_class = 'bg-primary'; // Biru
                    elseif ($status === 'Pindah') $badge_class = 'bg-warning text-dark'; // Kuning
                    elseif ($status === 'Nonaktif') $badge_class = 'bg-danger'; // Merah
                    ?>

                    <tr>
                      <td class="align-middle text-center"><?php echo $row['no_induk']; ?></td>
                      <td class="align-middle fw-bold"><?php echo htmlspecialchars($row['nama']); ?></td>
                      <td class="align-middle"><?php echo htmlspecialchars($row['Alamat']); ?></td>
                      <td class="align-middle text-center"><?php echo htmlspecialchars($row['jilid']); ?></td>
                      <td class="align-middle text-center"><?php echo htmlspecialchars($row['Tahun_masuk']); ?></td>

                      <td class="align-middle text-center">
                        <span class="badge <?php echo $badge_class; ?> px-3 py-2 rounded-pill">
                          <?php echo htmlspecialchars($row['Keterangan']); ?>
                        </span>
                      </td>

                      <td class="align-middle text-center">
                        <div class="btn-group" role="group">

                          <a class="btn btn-info btn-sm text-white" href="data_santri.php?act=view&no_induk=<?php echo $row['no_induk']; ?>" title="Lihat Detail">
                            <i class="bi bi-eye-fill"></i>
                          </a>

                          <a class="btn btn-warning btn-sm text-dark" href="data_santri.php?act=edit&no_induk=<?php echo $row['no_induk']; ?>" title="Edit Data">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <a class="btn btn-danger btn-sm" href="data_santri.php?act=delete&no_induk=<?php echo $row['no_induk']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus Data">
                            <i class="bi bi-trash-fill"></i>
                          </a>

                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>

              <div class="d-flex justify-content-between align-items-center">
                <div>Menampilkan halaman <?php echo $page; ?> dari <?php echo $total_pages; ?> (Total: <?php echo $total_data; ?>)</div>
                <nav>
                  <ul class="pagination mb-0">
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                      <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>"><a class="page-link" href="data_santri.php?page=<?php echo $p; ?>"><?php echo $p; ?></a></li>
                    <?php endfor; ?>
                  </ul>
                </nav>
              </div>

            </div>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </section>
</main>

<?php include 'footerdev.php'; ?>