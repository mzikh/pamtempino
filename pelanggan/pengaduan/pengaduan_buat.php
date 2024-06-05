<?php
include "inc/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tgl_pengaduan = date('Y-m-d H:i:s');
    $subjek_pengaduan = $koneksi->real_escape_string($_POST['subjek_pengaduan']);
    $deskripsi_pengaduan = $koneksi->real_escape_string($_POST['deskripsi_pengaduan']);
    $id_pelanggan = $data_rek;

    // Ambil data file foto
    $file_foto = $_FILES['foto_pengaduan'];
    $nama_foto = $file_foto['name'];
    $tmp_foto = $file_foto['tmp_name'];

    // Cek apakah file foto ada atau tidak
    if (!empty($nama_foto)) {
      $fileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));
    if ($fileType!= "jpg" && $fileType!= "jpeg" && $fileType!= "png") {
        echo "<script>alert('Hanya file PNG, JPG, dan JPEG yang diizinkan');window.location='index.php?halaman=". sha1('p_pengaduan_buat'). "'</script>";
        exit;
    }
        // Set path folder foto
        $path_folder = "uploads/pengaduan/";
        $path_file = $path_folder. $nama_foto;

        // Cek apakah folder uploads ada atau tidak
        if (!file_exists($path_folder)) {
            mkdir($path_folder, 0777, true);
        }

        // Upload foto
        if (move_uploaded_file($tmp_foto, $path_file)) {
            $sql = $koneksi->query("INSERT INTO tb_pengaduan (tgl_pengaduan, id_pelanggan, subjek_pengaduan, deskripsi_pengaduan, foto_pengaduan, status_pengaduan) 
                                    VALUES ('$tgl_pengaduan', '$id_pelanggan', '$subjek_pengaduan', '$deskripsi_pengaduan', '$nama_foto', 'Pending')");

            if ($sql) {
                echo "<script>alert('Pengaduan berhasil disimpan');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
            } else {
                echo "<script>alert('Pengaduan gagal disimpan: ". $koneksi->error. "');window.location='index.php?halaman=pengaduan'</script>";
            }
        } else {
            echo "<script>alert('Foto gagal diupload');window.location='index.php?halaman=pengaduan'</script>";
        }
    } else {
        $sql = $koneksi->query("INSERT INTO tb_pengaduan (tgl_pengaduan, id_pelanggan, subjek_pengaduan, deskripsi_pengaduan, status_pengaduan) 
                                VALUES ('$tgl_pengaduan', '$id_pelanggan', '$subjek_pengaduan', '$deskripsi_pengaduan', 'Pending')");

        if ($sql) {
            echo "<script>alert('Pengaduan berhasil disimpan');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
        } else {
            echo "<script>alert('Pengaduan gagal disimpan: ". $koneksi->error. "');window.location='index.php?halaman=pengaduan'</script>";
        }
    }
}
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <b>Tambah Pengaduan</b>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
            
            
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan'];?>">
    <div class="form-group">
        <label>Subjek</label>
        <input type="text" name="subjek_pengaduan" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Deskripsi Pengaduan</label>
        <textarea name="deskripsi_pengaduan" class="form-control" rows="5" required></textarea>
    </div>
    <div class="form-group">
        <label>Foto Pengaduan</label>
        <input type="file" name="foto_pengaduan" class="form-control">
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
</form>