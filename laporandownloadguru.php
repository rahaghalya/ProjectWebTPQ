<?php
session_start();
include 'koneksi.php';

// 1. Panggil library DomPDF (Pastikan path ini benar)
require_once 'assets/vendor/dompdf/autoload.inc.php'; 
use Dompdf\Dompdf;
use Dompdf\Options;

// 2. Inisialisasi DomPDF (Sama)
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 
$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

// 3. Mulai "menangkap" output HTML (Sama)
ob_start();
?>

<style>
    /* ... (CSS sama seperti laporan santri) ... */
    body { font-family: sans-serif; }
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #000; padding: 5px; }
    th { background-color: #f2f2f2; text-align: left; }
    .report-header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 30px; }
    .report-header h3, .report-header p { margin: 0; }
    .report-footer { text-align: right; margin-top: 50px; }
    .report-footer p { margin-bottom: 70px; }
</style>

<div class="report-header">
    <h3>TPQ ROUDLOTUL ILMI</h3>
        <p>Perumahan Anggun Sejahtera, Rembang, Pasuruan, Jawa Timur</p>
        <p>Telepon: +62 83824275728 | Email: tpqroudlotulilmirembang@gmail.com</p>
</div>

<h4 style="text-align: center; margin: 30px 0;">LAPORAN DATA GURU</h4>

<table>
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th>No.</th>
            <th>Nama Guru</th>
            <th>Jabatan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // =======================================================
        // --- QUERY SUDAH DISESUAIKAN DENGAN TABEL GURU ANDA ---
        // =======================================================
        $query_guru = "SELECT nama, jabatan, keterangan 
                       FROM guru 
                       ORDER BY nama ASC";
        
        $result_guru = mysqli_query($koneksi, $query_guru);
        $no = 1;

        if (mysqli_num_rows($result_guru) > 0) {
            while ($row = mysqli_fetch_assoc($result_guru)) {
                // GANTI DATA ROW
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['jabatan'] . "</td>";
                echo "<td>" . $row['keterangan'] . "</td>";
                echo "</tr>";
            }
        } else {
            // GANTI PESAN ERROR
            echo '<tr><td colspan="4" style="text-align: center;">Belum ada data guru.</td></tr>';
        }
        ?>
    </tbody>
</table>

<div class="report-footer">
    <p>Rembang, <?php echo date('d F Y'); ?></p>
    <p>Kepala TPQ Roudlotul Ilmi</p>
    
    <u>Fitria ulfa</u><br>
    NIP. 1234567890
</div>

<?php
// 5. Selesai "menangkap" HTML (Sama)
$html = ob_get_clean();

// 6. Muat HTML ke DomPDF (Sama)
$dompdf->loadHtml($html);

// 7. Render HTML menjadi PDF (Sama)
$dompdf->render();

// 8. GANTI NAMA FILE DOWNLOAD
$dompdf->stream("laporan-guru.pdf", array("Attachment" => 1));

// Selesai
exit;
?>