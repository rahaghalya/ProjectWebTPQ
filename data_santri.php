<?php
// 1. MULAI SESI DAN TAMPILKAN ERROR (UNTUK DEBUG)
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. INCLUDE KONEKSI
include 'koneksi.php';

// 3. INISIALISASI VARIABEL
$pesan_sukses = $_SESSION['pesan_sukses'] ?? '';
$pesan_error = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

// 4. PARAMETER PAGINATION, SORTING, DAN FILTER
$limit = 50; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Pastikan minimal halaman 1
$offset = ($page - 1) * $limit;

// Parameter sorting
$sort_by = $_GET['sort'] ?? 'nama';
$sort_order = $_GET['order'] ?? 'ASC';
$allowed_sort_columns = ['no_induk', 'nama', 'Alamat', 'jilid', 'Tahun_masuk', 'Keterangan'];
$allowed_orders = ['ASC', 'DESC'];

// Validasi sorting
if (!in_array($sort_by, $allowed_sort_columns)) {
    $sort_by = 'nama';
}
if (!in_array($sort_order, $allowed_orders)) {
    $sort_order = 'ASC';
}

// Parameter filter
$filter_jilid = $_GET['filter_jilid'] ?? '';
$filter_tahun = $_GET['filter_tahun'] ?? '';
$filter_nama = $_GET['filter_nama'] ?? '';
$filter_keterangan = $_GET['filter_keterangan'] ?? '';

// 5. LOGIKA PROSES (CREATE, UPDATE, DELETE)
// FUNGSI CREATE (Tambah Data)
if (isset($_POST['simpan'])) {
    $no_induk = $_POST['no_induk'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jilid = $_POST['jilid'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $keterangan = $_POST['keterangan'] ?? 'Aktif';

    if (!empty($no_induk) && !empty($nama)) {
        $stmt = $koneksi->prepare("INSERT INTO santri (no_induk, nama, Alamat, jilid, Tahun_masuk, Keterangan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $no_induk, $nama, $alamat, $jilid, $tahun_masuk, $keterangan);
        
        if ($stmt->execute()) {
            $_SESSION['pesan_sukses'] = "Data santri berhasil ditambahkan.";
        } else {
            $_SESSION['pesan_error'] = "Gagal menambah data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['pesan_error'] = "No. Induk dan Nama tidak boleh kosong.";
    }
    // Redirect kembali ke halaman utama
    header("Location: data_santri.php");
    exit;
}

// FUNGSI UPDATE (Edit Data)
if (isset($_POST['update'])) {
    $no_induk_asli = $_POST['no_induk_asli'];
    $no_induk = $_POST['no_induk'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jilid = $_POST['jilid'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $keterangan = $_POST['keterangan'];

    if (!empty($no_induk_asli) && !empty($no_induk) && !empty($nama)) {
        $stmt = $koneksi->prepare("UPDATE santri SET no_induk = ?, nama = ?, Alamat = ?, jilid = ?, Tahun_masuk = ?, Keterangan = ? WHERE no_induk = ?");
        $stmt->bind_param("sssssss", $no_induk, $nama, $alamat, $jilid, $tahun_masuk, $keterangan, $no_induk_asli);
        
        if ($stmt->execute()) {
            $_SESSION['pesan_sukses'] = "Data santri berhasil diupdate.";
        } else {
            $_SESSION['pesan_error'] = "Gagal mengupdate data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['pesan_error'] = "Data tidak lengkap untuk update.";
    }
    // Redirect kembali ke halaman utama
    header("Location: data_santri.php");
    exit;
}

// FUNGSI DELETE (Hapus Data)
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $no_induk_hapus = $_GET['id'];
    
    $stmt = $koneksi->prepare("DELETE FROM santri WHERE no_induk = ?");
    $stmt->bind_param("s", $no_induk_hapus);
    
    if ($stmt->execute()) {
        $_SESSION['pesan_sukses'] = "Data santri berhasil dihapus.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus data: " . $stmt->error;
    }
    $stmt->close();
    // Redirect kembali ke halaman utama
    header("Location: data_santri.php");
    exit;
}

// 6. QUERY UNTUK DATA DENGAN FILTER DAN SORTING
$where_conditions = [];
$params = [];
$types = "";

// Build kondisi WHERE untuk filter
if (!empty($filter_jilid)) {
    $where_conditions[] = "jilid = ?";
    $params[] = $filter_jilid;
    $types .= "s";
}

if (!empty($filter_tahun)) {
    $where_conditions[] = "Tahun_masuk = ?";
    $params[] = $filter_tahun;
    $types .= "s";
}

if (!empty($filter_nama)) {
    $where_conditions[] = "nama LIKE ?";
    $params[] = "%" . $filter_nama . "%";
    $types .= "s";
}

if (!empty($filter_keterangan)) {
    $where_conditions[] = "Keterangan LIKE ?";
    $params[] = "%" . $filter_keterangan . "%";
    $types .= "s";
}

$where_clause = "";
if (!empty($where_conditions)) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Query untuk menghitung total data (untuk pagination)
$count_query = "SELECT COUNT(*) as total FROM santri $where_clause";
$stmt_count = $koneksi->prepare($count_query);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_data = $result_count->fetch_assoc()['total'];
$stmt_count->close();

// Hitung total halaman
$total_pages = ceil($total_data / $limit);

// Query untuk data dengan pagination dan sorting
$data_query = "SELECT * FROM santri $where_clause ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";
$stmt_data = $koneksi->prepare($data_query);

// Tambah parameter untuk LIMIT dan OFFSET
$params_limit_offset = $params;
$params_limit_offset[] = $limit;
$params_limit_offset[] = $offset;
$types_limit_offset = $types . "ii";

if (!empty($params_limit_offset)) {
    $stmt_data->bind_param($types_limit_offset, ...$params_limit_offset);
}
$stmt_data->execute();
$result_tabel = $stmt_data->get_result();

// 7. INCLUDE HEADER
include 'headerdev.php';

// Ambil 'act' dari URL untuk menentukan tampilan
$act = $_GET['act'] ?? '';
?>

<main class="main">
  <section id="data-santri" class="data-santri section light-background">
    
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Manajemen Data Santri</h2>
        <p>Daftar Santri TPQ Roudlotul Ilmi</p>
      </div>

      <?php if ($pesan_sukses): ?>
        <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($pesan_sukses); ?>
        </div>
      <?php endif; ?>
      <?php if ($pesan_error): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($pesan_error); ?>
        </div>
      <?php endif; ?>

      
      <?php
      // 8. ROUTER TAMPILAN
      switch ($act) {
        
        // --- TAMPILAN FORM TAMBAH ---
        case 'tambah':
      ?>
          <h3>Tambah Data Santri Baru</h3>
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <form action="data_santri.php" method="POST">
                <div class="mb-3">
                  <label for="no_induk" class="form-label">No. Induk</label>
                  <input type="text" class="form-control" id="no_induk" name="no_induk" required>
                </div>
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="mb-3">
                  <label for="jilid" class="form-label">Jilid/Status</label>
                  <input type="text" class="form-control" id="jilid" name="jilid">
                </div>
                <div class="mb-3">
                  <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                  <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" min="2000" max="2099" step="1" value="<?php echo date('Y'); ?>">
                </div>
                <div class="mb-3">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <select class="form-control" id="keterangan" name="keterangan">
                    <option value="Aktif">Aktif</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Pindah">Pindah</option>
                  </select>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                <a href="data_santri.php" class="btn btn-secondary">Batal</a>
              </form>
            </div>
          </div>
      <?php
          break;
        
        // --- TAMPILAN FORM EDIT ---
        case 'edit':
          $no_induk_edit = $_GET['id'] ?? '';
          $stmt = $koneksi->prepare("SELECT * FROM santri WHERE no_induk = ?");
          $stmt->bind_param("s", $no_induk_edit);
          $stmt->execute();
          $result_edit = $stmt->get_result();
          $data_edit = $result_edit->fetch_assoc();
          $stmt->close();
          
          if ($data_edit) {
      ?>
            <h3>Edit Data Santri</h3>
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <form action="data_santri.php" method="POST">
                  <input type="hidden" name="no_induk_asli" value="<?php echo htmlspecialchars($data_edit['no_induk']); ?>">
                  
                  <div class="mb-3">
                    <label for="no_induk" class="form-label">No. Induk</label>
                    <input type="text" class="form-control" id="no_induk" name="no_induk" value="<?php echo htmlspecialchars($data_edit['no_induk']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($data_edit['Alamat']); ?>">
                  </div>
                  <div class="mb-3">
                    <label for="jilid" class="form-label">Jilid/Status</label>
                    <input type="text" class="form-control" id="jilid" name="jilid" value="<?php echo htmlspecialchars($data_edit['jilid']); ?>">
                  </div>
                  <div class="mb-3">
                    <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                    <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" min="2000" max="2099" step="1" value="<?php echo htmlspecialchars($data_edit['Tahun_masuk']); ?>">
                  </div>
                  <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <select class="form-control" id="keterangan" name="keterangan">
                      <option value="Aktif" <?php echo ($data_edit['Keterangan'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                      <option value="Lulus" <?php echo ($data_edit['Keterangan'] == 'Lulus') ? 'selected' : ''; ?>>Lulus</option>
                      <option value="Pindah" <?php echo ($data_edit['Keterangan'] == 'Pindah') ? 'selected' : ''; ?>>Pindah</option>
                    </select>
                  </div>
                  <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                  <a href="data_santri.php" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
      <?php
          } else {
            echo '<div class="alert alert-danger">Data santri tidak ditemukan.</div>';
          }
          break;
        
        // --- TAMPILAN DEFAULT (TABEL DATA) ---
        default:
      ?>
          <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="?act=tambah" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> Tambah Data Santri
            </a>
            
            <!-- FORM FILTER -->
            <form method="GET" class="d-flex gap-2 flex-wrap">
              <input type="text" name="filter_nama" class="form-control form-control-sm" placeholder="Cari nama..." value="<?php echo htmlspecialchars($filter_nama); ?>" style="width: 180px;">
              <input type="text" name="filter_jilid" class="form-control form-control-sm" placeholder="Filter jilid..." value="<?php echo htmlspecialchars($filter_jilid); ?>" style="width: 140px;">
              <input type="number" name="filter_tahun" class="form-control form-control-sm" placeholder="Tahun masuk..." value="<?php echo htmlspecialchars($filter_tahun); ?>" style="width: 140px;">
              <select name="filter_keterangan" class="form-control form-control-sm" style="width: 140px;">
                <option value="">Semua Keterangan</option>
                <option value="Aktif" <?php echo ($filter_keterangan == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                <option value="Lulus" <?php echo ($filter_keterangan == 'Lulus') ? 'selected' : ''; ?>>Lulus</option>
                <option value="Pindah" <?php echo ($filter_keterangan == 'Pindah') ? 'selected' : ''; ?>>Pindah</option>
              </select>
              <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
              <?php if (!empty($filter_nama) || !empty($filter_jilid) || !empty($filter_tahun) || !empty($filter_keterangan)): ?>
                <a href="data_santri.php" class="btn btn-sm btn-outline-secondary">Reset</a>
              <?php endif; ?>
            </form>
          </div>

          <!-- INFO PAGINATION DAN SORTING -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
              Menampilkan <?php echo $result_tabel->num_rows; ?> dari <?php echo $total_data; ?> data
              (Halaman <?php echo $page; ?> dari <?php echo $total_pages; ?>)
            </div>
          </div>

          <div class="table-responsive">
            <table id="tabelData" class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'no_induk', 'order' => $sort_by == 'no_induk' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      No. Induk
                      <?php if ($sort_by == 'no_induk'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'nama', 'order' => $sort_by == 'nama' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      Nama
                      <?php if ($sort_by == 'nama'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'Alamat', 'order' => $sort_by == 'Alamat' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      Alamat
                      <?php if ($sort_by == 'Alamat'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'jilid', 'order' => $sort_by == 'jilid' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      Jilid
                      <?php if ($sort_by == 'jilid'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'Tahun_masuk', 'order' => $sort_by == 'Tahun_masuk' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      Tahun Masuk
                      <?php if ($sort_by == 'Tahun_masuk'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'Keterangan', 'order' => $sort_by == 'Keterangan' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                      Keterangan
                      <?php if ($sort_by == 'Keterangan'): ?>
                        <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                      <?php endif; ?>
                    </a>
                  </th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result_tabel && $result_tabel->num_rows > 0) {
                    while ($santri = $result_tabel->fetch_assoc()) {
                ?>
                      <tr>
                        <td><?php echo htmlspecialchars($santri['no_induk']); ?></td>
                        <td><?php echo htmlspecialchars($santri['nama']); ?></td>
                        <td><?php echo htmlspecialchars($santri['Alamat']); ?></td>
                        <td><?php echo htmlspecialchars($santri['jilid']); ?></td>
                        <td><?php echo htmlspecialchars($santri['Tahun_masuk']); ?></td>
                        <td>
                          <span class="badge 
                            <?php 
                              if ($santri['Keterangan'] == 'Aktif') echo 'bg-success';
                              elseif ($santri['Keterangan'] == 'Lulus') echo 'bg-primary';
                              elseif ($santri['Keterangan'] == 'Pindah') echo 'bg-warning';
                              else echo 'bg-secondary';
                            ?>">
                            <?php echo htmlspecialchars($santri['Keterangan']); ?>
                          </span>
                        </td>
                        <td>
                          <a href="?<?php echo http_build_query(array_merge($_GET, ['act' => 'edit', 'id' => $santri['no_induk']])); ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <a href="?<?php echo http_build_query(array_merge($_GET, ['act' => 'hapus', 'id' => $santri['no_induk']])); ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <i class="bi bi-trash"></i>
                          </a>
                        </td>
                      </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">Belum ada data santri.</td></tr>';
                }
                $stmt_data->close();
                ?>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <?php if ($total_pages > 1): ?>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <!-- Previous Page -->
              <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
              </li>
              
              <!-- Page Numbers -->
              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                  <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              
              <!-- Next Page -->
              <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
              </li>
            </ul>
          </nav>
          <?php endif; ?>
      <?php
          break;
      }
      ?>

    </div>
  </section>
</main>
<?php
// 9. INCLUDE FOOTER
include 'footerdev.php';
?>