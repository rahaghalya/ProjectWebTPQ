<?php
require_once 'assets/vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 
$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait'); 

ob_start();
$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/WebTPQ/assets/img/about/1000105513-removebg-preview.png'; 

// Pastikan nama folder '/WebTPQ/' sesuai dengan nama folder Anda di htdocs
 
if (file_exists($logoPath)) {
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,' . $logoData; // Gunakan image/png
} else {
    $logoSrc = ''; // Kosongkan jika logo tidak ditemukan
}
?>


<style>
    /* 1. Atur margin halaman PDF-nya jadi lebih kecil */
    @page {
        margin: 20px; /* <-- Margin dikecilkan lagi */
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 9.5pt; /* <-- 2. Font dikecilkan lagi */
        line-height: 1.2; /* <-- 3. Jarak antar baris dirapatkan */
        margin: 0;
    }
    .header {
        text-align: center;
        border-bottom: 3px double #000;
        padding-bottom: 5px; 
        margin-bottom: 5px; 
    }
    .header img { display: none; }
    .header h4, .header h5, .header p { margin: 0; }
    .header h4 { font-size: 14pt; }
    .header h5 { font-size: 12pt; }
    .header p { font-size: 9pt; }
    
    .section-title {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 2px; /* <-- 4. Spasi dikurangi lagi */
        border: 1px solid #ccc;
        margin-top: 8px; /* <-- 5. Spasi antar bagian dikurangi lagi */
    }
    .content-table {
        width: 100%;
        margin-top: 2px; /* <-- 6. Spasi dikurangi lagi */
        font-size: 9.5pt; /* Ukuran font tabel */
    }
    .content-table td {
        padding: 1px; /* <-- 7. Jarak antar baris dikurangi lagi */
        vertical-align: top;
    }
    .label { width: 35%; }
    .colon { width: 2%; }
    .field { width: 63%; border-bottom: 1px dotted #000; }
    .photo-box {
        width: 85px; /* <-- 8. Kotak foto dikecilkan */
        height: 115px; /* <-- 8. Kotak foto dikecilkan */
        border: 1px solid #000;
        text-align: center;
        padding-top: 40px;
        font-size: 9.5pt;
    }
    
    /* 9. Kurangi jarak di bagian tanda tangan */
    table[style*="margin-top: 20px"] {
        margin-top: 15px !important; 
    }
</style>

<body>
    <div class="header">
        <h4>FORMULIR PENDAFTARAN SANTRI BARU</h4>
        <h5>TAMAN PENDIDIKAN AL-QURAN</h5>
        <h4>ROUDLOTUL ILMI</h4>
        <p>Perumahan anggun sejahtera Rembang Pasuruan, HP: +62 83824275728</p>
    </div>

    <h5 style="text-align:center; margin: 5px 0;">DATA PERSONAL SANTRI BARU</h5>
    <table class="content-table" style="width: 50%;">
        <tr>
            <td class="label">Tahun Ajaran</td>
            <td class="colon">:</td>
            <td class="field">20..... / 20.....</td>
        </tr>
    </table>

    <div class="section-title">A. KETERANGAN PRIBADI SANTRI</div>
    <table class="content-table">
        <tr>
            <td class="label">Nama lengkap</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Jenis kelamin</td>
            <td class="colon">:</td>
            <td class="field">Laki-laki / Perempuan *</td>
        </tr>
        <tr>
            <td class="label">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Anak ke</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Jumlah Saudara</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
    </table>

    <div class="section-title">B. KETERANGAN TEMPAT TINGGAL SANTRI</div>
    <table class="content-table">
        <tr>
            <td class="label">Alamat santri</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Blok/No Rumah</td>
            <td class="colon">:</td>
            <td class="field">
                <span style="border-bottom: 1px dotted #000; width: 100px; display:inline-block;"></span>
                RT: <span style="border-bottom: 1px dotted #000; width: 40px; display:inline-block;"></span>
                RW: <span style="border-bottom: 1px dotted #000; width: 40px; display:inline-block;"></span>
            </td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Desa/Kelurahan</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Kecamatan</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Kabupaten</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Diterima sebagai santri baru pada</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
    </table>

    <div class="section-title">C. KETERANGAN ORANG TUA KANDUNG</div>
    <table class="content-table">
        <tr>
            <td class="label" style="font-weight: bold;">Ayah</td>
            <td class="colon"></td>
            <td class="field" style="border:none;"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Nama</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Pendidikan terakhir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
         <tr>
            <td class="label" style="padding-left: 20px;">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Alamat</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="font-weight: bold;">Ibu</td>
            <td class="colon"></td>
            <td class="field" style="border:none; padding-top: 5px;"></td> </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Nama</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Pendidikan terakhir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
         <tr>
            <td class="label" style="padding-left: 20px;">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">Alamat</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label" style="padding-left: 20px;">No HP yang bisa dihubungi</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
    </table>

    <div class="section-title">D. KETERANGAN WALI SANTRI</div>
    <table class="content-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Pendidikan terakhir</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
         <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="field"></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 15px; border: none !important;"> <tr style="border: none !important;">
            <td style="width: 30%; vertical-align: top; border: none !important;">
                <div class="photo-box">
                    Pas photo
                    <br>
                    3x4
                </div>
            </td>
            <td style="width: 30%; border: none !important;">
                </td>
            <td style="width: 40%; text-align: left; border: none !important;">
                Rembang, ........................ 20.....
                <br>
                Pendaftar,
                <br><br><br> (..............................................)
            </td>
        </tr>
    </table>

    <i style="font-size: 8pt; margin-top: 5px; display:block;">* Coret yang tidak perlu</i> </body>
<?php
// 5. Selesai "menangkap" HTML
$html = ob_get_clean();

// 6. Muat HTML ke DomPDF
$dompdf->loadHtml($html);

// 7. Render HTML menjadi PDF
$dompdf->render();

// 8. Kirim file PDF ke browser untuk di-download
$nama_file = "formulir-pendaftaran-tpq-roudlotul-ilmi.pdf";
$dompdf->stream($nama_file, array("Attachment" => 1)); 

// Selesai
exit;
?> 