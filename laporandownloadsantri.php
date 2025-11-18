<?php
session_start();
include 'koneksi.php';
require_once 'assets/vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// 2. Inisialisasi DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Izinkan DomPDF memuat gambar eksternal (jika ada)
$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait'); // Atur ukuran kertas (A4, potrait)

// 3. Mulai "menangkap" output HTML
// (Alih-alih mencetak ke layar, kita simpan di variabel)
ob_start();

// 4. Masukkan HTML Laporan Anda di Sini
// (Ini adalah KOPAS dari file laporan.php, tapi TANPA headerdev/footerdev)
?>

<style>
    body {
        font-family: sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid #000;
        padding: 5px;
    }
    th {
        background-color: #f2f2f2;
        text-align: left;
    }
    .report-header {
        text-align: center;
        border-bottom: 3px solid #000;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }
    .report-header h3, .report-header p {
        margin: 0;
    }
    .report-footer {
        text-align: right;
        margin-top: 50px;
    }
    .report-footer p {
        margin-bottom: 70px;
    }
</style>

<div class="report-header">
    <h3>TPQ ROUDLOTUL ILMI</h3>
    <p>Perumahan Anggun Sejahtera, Rembang, Pasuruan, Jawa Timur</p>
    <p>Telepon: +62 83824275728 | Email: tpqroudlotulilmirembang@gmail.com</p>
</div>

<h4 style="text-align: center; margin: 30px 0;">LAPORAN DATA SANTRI AKTIF</h4>

<table>
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th>No.</th>
            <th>No. Induk</th>
            <th>Nama Santri</th>
            <th>Alamat</th>
            <th>Jilid</th>
            <th>Nama Orang Tua</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query yang SAMA PERSIS dengan di laporan.php
        $query_santri = "SELECT no_induk, nama, Alamat, Jilid, nama_orang_tua 
                         FROM santri 
                         WHERE Keterangan = 'Aktif'
                         ORDER BY nama ASC";
        
        $result_santri = mysqli_query($koneksi, $query_santri);
        $no = 1;

        if (mysqli_num_rows($result_santri) > 0) {
            while ($row = mysqli_fetch_assoc($result_santri)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['no_induk'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['Alamat'] . "</td>";
                echo "<td>" . $row['Jilid'] . "</td>";
                echo "<td>" . $row['nama_orang_tua'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo '<tr><td colspan="6" style="text-align: center;">Belum ada data santri aktif.</td></tr>';
        }
        ?>
    </tbody>
</table>

<div class="report-footer">
    <p>Surabaya, <?php echo date('d F Y'); ?></p>
    <p>Kepala TPQ Roudlotul Ilmi</p>
    
    <u>(Nama Kepala TPQ)</u><br>
    NIP. 1234567890
</div>

<?php
// 5. Selesai "menangkap" HTML
$html = ob_get_clean();

// 6. Muat HTML ke DomPDF
$dompdf->loadHtml($html);

// 7. Render HTML menjadi PDF
$dompdf->render();

// 8. Kirim file PDF ke browser untuk di-download
// "laporan-santri.pdf" adalah nama file yang akan di-download
$dompdf->stream("laporan-santri.pdf", array("Attachment" => 1));

// Selesai
exit;
?>