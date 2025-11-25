<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';
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
    </div>

    <section id="registration-form" class="registration-form section">
      <div class="container" data-aos="fade-up">

        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <div class="section-title">
              <h2>Formulir Pendaftaran</h2>
              <p>Silakan isi data calon santri dengan lengkap dan benar.</p>
            </div>

            <a href="formulirdownload.php" class="btn btn-success" target="_blank">
               <i class="bi bi-download"></i> Download Formulir Pendaftaran (PDF)
            </a>

            <form id="form-pendaftaran" action="kirim.php" method="post" role="form">
              <div class="row">
                
                <div class="col-md-12 mb-3">
                  <label for="Nama" class="form-label">Nama Lengkap Calon Santri</label>
                  <input type="text" name="Nama" class="form-control" id="Nama" required>
                </div>

                <div class="col-md-12 mb-3">
                  <label for="Nama_orang_tua" class="form-label">Nama Orang Tua / Wali</label>
                  <input type="text" class="form-control" name="Nama_orang_tua" id="Nama_orang_tua" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="Tempat_lahir" class="form-label">Tempat Lahir</label>
                  <input type="text" class="form-control" name="Tempat_lahir" id="Tempat_lahir" placeholder="Contoh: Surabaya" required>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="Tanggal_lahir" class="form-label">Tanggal Lahir Santri</label>
                  <input type="date" class="form-control" name="Tanggal_lahir" id="Tanggal_lahir" required>
                </div>

                <div class="col-12 mb-3">
                  <label for="Alamat" class="form-label">Alamat Lengkap</label>
                  <textarea class="form-control" name="Alamat" rows="4" id="Alamat" required></textarea>
                </div>
                <div class="col-12 text-center">
                  <button type="submit" onclick="return confirm('Apakah Anda yakin data yang diisi sudah benar?')">
                    Kirim Pendaftaran
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Ambil formulir berdasarkan 'id' yang tadi kita buat
  var formPendaftaran = document.getElementById('form-pendaftaran');

  // Tambahkan 'event listener' saat formulir di-submit
  formPendaftaran.addEventListener('submit', function(e) {
    
    // 1. Hentikan aksi 'submit' bawaan
    e.preventDefault(); 

    // 2. Tampilkan popup SweetAlert
    Swal.fire({
      title: 'Konfirmasi Pendaftaran',
      text: "Apakah Anda yakin data yang diisi sudah benar?",
      icon: 'question', // Ikon tanda tanya
      showCancelButton: true,
      confirmButtonColor: '#3085d6', // Warna tombol OK (biru)
      cancelButtonColor: '#d33',    // Warna tombol Batal (merah)
      confirmButtonText: 'Ya, Kirim Sekarang!',
      cancelButtonText: 'Cek Lagi'
    }).then((result) => {
      // 3. Jika pengguna menekan tombol "Ya, Kirim Sekarang!"
      if (result.isConfirmed) {
        // Lanjutkan proses 'submit' formulir
        formPendaftaran.submit();
      }
    });
    
  });
</script>

<?php
// 3. Memanggil Footer
include 'footer.php';

// 4. Tutup koneksi
mysqli_close($koneksi);
?>