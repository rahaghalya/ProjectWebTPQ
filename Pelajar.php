<?php
// 1. Memanggil Header
include 'header.php';

/*
 * Query untuk data tabel
 */
$query_tabel = "SELECT * FROM santri WHERE no_induk != 0 ORDER BY nama ASC";
$result_tabel = mysqli_query($koneksi, $query_tabel);

// Debug jumlah data
$total_data = mysqli_num_rows($result_tabel);

/*
 * Query untuk data diagram batang
 */
$query_diagram = "SELECT Tahun_masuk, COUNT(*) as jumlah 
                  FROM santri 
                  WHERE no_induk != 0
                  GROUP BY Tahun_masuk 
                  ORDER BY Tahun_masuk ASC";
$result_diagram = mysqli_query($koneksi, $query_diagram);

// Proses data diagram untuk JavaScript
$labels_diagram = [];
$data_diagram = [];
if ($result_diagram) {
  while ($row = mysqli_fetch_assoc($result_diagram)) {
    $labels_diagram[] = $row['Tahun_masuk'];
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

  <!-- Bagian Diagram (Chart) -->
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

  <!-- Bagian Tabel Data -->
  <section id="pelajar-table" class="pelajar-table section light-background">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Detail Data Santri</h2>
            <p>Daftar Santri TPQ Roudlotul Ilmi</p>
          </div>
          <div class="table-responsive">

            <!-- ID tabelData SANGAT PENTING untuk DataTables -->
            <table id="tabelData" class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th scope="col">No. Induk</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Jilid</th>
                  <th scope="col">Tahun Masuk</th>
                </tr>
              </thead>
              <tbody>

                <?php
                // Reset pointer result untuk digunakan kembali
                mysqli_data_seek($result_tabel, 0);

                if ($result_tabel && $total_data > 0) {
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
                  }
                } else {
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

<!-- Data dari PHP untuk JavaScript -->
<script>
  const dataLabelsDariPHP = <?php echo json_encode($labels_diagram); ?>;
  const dataJumlahDariPHP = <?php echo json_encode($data_diagram); ?>;
  const totalDataDariPHP = <?php echo $total_data; ?>;
</script>

<!-- Library JS (jQuery, Bootstrap, DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(document).ready(function() {
    console.log("Total data dari PHP:", totalDataDariPHP);

    // --- 1. Inisialisasi DataTables dengan konfigurasi lengkap ---
    var table = $('#tabelData').DataTable({
      "pageLength": 50,
      "lengthMenu": [10, 25, 50, 100],
      "language": {
        "emptyTable": "Tidak ada data santri",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
        "infoFiltered": "(disaring dari _MAX_ total entri)",
        "lengthMenu": "Tampilkan _MENU_ entri",
        "loadingRecords": "Memuat...",
        "processing": "Memproses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ditemukan data yang sesuai",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Berikutnya",
          "previous": "Sebelumnya"
        }
      },
      "order": [
        [1, 'asc']
      ], // Urutkan berdasarkan kolom Nama (index 1)
      "responsive": true,
      "autoWidth": false,
      "drawCallback": function(settings) {
        console.log("DataTables draw completed. Showing:", settings._iDisplayLength, "entries");
      }
    });

    // Log informasi DataTables
    console.log("DataTables initialized. Total records:", table.rows().count());

    // --- 2. Logika untuk Diagram (Chart) ---
    if (typeof Chart === 'undefined') {
      console.error("Chart.js GAGAL dimuat. Diagram tidak akan tampil.");
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
            },
            title: {
              display: true,
              text: 'Jumlah Santri'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Tahun Masuk'
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          },
          title: {
            display: true,
            text: 'Jumlah Santri Berdasarkan Tahun Masuk'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `Jumlah: ${context.parsed.y} santri`;
              }
            }
          }
        }
      }
    };

    const ctx = document.getElementById('diagramTahunMasuk');
    if (ctx) {
      new Chart(ctx, configDiagram);
      console.log("Chart berhasil dibuat");
    } else {
      console.error("Elemen canvas 'diagramTahunMasuk' tidak ditemukan.");
    }
  });
</script>

<!-- Debug Information -->
<div style="display:none;">
  <!-- Debug: Jumlah data dari query = <?php echo $total_data; ?> -->
  <!-- Debug: Labels Diagram = <?php echo count($labels_diagram); ?> -->
  <!-- Debug: Data Diagram = <?php echo count($data_diagram); ?> -->
</div>