<?php
session_start();
include 'headerdev.php';
// Pastikan koneksi database tersedia
if (!isset($koneksi)) { include 'koneksi.php'; }

// --- 1. AMBIL DATA PENGATURAN DARI DATABASE (UNTUK KOP & TTD) ---
// Mengambil data dari tabel_pengaturan yang sudah Anda buat
$pengaturan = [];
$q_set = mysqli_query($koneksi, "SELECT * FROM tabel_pengaturan");
while ($r = mysqli_fetch_assoc($q_set)) {
    $pengaturan[$r['setting_key']] = $r['setting_value'];
}

// Gunakan data dari DB, jika kosong pakai default
$nama_tpq   = $pengaturan['nama_tpq'] ?? 'TPQ ROUDLOTUL ILMI';
$alamat_tpq = $pengaturan['alamat_tpq'] ?? 'Perumahan Anggun Sejahtera, Rembang, Pasuruan';
$kontak_tpq = "Telp: " . ($pengaturan['telepon_tpq'] ?? '-') . " | Email: " . ($pengaturan['email_tpq'] ?? '-');
$kepala_tpq = $pengaturan['kepala_tpq'] ?? 'Fitria Ulfa';
$nip_kepala = $pengaturan['nip_kepala_tpq'] ?? '-';


// --- 2. LOGIKA SORTING, SEARCH & PAGINATION ---
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'nama';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$nextOrder = ($order == 'ASC') ? 'DESC' : 'ASC';
$baseUrl = "&keyword=$keyword";

// Konfigurasi Pagination
$jumlahDataPerHalaman = 50;
$halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Query Dasar (Filter Aktif Only)
$whereClause = "WHERE Keterangan = 'Aktif'";
if (!empty($keyword)) {
    $whereClause .= " AND (nama LIKE '%$keyword%' OR no_induk LIKE '%$keyword%' OR Alamat LIKE '%$keyword%' OR nama_orang_tua LIKE '%$keyword%')";
}

// Validasi Kolom Sort
$allowedSorts = ['no_induk', 'nama', 'Alamat', 'Jilid', 'nama_orang_tua'];
if (!in_array($sortBy, $allowedSorts)) { $sortBy = 'nama'; }

// A. Hitung Total Data (Untuk Pagination)
$query_total = "SELECT COUNT(*) as total FROM santri $whereClause";
$result_total = mysqli_query($koneksi, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$totalData = $row_total['total'];
$jumlahHalaman = ceil($totalData / $jumlahDataPerHalaman);

// B. Ambil Data Santri Sesuai Halaman
$query_santri = "SELECT no_induk, nama, Alamat, Jilid, nama_orang_tua 
                 FROM santri $whereClause
                 ORDER BY $sortBy $order
                 LIMIT $awalData, $jumlahDataPerHalaman";
$result_santri = mysqli_query($koneksi, $query_santri);
$nomor_urut = $awalData + 1;
?>

<style>
    .sortable-header { color: white; text-decoration: none; display: flex; justify-content: space-between; align-items: center; padding: 5px; }
    .sortable-header:hover { color: #ffc107; }

    /* KHUSUS TAMPILAN PRINT / PDF */
    @media print {
        @page { size: A4 portrait; margin: 15mm; }
        body { background: white !important; -webkit-print-color-adjust: exact !important; font-family: 'Times New Roman', serif; }
        
        /* Sembunyikan elemen navigasi, tombol, header web, dan pagination saat print */
        .non-printable, .navbar, .footer, .btn, .search-area, .pagination-area, .sort-icon, a.sortable-header { 
            display: none !important; 
        }
        
        /* Pastikan tabel tercetak penuh */
        table { width: 100% !important; border-collapse: collapse !important; font-size: 11pt; }
        thead.table-dark th { background-color: white !important; color: black !important; border: 1px solid black !important; text-align: center; font-weight: bold; }
        .table td { border: 1px solid black !important; padding: 5px !important; }
        
        /* Layout Tanda Tangan */
        .report-footer {
            page-break-inside: avoid;
            float: right;
            width: 40%;
            text-align: center;
            margin-top: 50px;
        }
    }
</style>

<div class="container-fluid">

    <div class="non-printable mt-4 mb-3 text-center">
        <button onclick="window.print()" class="btn btn-primary me-2"><i class="bi bi-printer"></i> Cetak Laporan</button>
        <a href="laporandownloadsantri.php" class="btn btn-success"><i class="bi bi-download"></i> Download PDF</a>
    </div>

    <div class="printable-area" id="printArea">

        <div class="report-header d-flex align-items-center justify-content-center mb-4"
            style="border-bottom: 3px double black; padding-bottom: 15px;">
            <div style="flex: 0 0 100px; text-align: center;">
                <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ"
                    style="width: 90px; height: 90px; object-fit: contain;">
            </div>
            <div class="text-center" style="flex-grow: 1;">
                <h3 class="fw-bold m-0 text-uppercase"><?= htmlspecialchars($nama_tpq) ?></h3>
                <p class="m-0"><?= htmlspecialchars($alamat_tpq) ?></p>
                <p class="m-0"><?= htmlspecialchars($kontak_tpq) ?></p>
            </div>
        </div>

        <h4 class="text-center fw-bold my-4" style="text-decoration: underline;">LAPORAN DATA SANTRI AKTIF</h4>

        <div class="non-printable search-area mb-3">
            <form action="" method="GET" class="row g-2 justify-content-end">
                <div class="col-auto"><input type="text" name="keyword" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($keyword) ?>"></div>
                <input type="hidden" name="sort_by" value="<?= $sortBy ?>">
                <input type="hidden" name="order" value="<?= $order ?>">
                <div class="col-auto">
                    <button type="submit" class="btn btn-dark"><i class="bi bi-search"></i> Cari</button>
                    <?php if (!empty($keyword)) : ?><a href="laporan.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Reset</a><?php endif; ?>
                </div>
            </form>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th><a href="?sort_by=no_induk&order=<?= $nextOrder ?><?= $baseUrl ?>" class="sortable-header">No. Induk <span class="sort-icon"><i class="bi bi-arrow-down-up"></i></span></a></th>
                        <th><a href="?sort_by=nama&order=<?= $nextOrder ?><?= $baseUrl ?>" class="sortable-header">Nama <span class="sort-icon"><i class="bi bi-arrow-down-up"></i></span></a></th>
                        <th><a href="?sort_by=Alamat&order=<?= $nextOrder ?><?= $baseUrl ?>" class="sortable-header">Alamat <span class="sort-icon"><i class="bi bi-arrow-down-up"></i></span></a></th>
                        <th><a href="?sort_by=Jilid&order=<?= $nextOrder ?><?= $baseUrl ?>" class="sortable-header">Jilid <span class="sort-icon"><i class="bi bi-arrow-down-up"></i></span></a></th>
                        <th><a href="?sort_by=nama_orang_tua&order=<?= $nextOrder ?><?= $baseUrl ?>" class="sortable-header">Orang Tua <span class="sort-icon"><i class="bi bi-arrow-down-up"></i></span></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result_santri) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($result_santri)) : ?>
                            <tr>
                                <td class="text-center"><?= $nomor_urut++; ?></td>
                                <td class="text-center"><?= $row['no_induk']; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['Alamat']); ?></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary text-dark bg-opacity-25 border border-secondary"><?= htmlspecialchars($row['Jilid']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['nama_orang_tua']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr><td colspan="6" class="text-center py-4 fst-italic">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($jumlahHalaman > 1) : ?>
        <div class="non-printable pagination-area d-flex justify-content-between align-items-center mb-5">
            <small class="text-muted">Halaman <?= $halamanAktif ?> dari <?= $jumlahHalaman ?> (Total: <?= $totalData ?> Data)</small>
            <nav>
                <ul class="pagination mb-0">
                    <?php if ($halamanAktif > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?><?= $baseUrl ?>&sort_by=<?= $sortBy ?>&order=<?= $order ?>">Previous</a>
                        </li>
                    <?php else : ?>
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                        <?php if ($i == $halamanAktif) : ?>
                            <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                        <?php else : ?>
                            <li class="page-item"><a class="page-link" href="?halaman=<?= $i ?><?= $baseUrl ?>&sort_by=<?= $sortBy ?>&order=<?= $order ?>"><?= $i ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($halamanAktif < $jumlahHalaman) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?><?= $baseUrl ?>&sort_by=<?= $sortBy ?>&order=<?= $order ?>">Next</a>
                        </li>
                    <?php else : ?>
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>

        <div class="report-footer mt-5" style="display: flex; justify-content: flex-end;">
            <div style="text-align: center; width: 250px;">
                <p class="mb-1">Rembang, <?= date('d F Y'); ?></p>
                <p class="fw-bold mb-5">Kepala TPQ</p>

                <br><br><br>

                <u class="fw-bold d-block mt-5"><?= htmlspecialchars($kepala_tpq) ?></u>
                <?php if($nip_kepala != '-' && !empty($nip_kepala)): ?>
                    <span class="d-block">NIP. <?= htmlspecialchars($nip_kepala) ?></span>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include 'footerdev.php'; ?>