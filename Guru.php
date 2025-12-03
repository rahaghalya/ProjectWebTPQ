<?php
include 'header.php';

$query_guru = "SELECT * FROM guru ORDER BY id_guru ASC";
$result_guru = mysqli_query($koneksi, $query_guru);
?>

<main class="main">

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Daftar Guru</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Guru Kami</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="team" class="team section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Tim Kami</h2>
      <p>Profil Guru dan Pengurus TPQ Roudlotul Ilmi</p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <?php
        if (mysqli_num_rows($result_guru) > 0) {

          $delay = 100;
          
          /* Ganti path ini dengan lokasi gambar default Anda */
          $default_foto = "assets/img/about/guru/default-guru.jpg"; 

          while ($row = mysqli_fetch_assoc($result_guru)) {

            $foto_db = $row['foto'];

            if (!empty($foto_db) && file_exists($foto_db)) {
                $foto_tampil = $foto_db;
            } else {
                $foto_tampil = $default_foto;
            }
        ?>
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
              <div class="member">

                <div class="member-img">
                  <img src="<?php echo htmlspecialchars($foto_tampil); ?>" 
                       class="img-fluid" 
                       alt="Foto <?php echo htmlspecialchars($row['nama']); ?>" 
                       style="width: 100%; height: 300px; object-fit: cover;">
                </div>

                <div class="member-info">
                  <h4><?php echo htmlspecialchars($row['nama']); ?></h4>
                  <span><?php echo htmlspecialchars($row['jabatan']); ?></span>
                  <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                </div>

              </div>
            </div>
        <?php
            $delay += 100;
          } 

        } else {
          echo '<div class="col-12 text-center"><p>Belum ada data guru yang tersedia.</p></div>';
        }
        ?>

      </div>
    </div>

  </section>

</main>

<?php
include 'footer.php';
?>