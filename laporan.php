<?php
session_start();
include 'headerdev.php';
?>
<div class="container mt-5 mb-5">

    <div class="non-printable mb-4">
        <h2 class="mb-3">Laporan Data Santri</h2>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
        
        <a href="laporandownloadsantri.php" class="btn btn-success">
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

        <h4 class="text-center my-4">LAPORAN DATA SANTRI AKTIF</h4>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">No. Induk</th>
                    <th scope="col">Nama Santri</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Jilid/Kelas</th>
                    <th scope="col">Nama Orang Tua</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query Anda sudah benar
                $query_santri = "SELECT no_induk, nama, Alamat, Jilid, nama_orang_tua 
                                 FROM santri 
                                 WHERE Keterangan = 'Aktif'
                                 ORDER BY nama ASC";
                
                $result_santri = mysqli_query($koneksi, $query_santri);
                $no = 1;

                if (mysqli_num_rows($result_santri) > 0) {
                    while ($row = mysqli_fetch_assoc($result_santri)) {
                ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['no_induk']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['Alamat']; ?></td>
                            <td><?php echo $row['Jilid']; ?></td>
                            <td><?php echo $row['nama_orang_tua']; ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">Belum ada data santri aktif.</td></tr>';
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
</div> 
<?php
// Sertakan Footer Admin
include 'footerdev.php';
?>