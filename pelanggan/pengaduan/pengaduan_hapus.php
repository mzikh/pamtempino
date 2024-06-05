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
    $sql = $koneksi->query("DELETE FROM tb_pengaduan WHERE id_pengaduan='$id_pengaduan'");

    if ($sql) {
        echo "<script>alert('Pengaduan berhasil dihapus');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
    } else {
        echo "<script>alert('Pengaduan gagal dihapus: ". $koneksi->error. "');window.location='index.php?halaman=pengaduan_hapus&id=$id_pengaduan'</script>";
    }
}
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <b>Hapus Pengaduan</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan;?>">
                    <p>Anda yakin ingin menghapus pengaduan dengan subjek "<?php echo $subjek_pengaduan;?>"?</p>
                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                    <a href="index.php?halaman=<?php echo sha1('p_pengaduan_tampil');?>" class="btn btn-default">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>