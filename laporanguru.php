<?php
session_start();
include 'headerdev.php';
// Pastikan koneksi disertakan
if (!isset($koneksi)) { include 'koneksi.php'; }

// --- AMBIL DATA PENGATURAN DARI DATABASE ---
$pengaturan = [];
$q_set = mysqli_query($koneksi, "SELECT * FROM tabel_pengaturan");
while ($r = mysqli_fetch_assoc($q_set)) {
    $pengaturan[$r['setting_key']] = $r['setting_value'];
}

// Default Value (Jika database kosong)
$nama_tpq   = $pengaturan['nama_tpq'] ?? 'TPQ ROUDLOTUL ILMI';
$alamat_tpq = $pengaturan['alamat_tpq'] ?? 'Perumahan Anggun Sejahtera, Rembang, Pasuruan';
$kontak_tpq = "Telp: " . ($pengaturan['telepon_tpq'] ?? '-') . " | Email: " . ($pengaturan['email_tpq'] ?? '-');
$kepala_tpq = $pengaturan['kepala_tpq'] ?? 'Fitria Ulfa';
$nip_kepala = $pengaturan['nip_kepala_tpq'] ?? '-';
?>

<style>
    @media print {
        @page { size: A4 portrait; margin: 0; }
        body { margin: 0; padding: 20mm; background-color: white; -webkit-print-color-adjust: exact; }
        .non-printable, .navbar, .footer, #header, .btn, a[href]:after { display: none !important; }
        .container-fluid { width: 100% !important; padding: 0 !important; margin: 0 !important; }
        .mt-5, .mb-5 { margin-top: 0 !important; margin-bottom: 0 !important; }
        
        .report-header {
            display: flex; align-items: center; justify-content: center;
            border-bottom: 3px double black; padding-bottom: 15px; margin-bottom: 20px;
        }
        .report-header img { height: 80px; margin-right: 20px; }
        table, tr, td, th, .report-footer { page-break-inside: avoid; }
        
        /* Footer Tanda Tangan Kanan Bawah */
        .report-footer {
            margin-top: 50px;
            float: right;
            width: 40%;
            text-align: center;
        }
    }
</style>

<div class="container-fluid mt-5 mb-5">

    <h2 class="text-center fw-bold mb-3 non-printable">Laporan Data Guru</h2>

    <div class="non-printable text-center mb-4">
        <button onclick="window.print()" class="btn btn-primary me-2"><i class="bi bi-printer"></i> Cetak Laporan</button>
        <a href="laporandownloadguru.php" class="btn btn-success"><i class="bi bi-download"></i> Download PDF</a>
    </div>

    <div class="printable-area">

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

        <h4 class="text-center fw-bold my-4 text-uppercase">LAPORAN DATA GURU</h4>

        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col" width="5%">No.</th>
                    <th scope="col">Nama Guru</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_guru = "SELECT nama, jabatan, keterangan FROM guru ORDER BY nama ASC";
                $result_guru = mysqli_query($koneksi, $query_guru);
                $no = 1;

                if (mysqli_num_rows($result_guru) > 0) {
                    while ($row = mysqli_fetch_assoc($result_guru)) {
                        $jabatan = !empty($row['jabatan']) ? $row['jabatan'] : '-';
                ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($jabatan); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['keterangan']); ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">Belum ada data guru.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="report-footer">
            <p class="mb-1">Rembang, <?php echo date('d F Y'); ?></p>
            <p class="fw-bold mb-5">Kepala TPQ</p>
            
            <br><br>
            
            <u class="fw-bold d-block"><?= htmlspecialchars($kepala_tpq) ?></u>
            <?php if($nip_kepala != '-' && !empty($nip_kepala)): ?>
                <span class="d-block small">NIP. <?= htmlspecialchars($nip_kepala) ?></span>
            <?php endif; ?>
        </div>
        
        <div style="clear: both;"></div>

    </div>
</div>

<?php include 'footerdev.php'; ?>