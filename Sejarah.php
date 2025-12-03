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

  <section id="sejarah" class="section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Perkembangan Kami</h2>
      <p>Jejak Langkah TPQ Roudlotul Ilmi</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <ul class="timeline">

        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM sejarah ORDER BY tahun ASC");

        if (mysqli_num_rows($query) == 0) {
          echo "<div class='text-center py-5'>Belum ada data sejarah.</div>";
        } else {
          $i = 0;
          while ($row = mysqli_fetch_assoc($query)) {
            $posisi_desktop = ($i % 2 == 0) ? 'left' : 'right';

            $img_src = "assets/img/sejarah/" . $row['gambar'];
            if (empty($row['gambar']) || !file_exists($img_src)) {
               $img_src = "assets/img/hero-bg.jpg"; 
            }
        ?>

            <li class="timeline-item <?php echo $posisi_desktop; ?>">
              
              <div class="timeline-marker"></div>

              <div class="timeline-content">
                
                <a href="<?php echo htmlspecialchars($img_src); ?>" 
                   class="glightbox timeline-image-wrapper" 
                   data-gallery="sejarah-gallery" 
                   data-title="<?php echo htmlspecialchars($row['judul']); ?>"
                   data-description="Tahun: <?php echo htmlspecialchars($row['tahun']); ?>">
                   
                    <img src="<?php echo htmlspecialchars($img_src); ?>" 
                         class="timeline-hero-img" 
                         alt="Sejarah <?php echo htmlspecialchars($row['tahun']); ?>">
                    
                    <div class="timeline-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </a>

                <div class="timeline-text-area">
                    <span class="timeline-year"><?php echo htmlspecialchars($row['tahun']); ?></span>
                    <h3 class="timeline-title"><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <p class="text-muted mb-0" style="line-height: 1.6; text-align: justify;">
                      <?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?>
                    </p>
                </div>
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