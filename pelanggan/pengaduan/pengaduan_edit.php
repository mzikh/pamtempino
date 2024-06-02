<?php
include "inc/koneksi.php";

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];
    $sql_cek = "SELECT * FROM tb_pengaduan WHERE id_pengaduan='$id_pengaduan'";
    $query_cek = $koneksi->query($sql_cek);
    $data_cek = $query_cek->fetch_assoc();

    if ($query_cek->num_rows > 0) {
        $tgl_pengaduan = $data_cek['tgl_pengaduan'];
        $subjek_pengaduan = $data_cek['subjek_pengaduan'];
        $deskripsi_pengaduan = $data_cek['deskripsi_pengaduan'];
        $foto_pengaduan = $data_cek['foto_pengaduan'];
    } else {
        echo "<script>alert('Pengaduan tidak ditemukan');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subjek_pengaduan = $koneksi->real_escape_string($_POST['subjek_pengaduan']);
    $deskripsi_pengaduan = $koneksi->real_escape_string($_POST['deskripsi_pengaduan']);

    // Ambil data file foto
    $file_foto = $_FILES['foto_pengaduan'];
    $nama_foto = $file_foto['name'];
    $tmp_foto = $file_foto['tmp_name'];

    // Cek apakah file foto ada atau tidak
    if (!empty($nama_foto)) {
        $fileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));
        if ($fileType!= "jpg" && $fileType!= "jpeg" && $fileType!= "png") {
            echo "<script>alert('Hanya file PNG, JPG, dan JPEG yang diizinkan');window.location='index.php?halaman=". sha1('p_pengaduan_edit'). "&id=$id_pengaduan'</script>";
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
            $sql = $koneksi->query("UPDATE tb_pengaduan SET subjek_pengaduan='$subjek_pengaduan', deskripsi_pengaduan='$deskripsi_pengaduan', foto_pengaduan='$nama_foto' WHERE id_pengaduan='$id_pengaduan'");

            if ($sql) {
                echo "<script>alert('Pengaduan berhasil diupdate');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
            } else {
                echo "<script>alert('Pengaduan gagal diupdate: ". $koneksi->error. "');window.location='index.php?halaman=pengaduan_edit&id=$id_pengaduan'</script>";
            }
        } else {
            echo "<script>alert('Foto gagal diupload');window.location='index.php?halaman=pengaduan_edit&id=$id_pengaduan'</script>";
        }
    } else {
        $sql = $koneksi->query("UPDATE tb_pengaduan SET subjek_pengaduan='$subjek_pengaduan', deskripsi_pengaduan='$deskripsi_pengaduan' WHERE id_pengaduan='$id_pengaduan'");

        if ($sql) {
            echo "<script>alert('Pengaduan berhasil diupdate');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
        } else {
            echo "<script>alert('Pengaduan gagal diupdate: ". $koneksi->error. "');window.location='index.php?halaman=pengaduan_edit&id=$id_pengaduan'</script>";
        }
    }
}
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <b>Detail Pengaduan</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan;?>">
                    <div class="form-group">
                        <label>Subjek</label>
                        <input type="text" name="subjek_pengaduan" class="form-control" value="<?php echo $subjek_pengaduan;?>" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea name="deskripsi_pengaduan" class="form-control" rows="5" required><?php echo $deskripsi_pengaduan;?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <input type="file" name="foto_pengaduan" class="form-control">
                        <?php if (!empty($foto_pengaduan)) {?>
                            <img src="uploads/pengaduan/<?php echo $foto_pengaduan;?>" alt="<?php echo $subjek_pengaduan;?>" width="300">
                        <?php }?>
                    </div>
                    <a href="index.php?halaman=<?php echo sha1('p_pengaduan_tampil');?>" class="btn btn-default">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Edit</button>                    
                </form>
            </div>
        </div>
    </div>
</div>