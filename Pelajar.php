<?php
// 1. Memanggil Header
// (File ini akan otomatis memanggil 'koneksi.php' juga)
include 'header.php';

// 2. Query untuk mengambil data tabel
// Diubah: Query mengambil dari tabel 'santri'
$query_tabel = "SELECT * FROM santri ORDER BY nama ASC";
$result_tabel = mysqli_query($koneksi, $query_tabel);

// 3. Query untuk data diagram batang
// Mengelompokkan data berdasarkan tahun_masuk dan menghitung jumlahnya
$query_diagram = "SELECT Tahun_masuk, COUNT(*) as jumlah 
                  FROM santri 
                  GROUP BY Tahun_masuk 
                  ORDER BY Tahun_masuk ASC";
$result_diagram = mysqli_query($koneksi, $query_diagram);

// 4. Proses data diagram untuk JavaScript
$labels_diagram = [];
$data_diagram = [];
while ($row = mysqli_fetch_assoc($result_diagram)) {
    // Menambahkan "Masuk " sebagai awalan label
    $labels_diagram[] = "Masuk " . $row['Tahun_masuk']; 
    $data_diagram[] = $row['jumlah'];
}
?>
  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Data Santri</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Data Santri</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="diagram-santri" class="diagram-santri section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Statistik Santri</h2>
        <p>Jumlah Santri Berdasarkan Tahun Masuk</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div style="background: var(--surface-color); padding: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
              <canvas id="diagramTahunMasuk"></canvas>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="pelajar-table" class="pelajar-table section light-background">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-12">
            
            <div class="section-title">
              <h2>Detail Data Santri</h2>
              <p>Daftar Santri TPQ Roudlotul Ilmi</p>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Jilid</th>
                    <th scope="col">Tahun Masuk</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php
                  // Cek apakah query berhasil dan ada datanya
                  if ($result_tabel && mysqli_num_rows($result_tabel) > 0) {
                      $nomor = 1; // Untuk penomoran baris
                      
                      // Loop untuk setiap baris data santri
                      while ($santri = mysqli_fetch_assoc($result_tabel)) {
                  ?>
                        <tr>
                          <th scope="row"><?php echo $nomor++; ?></th>
                          <td><?php echo htmlspecialchars($santri['no_induk']); ?></td>
                          <td><?php echo htmlspecialchars($santri['nama']); ?></td>
                          <td><?php echo htmlspecialchars($santri['Alamat']); ?></td>
                          <td><?php echo htmlspecialchars($santri['jilid']); ?></td>
                          <td><?php echo htmlspecialchars($santri['Tahun_masuk']); ?></td>
                        </tr>
                  <?php
                      } // Akhir while loop
                  } else {
                      // Tampilkan pesan jika tidak ada data
                      echo '<tr><td colspan="5" class="text-center">Belum ada data santri.</td></tr>';
                  }
                  ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    </main>
    <script>
    const dataLabelsDariPHP = <?php echo json_encode($labels_diagram); ?>;
    const dataJumlahDariPHP = <?php echo json_encode($data_diagram); ?>;
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
      const dataSantri = {
        // DIUBAH: Mengambil data dari variabel PHP
        labels: dataLabelsDariPHP,
        datasets: [{
          label: 'Jumlah Santri',
          // DIUBAH: Mengambil data dari variabel PHP
          data: dataJumlahDariPHP,
          backgroundColor: 'rgba(9, 148, 125, 0.6)', 
          borderColor: 'rgba(9, 148, 125, 1)',
          borderWidth: 1
        }]
      };

      const configDiagram = {
        type: 'bar',
        data: dataSantri,
        options: {
          responsive: true,
          maintainAspectRatio: false, 
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          },
          plugins: {
            legend: {
              display: false 
            },
            title: {
              display: true,
              text: 'Jumlah Santri Berdasarkan Tahun Masuk'
            }
          }
        }
      };

      // Render diagram di canvas
      const ctx = document.getElementById('diagramTahunMasuk');
      if (ctx) {
        new Chart(ctx, configDiagram);
      } else {
        console.error("Elemen canvas 'diagramTahunMasuk' tidak ditemukan.");
      }
    });
  </script>

  <?php
  // Memanggil file footer.php
  // File ini seharusnya berisi semua kode HTML dari <footer ...> sampai </footer>
  include 'footer.php';
  ?>
  