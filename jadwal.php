<?php
session_start();
include 'headerdev.php'; // Koneksi sudah ada di sini

// --- 1. PROSES TAMBAH JADWAL ---
if (isset($_POST['simpan_jadwal'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $id_guru = $_POST['id_guru'];

    $query_simpan = "INSERT INTO jadwal_mengajar (hari, jam_mulai, jam_selesai, kelas_jilid, id_guru) 
                     VALUES ('$hari', '$jam_mulai', '$jam_selesai', '$kelas', '$id_guru')";
    
    if (mysqli_query($koneksi, $query_simpan)) {
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location='kelolajadwaldev.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah jadwal.');</script>";
    }
}

// --- 2. PROSES HAPUS JADWAL ---
if (isset($_GET['hapus'])) {
    $id_jadwal = $_GET['hapus'];
    $query_hapus = "DELETE FROM jadwal_mengajar WHERE id_jadwal = '$id_jadwal'";
    mysqli_query($koneksi, $query_hapus);
    echo "<script>window.location='kelolajadwaldev.php';</script>";
}
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">📅 Kelola Jadwal Mengajar</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Jadwal Baru
    </button>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Daftar Jadwal Aktif</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kelas / Jilid</th>
                            <th>Guru Pengajar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query Join untuk mengambil nama guru dari tabel 'guru'
                        // Mengurutkan berdasarkan FIELD hari agar urut Senin-Minggu
                        $query = "SELECT j.*, g.nama 
                                  FROM jadwal_mengajar j 
                                  JOIN guru g ON j.id_guru = g.id_guru 
                                  ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), j.jam_mulai ASC";
                        
                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Format jam agar lebih rapi (hilangkan detik)
                                $jam = date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai']));
                        ?>
                                <tr>
                                    <td class="text-center fw-bold"><?php echo $row['hari']; ?></td>
                                    <td class="text-center"><?php echo $jam; ?></td>
                                    <td class="text-center"><span class="badge bg-info text-dark"><?php echo $row['kelas_jilid']; ?></span></td>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td class="text-center">
                                        <a href="kelolajadwaldev.php?hapus=<?php echo $row['id_jadwal']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus jadwal ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Belum ada jadwal dibuat.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="kelolajadwaldev.php" method="POST">
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select class="form-select" name="hari" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas / Jilid</label>
                        <select class="form-select" name="kelas" required>
                            <option value="">-- Pilih Jilid --</option>
                            <option value="Jilid 1">Jilid 1</option>
                            <option value="Jilid 2">Jilid 2</option>
                            <option value="Jilid 3">Jilid 3</option>
                            <option value="Jilid 4">Jilid 4</option>
                            <option value="Jilid 5">Jilid 5</option>
                            <option value="Jilid 6">Jilid 6</option>
                            <option value="Al-Qur'an">Al-Qur'an</option>
                            <option value="Ghorib">Ghorib</option>
                            <option value="Tajwid">Tajwid</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select class="form-select" name="id_guru" required>
                            <option value="">-- Pilih Guru --</option>
                            <?php
                            // Ambil data guru yang aktif
                            $q_guru = mysqli_query($koneksi, "SELECT id_guru, nama FROM guru ORDER BY nama ASC");
                            while ($g = mysqli_fetch_assoc($q_guru)) {
                                echo "<option value='" . $g['id_guru'] . "'>" . $g['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_jadwal" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footerdev.php';
?>