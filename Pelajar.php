<?php
// 1. Memanggil Header
include 'header.php';

/*
 * ===== PERBAIKAN KUNCI =====
 * Query diubah untuk TIDAK MENGAMBIL baris yang 'no_induk'-nya 0.
 * Ini akan otomatis menghilangkan baris (0, "Nama", "Alamat") yang aneh itu.
 */
$query_tabel = "SELECT * FROM santri WHERE no_induk != 0 ORDER BY nama ASC";
$result_tabel = mysqli_query($koneksi, $query_tabel);

// 3. Query untuk data diagram batang
$query_diagram = "SELECT Tahun_masuk, COUNT(*) as jumlah 
                  FROM santri 
                  GROUP BY Tahun_masuk 
                  ORDER BY Tahun_masuk ASC";
$result_diagram = mysqli_query($koneksi, $query_diagram);

// 4. Proses data diagram untuk JavaScript
$labels_diagram = [];
$data_diagram = [];
if ($result_diagram) { 
  while ($row = mysqli_fetch_assoc($result_diagram)) {
      $labels_diagram[] = "Masuk " . $row['Tahun_masuk']; 
      $data_diagram[] = $row['jumlah'];
  }
} else {
  echo "Error: Query diagram gagal - " . mysqli_error($koneksi);
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

    <style>
      th.sortable { 
        cursor: pointer; 
        user-select: none; 
      }
      th.sortable:hover { 
        background-color: #3d4857; 
      }
      th.sortable::after { 
        content: ' \2195';
        opacity: 0.4; 
        font-size: 0.9em;
        padding-left: 5px;
      }
      th.sortable[data-sort-dir="asc"]::after { 
        content: ' \25B2';
        opacity: 1; 
      }
      th.sortable[data-sort-dir="desc"]::after { 
        content: ' \25BC';
        opacity: 1; 
      }
      /* * Aturan CSS 'th:first-child::after' DIHAPUS.
       * Sekarang kolom pertama (No. Induk) BISA disort dan akan punya panah.
       */
    </style>
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
                    <th scope="col" class="sortable">No. Induk</th> 
                    <th scope="col" class="sortable">Nama</th>
                    <th scope="col" class="sortable">Alamat</th>
                    <th scope="col" class="sortable">Jilid</th>
                    <th scope="col" class="sortable">Tahun Masuk</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php
                  if ($result_tabel && mysqli_num_rows($result_tabel) > 0) {
                      // $nomor = 1; (Dihapus)
                      
                      while ($santri = mysqli_fetch_assoc($result_tabel)) {
                  ?>
                          <tr>
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
                      // PERBAIKAN: Colspan diubah ke 5
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

  <?php
  // Memanggil file footer.php
  include 'footer.php';
  ?>

  <script>
    const dataLabelsDariPHP = <?php echo json_encode($labels_diagram); ?>;
    const dataJumlahDariPHP = <?php echo json_encode($data_diagram); ?>;
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
      /**
       * BLOK 1: Logic untuk Diagram (Chart)
       */
      const setupChart = () => {
        if (typeof Chart === 'undefined') {
            console.error("Chart.js GAGAL dimuat (Pastikan ada di footer.php). Diagram tidak akan tampil.");
            return; 
        }

        const dataSantri = {
          labels: dataLabelsDariPHP,
          datasets: [{
            label: 'Jumlah Santri',
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
                  precision: 0, 
                  stepSize: 1
                }
              }
            },
            plugins: {
              legend: { display: false },
              title: {
                display: true,
                text: 'Jumlah Santri Berdasarkan Tahun Masuk'
              }
            }
          }
        };

        const ctx = document.getElementById('diagramTahunMasuk');
        if (ctx) {
          new Chart(ctx, configDiagram);
        } else {
          console.error("Elemen canvas 'diagramTahunMasuk' tidak ditemukan.");
        }
      }; // Akhir dari setupChart()

      /**
       * BLOK 2: Logic untuk Sorting Tabel
       */
      const setupSorting = () => {
        
        const getCellValue = (row, index) => {
          if (!row.cells[index]) return ''; 
          return row.cells[index].textContent.trim();
        }

        const compareRows = (rowA, rowB, index, isAscending) => {
            const valA = getCellValue(rowA, index);
            const valB = getCellValue(rowB, index);
            const isNumeric = !isNaN(valA) && !isNaN(valB) && valA.trim() !== '' && valB.trim() !== '';
            let comparison = 0;
            if (isNumeric) {
                comparison = parseFloat(valA) - parseFloat(valB);
            } else {
                comparison = valA.localeCompare(valB, 'id', { sensitivity: 'base' });
            }
            return isAscending ? comparison : -comparison;
        };

        const headers = document.querySelectorAll('#pelajar-table thead th.sortable');
        const tableBody = document.querySelector('#pelajar-table table tbody');

        if (!tableBody) {
            console.error("JavaScript GAGAL menemukan 'tbody' tabel. Sorting tidak akan jalan.");
            return; 
        }
        if (headers.length === 0) {
            console.error("JavaScript GAGAL menemukan 'th.sortable'. Sorting tidak akan jalan.");
            return; 
        }

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const columnIndex = Array.from(header.parentNode.cells).indexOf(header);
                
                /* * PERBAIKAN: Pengecekan 'if (columnIndex === 0) return;' DIHAPUS.
                 * Sekarang kolom pertama (No. Induk, index 0) BISA disort.
                 */

                const currentIsAscending = (header.getAttribute('data-sort-dir') || 'asc') === 'asc';
                const isAscending = !currentIsAscending;

                headers.forEach(h => h.removeAttribute('data-sort-dir'));
                header.setAttribute('data-sort-dir', isAscending ? 'asc' : 'desc');

                const rows = Array.from(tableBody.querySelectorAll('tr'));
                rows.sort((a, b) => compareRows(a, b, columnIndex, isAscending));
                tableBody.innerHTML = ''; 
                rows.forEach(row => tableBody.appendChild(row));
            });
        });
      }; // Akhir dari setupSorting()

      // --- JALANKAN KEDUA FUNGSI ---
      setupChart();
      setupSorting();
      
    });
  </script>