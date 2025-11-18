<?php
session_start();
include 'headerdev.php';
?>
<div class="container mt-5 mb-5">

    <div class="non-printable mb-4">
        <h2 class="mb-3">Laporan Data Guru</h2> 
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
        <a href="laporandownloadguru.php" class="btn btn-success">
            <i class="bi bi-download"></i> Download PDF
        </a>
    </div>

    <div class="printable-area">
        
        <div class="report-header">
            <img src="assets/img/about/1000105513-removebg-preview.png" alt="Logo TPQ">
            <h3>TPQ ROUDLOTUL ILMI</h3>
            <p>Perumahan Anggun Sejahtera, Rembang, Pasuruan, Jawa Timur</p>
            <p>Telepon: +62 83824275728 | Email: tpqroudlotulilmirembang@gmail.com</p>
        </div>

        <h4 class="text-center my-4">LAPORAN DATA GURU</h4>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Guru</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query Anda sudah benar
                $query_guru = "SELECT nama, jabatan, keterangan 
                               FROM guru 
                               ORDER BY nama ASC";
                
                $result_guru = mysqli_query($koneksi, $query_guru);
                $no = 1;

                if (mysqli_num_rows($result_guru) > 0) {
                    while ($row = mysqli_fetch_assoc($result_guru)) {
                ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
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
            
            <u>Fitria ulfa</u><br>
            NIP. 1234567890
        </div>

    </div> 
</div> <?php
include 'footerdev.php';
?>