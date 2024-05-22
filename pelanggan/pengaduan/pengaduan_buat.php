<?php
include "inc/koneksi.php";

?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Form Pengaduan</h3>
        </div>
        <div class="panel-body">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="subjek">Subjek Pengaduan:</label>
              <select class="form-control" id="subjek" name="subjek" required>
                <option value="">Pilih Subjek Pengaduan</option>
                <option value="Layanan Pelanggan">Layanan Pelanggan</option>
                <option value="Teknologi Informasi">Teknologi Informasi</option>
                <option value="Keuangan">Keuangan</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi Pengaduan:</label>
              <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
            </div>
            <div class="form-group">
              <label for="foto">Upload Foto:</label>
              <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary" name="Simpan">Kirim Pengaduan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['Simpan'])) {
  // Mengaktifkan pelaporan kesalahan
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  // Asumsikan pengguna sudah login dan $id_pelanggan diambil dari sesi
  if (!isset($_SESSION['id_pelanggan'])) {
      die('User belum login');
  }

  $id_pelanggan = $_SESSION['id_pelanggan'];
  $subjek = $_POST['subjek'];
  $deskripsi = $_POST['deskripsi'];
  $tgl_pengaduan = date('Y-m-d H:i:s');
  $status_pengaduan = 'pending';
  $tgl_diselesaikan = NULL;

  // Handle file upload
  $foto = null;
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
      $uploadDir = 'uploads/';
      $uploadFile = $uploadDir. basename($_FILES['foto']['name']);
      if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
          $foto = $_FILES['foto']['name'];
      } else {
          echo "<script>alert('Upload Foto Gagal');</script>";
          echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
          exit;
      }
  }

  try {
      // Menyiapkan pernyataan SQL dengan placeholder
      $stmt = $koneksi->prepare("INSERT INTO tb_pengaduan (id_pelanggan, tgl_pengaduan, subjek_pengaduan, deskripsi_pengaduan, status_pengaduan, tgl_diselesaikan, foto) VALUES (?,?,?,?,?,?,?)");

      if ($stmt === false) {
          throw new Exception('Prepare failed: '. htmlspecialchars($koneksi->error));
      }

      // Mengikat parameter ke placeholder
      $stmt->bind_param("issssss", $id_pelanggan, $tgl_pengaduan, $subjek, $deskripsi, $status_pengaduan, $tgl_diselesaikan, $foto);

      // Menjalankan pernyataan
      $stmt->execute();

      // Menutup pernyataan
      $stmt->close();

      echo "<script>alert('Simpan Berhasil');</script>";
      echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
  } catch (Exception $e) {
      echo "<script>alert('Simpan Gagal: ". $e->getMessage(). "');</script>";
      echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
  }
}
?>
