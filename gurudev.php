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
// --- DITAMBAH: 'jabatan' ditambahkan sebagai kolom yang bisa disorting ---
$allowed_sort_columns = ['id_guru', 'nama', 'jabatan', 'keterangan'];
$allowed_orders = ['ASC', 'DESC'];

// Validasi sorting
if (!in_array($sort_by, $allowed_sort_columns)) {
    $sort_by = 'nama';
}
if (!in_array($sort_order, $allowed_orders)) {
    $sort_order = 'ASC';
}

// Parameter filter
$filter_nama = $_GET['filter_nama'] ?? '';
// --- DITAMBAH: Filter untuk 'jabatan' ---
$filter_jabatan = $_GET['filter_jabatan'] ?? '';
$filter_keterangan = $_GET['filter_keterangan'] ?? '';

// 5. LOGIKA PROSES (CREATE, UPDATE, DELETE)

// =======================================================================
// --- FUNGSI CREATE (Tambah Data) ---
// =======================================================================
if (isset($_POST['simpan'])) {
    
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    // --- DITAMBAH: Ambil data 'jabatan' ---
    $jabatan = $_POST['jabatan'] ?? ''; 
    $keterangan = $_POST['keterangan'] ?? 'Aktif';

    // Validasi nama
    if (empty($nama)) {
        $_SESSION['pesan_error'] = "Nama tidak boleh kosong.";
        header("Location: gurudev.php?act=tambah");
        exit;
    }

    // --- PROSES UPLOAD FOTO ---
    $path_untuk_database = ""; 
    
    if (isset($_FILES['foto_upload']) && $_FILES['foto_upload']['error'] == 0 && !empty($_FILES['foto_upload']['name'])) {
        
        $folder_tujuan_server = "assets/img/Guru/"; 
        if (!file_exists($folder_tujuan_server)) {
            mkdir($folder_tujuan_server, 0777, true); 
        }

        $nama_file_asli = basename($_FILES['foto_upload']['name']);
        $nama_file_unik = time() . '-' . strtolower(str_replace(' ', '-', $nama_file_asli));
        $path_tujuan_server = $folder_tujuan_server . $nama_file_unik;

        if (move_uploaded_file($_FILES['foto_upload']['tmp_name'], $path_tujuan_server)) {
            $path_untuk_database = $path_tujuan_server;
        } else {
            $_SESSION['pesan_error'] = "Gagal memindahkan file foto. Cek izin folder.";
            header("Location: gurudev.php?act=tambah");
            exit;
        }
    } else {
        $_SESSION['pesan_error'] = "Foto wajib di-upload.";
        header("Location: gurudev.php?act=tambah");
        exit;
    }
    // --- AKHIR PROSES UPLOAD FOTO ---

    // --- DIPERBARUI: Query 'jabatan' ditambahkan ---
    $stmt = $koneksi->prepare("INSERT INTO guru (nama, jabatan, keterangan, foto) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        $_SESSION['pesan_error'] = "Error database (Query prepare): " . $koneksi->error;
        header("Location: gurudev.php?act=tambah");
        exit;
    }
    
    // --- DIPERBARUI: bind_param menjadi 'ssss' (4 string) ---
    $stmt->bind_param("ssss", $nama, $jabatan, $keterangan, $path_untuk_database);
    
    if ($stmt->execute()) {
        $_SESSION['pesan_sukses'] = "Data guru baru berhasil ditambahkan.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menambah data ke database: " . $stmt->error;
    }
    $stmt->close();

    header("Location: gurudev.php");
    exit;
}
// =======================================================================
// --- AKHIR FUNGSI CREATE ---
// =======================================================================


// FUNGSI UPDATE (Edit Data) - LOGIKA DIPERBAIKI
if (isset($_POST['update'])) {
    $id_guru_asli = $_POST['id_guru_asli']; // ID asli tidak boleh berubah
    $nama = $_POST['nama'];
    // --- DITAMBAH: Ambil data 'jabatan' ---
    $jabatan = $_POST['jabatan'];
    $keterangan = $_POST['keterangan'];

    // LOGIKA UPDATE FOTO HARUS DITAMBAHKAN DI SINI NANTINYA
    // (Saat ini, form edit Anda belum ada input file foto baru)

    if (!empty($id_guru_asli) && !empty($nama)) {
        // --- DIPERBARUI: Query 'jabatan' ditambahkan ---
        $stmt = $koneksi->prepare("UPDATE guru SET nama = ?, jabatan = ?, keterangan = ? WHERE id_guru = ?");
        // --- DIPERBARUI: bind_param menjadi 'sssi' (3 string, 1 integer) ---
        $stmt->bind_param("sssi", $nama, $jabatan, $keterangan, $id_guru_asli);
        
        if ($stmt->execute()) {
            $_SESSION['pesan_sukses'] = "Data guru berhasil diupdate.";
        } else {
            $_SESSION['pesan_error'] = "Gagal mengupdate data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['pesan_error'] = "Data tidak lengkap untuk update.";
    }
    header("Location: gurudev.php");
    exit;
}

// FUNGSI DELETE (Hapus Data)
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id_guru_hapus = $_GET['id'];
    
    // SEBELUM MENGHAPUS DARI DB, ANDA HARUS MENGHAPUS FILE FOTO DARI SERVER
    // 1. Ambil path foto lama
    $stmt_select = $koneksi->prepare("SELECT foto FROM guru WHERE id_guru = ?");
    // --- DIPERBARUI: 's' (string) menjadi 'i' (integer) untuk ID ---
    $stmt_select->bind_param("i", $id_guru_hapus); 
    $stmt_select->execute();
    $result_foto = $stmt_select->get_result();
    if ($result_foto->num_rows > 0) {
        $data_foto = $result_foto->fetch_assoc();
        $path_foto_lama = $data_foto['foto'];
        
        // 2. Hapus file foto dari folder
        if (file_exists($path_foto_lama) && !empty($path_foto_lama)) {
            unlink($path_foto_lama);
        }
    }
    $stmt_select->close();

    // 3. Hapus data dari database
    $stmt = $koneksi->prepare("DELETE FROM guru WHERE id_guru = ?");
    // --- DIPERBARUI: 's' (string) menjadi 'i' (integer) untuk ID ---
    $stmt->bind_param("i", $id_guru_hapus);
    
    if ($stmt->execute()) {
        $_SESSION['pesan_sukses'] = "Data guru berhasil dihapus.";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus data: " . $stmt->error;
    }
    $stmt->close();
    header("Location: gurudev.php");
    exit;
}

// 6. QUERY UNTUK DATA DENGAN FILTER DAN SORTING
$where_conditions = [];
$params = [];
$types = "";

// Build kondisi WHERE untuk filter
if (!empty($filter_nama)) {
    $where_conditions[] = "nama LIKE ?";
    $params[] = "%" . $filter_nama . "%";
    $types .= "s";
}

// --- DITAMBAH: Logika filter untuk 'jabatan' ---
if (!empty($filter_jabatan)) {
    $where_conditions[] = "jabatan LIKE ?";
    $params[] = "%" . $filter_jabatan . "%";
    $types .= "s";
}

if (!empty($filter_keterangan)) {
    $where_conditions[] = "keterangan LIKE ?";
    $params[] = "%" . $filter_keterangan . "%";
    $types .= "s";
}

$where_clause = "";
if (!empty($where_conditions)) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Query untuk menghitung total data (untuk pagination)
$count_query = "SELECT COUNT(*) as total FROM guru $where_clause";
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
$data_query = "SELECT * FROM guru $where_clause ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";
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
  <section id="data-guru" class="data-guru section light-background">
    
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Manajemen Data Guru</h2>
        <p>Daftar Guru TPQ Roudlotul Ilmi</p>
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
        <h3>Tambah Data Guru Baru</h3>
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form action="gurudev.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            
            <div class="mb-3">
              <label for="jabatan" class="form-label">Jabatan</label>
              <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Contoh: Kepala TPQ, Guru Senior">
            </div>
            
            <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan (Status)</label>
              <select class="form-control" id="keterangan" name="keterangan">
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
                <option value="Cuti">Cuti</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="foto" class="form-label">Upload Foto</label>
              <input type="file" class="form-control" id="foto" name="foto_upload" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
            <a href="gurudev.php" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
      <?php
          break;
        
        // --- TAMPILAN FORM EDIT ---
        case 'edit':
          $id_guru_edit = $_GET['id'] ?? '';
          $stmt = $koneksi->prepare("SELECT * FROM guru WHERE id_guru = ?");
          // --- DIPERBARUI: 's' menjadi 'i' untuk ID ---
          $stmt->bind_param("i", $id_guru_edit);
          $stmt->execute();
          $result_edit = $stmt->get_result();
          $data_edit = $result_edit->fetch_assoc();
          $stmt->close();
          
          if ($data_edit) {
      ?>
            <h3>Edit Data Guru</h3>
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <form action="gurudev.php" method="POST"> 
                  <input type="hidden" name="id_guru_asli" value="<?php echo htmlspecialchars($data_edit['id_guru']); ?>">
                  
                  <div class="mb-3">
                    <label for="id_guru" class="form-label">ID Guru (Tidak bisa diubah)</label>
                    <input type="text" class="form-control" id="id_guru" name="id_guru" value="<?php echo htmlspecialchars($data_edit['id_guru']); ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required>
                  </div>
                  
                  <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo htmlspecialchars($data_edit['jabatan']); ?>">
                  </div>
                  
                  <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (Status)</label>
                    <select class="form-control" id="keterangan" name="keterangan">
                      <option value="Aktif" <?php echo ($data_edit['keterangan'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                      <option value="Nonaktif" <?php echo ($data_edit['keterangan'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                      <option value="Cuti" <?php echo ($data_edit['keterangan'] == 'Cuti') ? 'selected' : ''; ?>>Cuti</option>
                    </select>
                  </div>

                  <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                  <a href="gurudev.php" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
      <?php
          } else {
            echo '<div class="alert alert-danger">Data guru tidak ditemukan.</div>';
          }
          break;
        
        // --- TAMPILAN DEFAULT (TABEL DATA) ---
        default:
      ?>
        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <a href="?act=tambah" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Data Guru
          </a>
          
          <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="filter_nama" class="form-control form-control-sm" placeholder="Cari nama..." value="<?php echo htmlspecialchars($filter_nama); ?>" style="width: 180px;">
            
            <input type="text" name="filter_jabatan" class="form-control form-control-sm" placeholder="Cari jabatan..." value="<?php echo htmlspecialchars($filter_jabatan); ?>" style="width: 180px;">
            
            <select name="filter_keterangan" class="form-control form-control-sm" style="width: 140px;">
              <option value="">Semua Status</option>
              <option value="Aktif" <?php echo ($filter_keterangan == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
              <option value="Nonaktif" <?php echo ($filter_keterangan == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
              <option value="Cuti" <?php echo ($filter_keterangan == 'Cuti') ? 'selected' : ''; ?>>Cuti</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
            <?php if (!empty($filter_nama) || !empty($filter_jabatan) || !empty($filter_keterangan)): ?>
              <a href="gurudev.php" class="btn btn-sm btn-outline-secondary">Reset</a>
            <?php endif; ?>
          </form>
        </div>

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
                  <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'id_guru', 'order' => $sort_by == 'id_guru' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                    ID Guru
                    <?php if ($sort_by == 'id_guru'): ?>
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
                  <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'jabatan', 'order' => $sort_by == 'jabatan' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                    Jabatan
                    <?php if ($sort_by == 'jabatan'): ?>
                      <i class="bi bi-arrow-<?php echo $sort_order == 'ASC' ? 'up' : 'down'; ?>"></i>
                    <?php endif; ?>
                  </a>
                </th>
                
                <th scope="col">
                  <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'keterangan', 'order' => $sort_by == 'keterangan' && $sort_order == 'ASC' ? 'DESC' : 'ASC'])); ?>" class="text-white text-decoration-none">
                    Status (Keterangan)
                    <?php if ($sort_by == 'keterangan'): ?>
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
                  while ($dbguru = $result_tabel->fetch_assoc()) {
              ?>
                    <tr>
                      <td><?php echo htmlspecialchars($dbguru['id_guru']); ?></td>
                      <td><?php echo htmlspecialchars($dbguru['nama']); ?></td>
                      
                      <td><?php echo htmlspecialchars($dbguru['jabatan']); ?></td>
                      
                      <td>
                        <span class="badge 
                          <?php 
                            // Ini adalah logika pewarnaan badge
                            if ($dbguru['keterangan'] == 'Aktif') echo 'bg-success';
                            elseif ($dbguru['keterangan'] == 'Nonaktif') echo 'bg-danger';
                            elseif ($dbguru['keterangan'] == 'Cuti') echo 'bg-info';
                            else echo 'bg-secondary';
                          ?>">
                          <?php echo htmlspecialchars($dbguru['keterangan']); ?>
                        </span>
                      </td>
                      <td>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['act' => 'edit', 'id' => $dbguru['id_guru']])); ?>" class="btn btn-warning btn-sm" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['act' => 'hapus', 'id' => $dbguru['id_guru']])); ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                          <i class="bi bi-trash"></i>
                        </a>
                      </td>
                    </tr>
              <?php
                  }
              } else {
                  // --- DIPERBARUI: colspan menjadi 5 ---
                  echo '<tr><td colspan="5" class="text-center">Belum ada data guru.</td></tr>';
              }
              $stmt_data->close();
              ?>
            </tbody>
          </table>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
            </li>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
            
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