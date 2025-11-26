<?php
// 1. MULAI SESI DAN TAMPILKAN ERROR (DEBUGGING)
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. INCLUDE KONEKSI
include 'koneksi.php';

// Cek koneksi database
if (!$koneksi) {
  die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// 3. INISIALISASI VARIABEL PESAN
$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

// 4. PARAMETER PAGINATION, SORTING, DAN FILTER
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

// 5. LOGIKA CRUD (CREATE, UPDATE, DELETE)

// --- CREATE ---
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'] ?? '';
  $jabatan = $_POST['jabatan'] ?? '';
  $keterangan = $_POST['keterangan'] ?? 'Aktif';

  if (empty($nama)) {
    $_SESSION['pesan_error'] = "Nama tidak boleh kosong.";
    header("Location: gurudev.php?act=tambah");
    exit;
  }

  // Upload Foto
  $path_untuk_database = "";
  if (isset($_FILES['foto_upload']) && $_FILES['foto_upload']['error'] == 0) {
    $folder_tujuan = "assets/img/Guru/";
    if (!file_exists($folder_tujuan)) mkdir($folder_tujuan, 0777, true);

    $nama_file_asli = basename($_FILES['foto_upload']['name']);
    $nama_file_unik = time() . '-' . preg_replace("/[^a-zA-Z0-9.]/", "-", $nama_file_asli);
    $path_tujuan = $folder_tujuan . $nama_file_unik;

    if (move_uploaded_file($_FILES['foto_upload']['tmp_name'], $path_tujuan)) {
      $path_untuk_database = $path_tujuan;
    } else {
      $_SESSION['pesan_error'] = "Gagal upload foto.";
      header("Location: gurudev.php?act=tambah");
      exit;
    }
  } else {
    $_SESSION['pesan_error'] = "Foto wajib diupload.";
    header("Location: gurudev.php?act=tambah");
    exit;
  }

  $stmt = $koneksi->prepare("INSERT INTO guru (nama, jabatan, keterangan, foto) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nama, $jabatan, $keterangan, $path_untuk_database);

  if ($stmt->execute()) {
    $_SESSION['pesan_sukses'] = "Data berhasil disimpan.";
  } else {
    $_SESSION['pesan_error'] = "Gagal simpan: " . $stmt->error;
  }
  $stmt->close();
  header("Location: gurudev.php");
  exit;
}

// --- UPDATE ---
if (isset($_POST['update'])) {
  $id = $_POST['id_guru_asli'];
  $nama = $_POST['nama'];
  $jabatan = $_POST['jabatan'];
  $keterangan = $_POST['keterangan'];

  if (!empty($id)) {
    $stmt = $koneksi->prepare("UPDATE guru SET nama=?, jabatan=?, keterangan=? WHERE id_guru=?");
    $stmt->bind_param("sssi", $nama, $jabatan, $keterangan, $id);

    if ($stmt->execute()) {
      $_SESSION['pesan_sukses'] = "Data berhasil diupdate.";
    } else {
      $_SESSION['pesan_error'] = "Gagal update: " . $stmt->error;
    }
    $stmt->close();
  }
  header("Location: gurudev.php");
  exit;
}

// --- DELETE ---
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
  $id = $_GET['id'];

  // Hapus Foto Lama
  $stmt = $koneksi->prepare("SELECT foto FROM guru WHERE id_guru = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($r = $res->fetch_assoc()) {
    if (!empty($r['foto']) && file_exists($r['foto'])) unlink($r['foto']);
  }
  $stmt->close();

  // Hapus Data
  $stmt = $koneksi->prepare("DELETE FROM guru WHERE id_guru = ?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    $_SESSION['pesan_sukses'] = "Data berhasil dihapus.";
  } else {
    $_SESSION['pesan_error'] = "Gagal hapus: " . $stmt->error;
  }
  $stmt->close();
  header("Location: gurudev.php");
  exit;
}

// 6. BUILD QUERY FILTER & SEARCH
$where_cond = [];
$params = [];
$types = "";

if ($filter_nama) {
  $where_cond[] = "nama LIKE ?";
  $params[] = "%$filter_nama%";
  $types .= "s";
}
if ($filter_jabatan) {
  $where_cond[] = "jabatan LIKE ?";
  $params[] = "%$filter_jabatan%";
  $types .= "s";
}
if ($filter_keterangan) {
  $where_cond[] = "keterangan LIKE ?";
  $params[] = "%$filter_keterangan%";
  $types .= "s";
}

$where_clause = $where_cond ? "WHERE " . implode(" AND ", $where_cond) : "";

// Hitung Total Data
$q_count = "SELECT COUNT(*) as total FROM guru $where_clause";
$stmt = $koneksi->prepare($q_count);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total_data = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);
$stmt->close();

// Ambil Data Tabel
$q_data = "SELECT * FROM guru $where_clause ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";
$stmt_data = $koneksi->prepare($q_data);

// Gabung params untuk bind_param
$params_lim = $params;
$params_lim[] = $limit;
$params_lim[] = $offset;
$types_lim = $types . "ii";

$stmt_data->bind_param($types_lim, ...$params_lim);
$stmt_data->execute();
$result_tabel = $stmt_data->get_result();

// 7. TAMPILKAN HEADER & KONTEN
include 'headerdev.php';
$act = $_GET['act'] ?? '';
?>

<main class="main">
  <section id="data-guru" class="data-guru section light-background">
    <div class="container">

      <div class="section-title">
        <h2>Manajemen Data Guru</h2>
        <p>Daftar Guru TPQ Roudlotul Ilmi</p>
      </div>

      <?php if ($pesan_sukses): ?>
        <div class="alert alert-success"><?= $pesan_sukses ?></div>
      <?php endif; ?>
      <?php if ($pesan_error): ?>
        <div class="alert alert-danger"><?= $pesan_error ?></div>
      <?php endif; ?>

      <?php switch ($act):
        case 'tambah': ?>
          <h3>Tambah Data Guru Baru</h3>
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <form action="gurudev.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" name="jabatan" placeholder="Kepala TPQ, Guru...">
                </div>
                <div class="mb-3">
                  <label>Status</label>
                  <select class="form-control" name="keterangan">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                    <option value="Cuti">Cuti</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label>Upload Foto</label>
                  <input type="file" class="form-control" name="foto_upload" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="gurudev.php" class="btn btn-secondary">Batal</a>
              </form>
            </div>
          </div>
          <?php break; ?>

          <?php
        case 'edit':
          $id = $_GET['id'] ?? 0;
          $stmt = $koneksi->prepare("SELECT * FROM guru WHERE id_guru = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $data_edit = $stmt->get_result()->fetch_assoc();

          if ($data_edit) { ?>
            <h3>Edit Data Guru</h3>
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <form action="gurudev.php" method="POST">
                  <input type="hidden" name="id_guru_asli" value="<?= $data_edit['id_guru'] ?>">
                  <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data_edit['nama']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" value="<?= htmlspecialchars($data_edit['jabatan']) ?>">
                  </div>
                  <div class="mb-3">
                    <label>Status</label>
                    <select class="form-control" name="keterangan">
                      <option value="Aktif" <?= ($data_edit['keterangan'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                      <option value="Nonaktif" <?= ($data_edit['keterangan'] == 'Nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                      <option value="Cuti" <?= ($data_edit['keterangan'] == 'Cuti') ? 'selected' : '' ?>>Cuti</option>
                    </select>
                  </div>
                  <button type="submit" name="update" class="btn btn-primary">Update</button>
                  <a href="gurudev.php" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
          <?php } else {
            echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
          } ?>
          <?php break; ?>

        <?php
        default: ?>
          <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="?act=tambah" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Data</a>

            <form method="GET" class="d-flex gap-2">
              <input type="text" name="filter_nama" class="form-control" placeholder="Cari Nama..." value="<?= htmlspecialchars($filter_nama) ?>">
              <button type="submit" class="btn btn-outline-primary">Cari</button>
              <a href="gurudev.php" class="btn btn-outline-secondary">Reset</a>
            </form>
          </div>

        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
              <thead>
                <tr>
                  <th><a href="?sort=id_guru&order=<?= ($sort_order == 'ASC' ? 'DESC' : 'ASC') ?>" class="text-black">ID</a></th>
                  <th><a href="?sort=nama&order=<?= ($sort_order == 'ASC' ? 'DESC' : 'ASC') ?>" class="text-black">Nama Guru</a></th>
                  <th><a href="?sort=jabatan&order=<?= ($sort_order == 'ASC' ? 'DESC' : 'ASC') ?>" class="text-black">Jabatan</a></th>
                  <th><a href="?sort=keterangan&order=<?= ($sort_order == 'ASC' ? 'DESC' : 'ASC') ?>" class="text-black">Status</a></th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result_tabel && $result_tabel->num_rows > 0): ?>
                  <?php while ($row = $result_tabel->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['id_guru']) ?></td>
                      <td><?= htmlspecialchars($row['nama']) ?></td>
                      <td><?= htmlspecialchars($row['jabatan']) ?></td>
                      <td>
                        <?php
                        $badge = 'bg-secondary';
                        if ($row['keterangan'] == 'Aktif') $badge = 'bg-success';
                        if ($row['keterangan'] == 'Nonaktif') $badge = 'bg-danger';
                        if ($row['keterangan'] == 'Cuti') $badge = 'bg-info';
                        ?>
                        <span class="badge <?= $badge ?>"><?= htmlspecialchars($row['keterangan']) ?></span>
                      </td>
                      <td>
                        <a href="?act=edit&id=<?= $row['id_guru'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <a href="?act=hapus&id=<?= $row['id_guru'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">Data Guru Kosong</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <?php if ($total_pages > 1): ?>
            <nav>
              <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a></li>
                <li class="page-item active"><span class="page-link"><?= $page ?></span></li>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
              </ul>
            </nav>
          <?php endif; ?>

          <?php break; ?>
      <?php endswitch; ?>

    </div>
  </section>
</main>

<?php
if ($stmt_data) $stmt_data->close();
include 'footerdev.php';
?>