<?php
include "inc/koneksi.php";

// Handle form submission to update status
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['status'])) {
  $id_pengaduan = $_GET['id'];
  $status_pengaduan = $_GET['status'];

  // Update status pengaduan
  $stmt = $koneksi->prepare("UPDATE tb_pengaduan SET status_pengaduan = ? WHERE id_pengaduan = ?");
  $stmt->bind_param("si", $status_pengaduan, $id_pengaduan);
  
  if ($stmt->execute()) {
    echo "<script>alert('Status berhasil diperbarui');</script>";
  } else {
    echo "<script>alert('Gagal memperbarui status');</script>";
  }

  $stmt->close();
  
  // Redirect kembali ke halaman utama
  echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
}

// Handle form submission to create new pengaduan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Simpan'])) {
  // Mengaktifkan pelaporan kesalahan
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  // Asumsikan pengguna sudah login dan $id_pelanggan diambil dari sesi
  session_start();
  if (!isset($_SESSION['id_pelanggan'])) {
    die('User belum login');
  }

  $id_pelanggan = $_SESSION['id_pelanggan'];
  $subjek = $_POST['subjek'];
  $deskripsi = $_POST['deskripsi'];
  $tgl_pengaduan = date('Y-m-d H:i:s');
  $status_pengaduan = 'pending';
  $tgl_diselesaikan = NULL;

  // Menyiapkan pernyataan SQL dengan placeholder
  $stmt = $koneksi->prepare("INSERT INTO tb_pengaduan (id_pelanggan, tgl_pengaduan, subjek_pengaduan, deskripsi_pengaduan, status_pengaduan, tgl_diselesaikan) VALUES (?, ?, ?, ?, ?, ?)");

  if ($stmt === false) {
    // Debugging: Output pesan kesalahan
    die('Prepare failed: ' . htmlspecialchars($koneksi->error));
  }

  // Mengikat parameter ke placeholder
  $stmt->bind_param("isssss", $id_pelanggan, $tgl_pengaduan, $subjek, $deskripsi, $status_pengaduan, $tgl_diselesaikan);

  // Menjalankan pernyataan
  if ($stmt->execute()) {
    echo "<script>alert('Simpan Berhasil');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
  } else {
    echo "<script>alert('Simpan Gagal');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
  }

  // Menutup pernyataan
  $stmt->close();
}
?>


<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <b>Data Pengaduan</b>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Pengaduan</th>
                <th>Nama Pengadu</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $sql = $koneksi->query("SELECT p.*, pl.nama_pelanggan FROM tb_pengaduan p JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan");
              while ($data = $sql->fetch_assoc()) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $data['tgl_pengaduan']; ?></td>
                  <td><?php echo $data['nama_pelanggan']; ?></td>
                  <td><?php echo $data['subjek_pengaduan']; ?></td>
                  <td>
                    <?php if ($data['status_pengaduan'] == 'Pending') { ?>
                      <span class="label label-warning">Pending</span>
                    <?php } elseif ($data['status_pengaduan'] == 'Proses') { ?>
                      <span class="label label-info">Siap di cek</span>
                    <?php } else { ?>
                      <span class="label label-success">Sudah Selesai</span>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($data['status_pengaduan'] == 'Pending') { ?>
                        <a href="?id=<?php echo $data['id_pengaduan']; ?>&status=Proses" class="btn btn-info">Siap di cek</a>

                    <?php } elseif ($data['status_pengaduan'] == 'Proses') { ?>
                        <a href="?id=<?php echo $data['id_pengaduan']; ?>&status=Selesai" class="btn btn-success">Sudah Selesai</a>

                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

