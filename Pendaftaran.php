<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';


// 2. Query untuk mengambil 4 berita terbaru dari database
//$query_berita = "SELECT * FROM tabel_berita ORDER BY tgl_post DESC LIMIT 4";
//$result_berita = mysqli_query($koneksi, $query_berita);
?>

<main class="main">

    <div class="page-title" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Pendaftaran</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Pendaftaran</li>
          </ol>
        </nav>
      </div>
    </div><section id="registration-form" class="registration-form section">
      <div class="container" data-aos="fade-up">

        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <div class="section-title">
              <h2>Formulir Pendaftaran</h2>
              <p>Silakan isi data calon santri dengan lengkap dan benar.</p>
            </div>

            <form action="kirim.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label for="nama_santri" class="form-label">Nama Lengkap Calon Santri</label>
                  <input type="text" name="nama_santri" class="form-control" id="nama_santri" required>
                </div>

                <div class="col-md-12 mb-3">
                  <label for="nama_ortu" class="form-label">Nama Orang Tua / Wali</label>
                  <input type="text" class="form-control" name="nama_ortu" id="nama_ortu" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="no_hp" class="form-label">Nomor HP / WA (Aktif)</label>
                  <input type="tel" class="form-control" name="no_hp" id="no_hp" placeholder="Contoh: 08123456789" required>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="tgl_lahir" class="form-label">Tanggal Lahir Santri</label>
                  <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                </div>

                <div class="col-12 mb-3">
                  <label for="alamat" class="form-label">Alamat Lengkap</label>
                  <textarea class="form-control" name="alamat" rows="4" id="alamat" required></textarea>
                </div>

                <div class="col-12 mb-3">
                  <label for="pesan" class="form-label">Pesan / Catatan Tambahan (Opsional)</label>
                  <textarea class="form-control" name="pesan" rows="3" id="pesan" placeholder="Misal: Info pendaftaran dari..."></textarea>
                </div>
                
                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Pendaftaran Anda telah terkirim. Terima kasih!</div>
                  <button type="submit">Kirim Pendaftaran</button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </section>
    </main>
<?php
// 3. Memanggil Footer
include 'footer.php';

// 4. Tutup koneksi
mysqli_close($koneksi);
?> 