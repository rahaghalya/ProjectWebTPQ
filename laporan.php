<?php
session_start();
include 'headerdev.php'; // Koneksi sudah ada di sini
?>

<div class="container-fluid mt-5 mb-5">

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

        <?php
        // 1. Tentukan batas data per halaman
        $jumlahDataPerHalaman = 50;

        // 2. Cek halaman aktif (default ke halaman 1)
        $halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;

        // 3. Hitung data awal (offset)
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

        // 4. Hitung Total Data (Untuk tahu ada berapa halaman)
        $query_total = "SELECT * FROM santri WHERE Keterangan = 'Aktif'";
        $result_total = mysqli_query($koneksi, $query_total);
        $jumlahData = mysqli_num_rows($result_total);
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
        ?>

        <div class="table-responsive">
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
                    // 5. Query Utama dengan LIMIT
                    $query_santri = "SELECT no_induk, nama, Alamat, Jilid, nama_orang_tua 
                                     FROM santri 
                                     WHERE Keterangan = 'Aktif'
                                     ORDER BY nama ASC 
                                     LIMIT $awalData, $jumlahDataPerHalaman";
                    
                    $result_santri = mysqli_query($koneksi, $query_santri);
                    
                    // Nomor urut harus melanjutkan dari halaman sebelumnya
                    $no = $awalData + 1;

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
        </div>

        <nav aria-label="Page navigation" class="non-printable mt-3">
            <ul class="pagination justify-content-center">
                
                <?php if($halamanAktif > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">
                            &laquo; Sebelumnya
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo; Sebelumnya</span>
                    </li>
                <?php endif; ?>

                <li class="page-item disabled">
                    <span class="page-link text-dark">
                        Halaman <?= $halamanAktif; ?> dari <?= $jumlahHalaman; ?>
                    </span>
                </li>

                <?php if($halamanAktif < $jumlahHalaman) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">
                            Selanjutnya &raquo;
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Selanjutnya &raquo;</span>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

        <div class="report-footer">
            <p>Rembang, <?php echo date('d F Y'); ?></p> 
            <p>Kepala TPQ Roudlotul Ilmi</p>
            
            <u>Fitria ulfa</u><br>
            NIP. 1234567890
        </div>

    </div> 
</div> 
<?php
include 'footerdev.php';
?>