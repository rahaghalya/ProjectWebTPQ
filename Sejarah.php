<?php
include 'header.php';
// Pastikan koneksi aman
?>

<main class="main">

  <div class="page-title">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Sejarah</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Sejarah</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="sejarah" class="timeline-section">
    <div class="container section-title">
      <h2>Perkembangan Kami</h2>
      <p>Jejak Langkah TPQ Roudlotul Ilmi</p>
    </div>

    <div class="container">
      <ul class="timeline">

        <?php
        // Query Database
        $query = mysqli_query($koneksi, "SELECT * FROM sejarah ORDER BY tahun ASC");

        // Cek Data
        if (mysqli_num_rows($query) == 0) {
            echo "<div class='text-center py-5'>Belum ada data sejarah.</div>";
        } else {
            $i = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                
                // Logic Zig-Zag Desktop (Genap=Kanan, Ganjil=Kiri)
                // Variable ini akan dibaca oleh CSS Media Query
                $posisi_desktop = ($i % 2 == 0) ? 'left' : 'right';

                // Cek Gambar
                $img_src = "assets/img/sejarah/" . $row['gambar'];
                if (empty($row['gambar']) || !file_exists($img_src)) {
                    $img_src = "assets/img/logo.png"; // Gambar default
                }
        ?>

        <li class="timeline-item <?php echo $posisi_desktop; ?>">
            
            <div class="timeline-img">
                <img src="<?php echo htmlspecialchars($img_src); ?>" alt="Tahun <?php echo htmlspecialchars($row['tahun']); ?>">
            </div>

            <div class="timeline-content">
                <span class="timeline-year"><?php echo htmlspecialchars($row['tahun']); ?></span>
                <h3 class="timeline-title"><?php echo htmlspecialchars($row['judul']); ?></h3>
                <p class="text-muted mb-0">
                    <?php echo htmlspecialchars($row['deskripsi']); ?>
                </p>
            </div>

        </li>

        <?php 
                $i++;
            } 
        } 
        ?>

      </ul>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>