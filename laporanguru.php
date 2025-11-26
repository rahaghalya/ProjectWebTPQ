<?php
session_start();
include 'headerdev.php';
?>

<style>
    @media print {

        /* 1. HILANGKAN HEADER/FOOTER BROWSER & SET KERTAS A4 */
        @page {
            size: A4 portrait;
            margin: 0;
            /* Margin 0 mematikan header/footer bawaan browser */
        }

        /* 2. BUAT MARGIN HALAMAN SENDIRI LEWAT PADDING BODY */
        body {
            margin: 0;
            padding: 20mm;
            /* Jarak isi konten dari pinggir kertas (2cm) */
            background-color: white;
            -webkit-print-color-adjust: exact;
        }

        /* 3. SEMBUNYIKAN ELEMEN WEBSITE (NAVBAR, TOMBOL, DLL) */
        .non-printable,
        .navbar,
        .footer,
        #header,
        .btn,
        a[href]:after {
            display: none !important;
        }

        /* 4. ATUR KONTEN AGAR RAPI */
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hapus margin bawaan bootstrap yang bikin turun */
        .mt-5,
        .mb-5 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        /* 5. KOP SURAT */
        .report-header {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .report-header img {
            height: 80px;
            /* Ukuran logo pas */
            margin-right: 20px;
        }

        .header-text {
            text-align: center;
        }

        .header-text h3 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* 6. CEGAH TABEL/TANDA TANGAN TERPOTONG */
        table,
        tr,
        td,
        th,
        .report-footer {
            page-break-inside: avoid;
        }

        .report-footer {
            margin-top: 30px;
            text-align: right;
            padding-right: 20px;
        }
    }
</style>

<div class="container-fluid mt-5 mb-5">

    <h2 class="text-center fw-bold mb-3 non-printable">Laporan Data Guru</h2>

    <div class="non-printable text-center mb-4">
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
        <a href="laporandownloadguru.php" class="btn btn-success">
            <i class="bi bi-download"></i> Download PDF
        </a>
    </div>

    <div class="printable-area">

        <div class="report-header d-flex align-items-center justify-content-center mb-4"
            style="border-bottom: 3px double black; padding-bottom: 15px;">

            <!-- LOGO SAMA DENGAN LAPORAN SANTRI -->
            <div style="flex: 0 0 100px; text-align: center;">
                <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ"
                    style="width: 90px; height: 90px; object-fit: contain;">
            </div>

            <!-- TEKS HEADER -->
            <div class="text-center" style="flex-grow: 1;">
                <h3 class="fw-bold m-0">TPQ ROUDLOTUL ILMI</h3>
                <p class="m-0">Perumahan Anggun Sejahtera, Rembang, Pasuruan, Jawa Timur</p>
                <p class="m-0">Telp: +62 83824275728 | Email: tpqroudlotulilmirembang@gmail.com</p>
            </div>
        </div>


        <h4 class="text-center fw-bold my-4" style="text-transform: uppercase;">LAPORAN DATA GURU</h4>

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
                $query_guru = "SELECT nama, jabatan, keterangan 
                               FROM guru 
                               ORDER BY nama ASC";

                $result_guru = mysqli_query($koneksi, $query_guru);
                $no = 1;

                if (mysqli_num_rows($result_guru) > 0) {
                    while ($row = mysqli_fetch_assoc($result_guru)) {
                ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['jabatan']; ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
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
            <p>Rembang, <?php echo date('d F Y'); ?></p>
            <p>Kepala TPQ Roudlotul Ilmi</p>
            <br><br><br> <u class="fw-bold">Fitria ulfa</u><br>
        </div>

    </div>
</div>

<?php
include 'footerdev.php';
?>