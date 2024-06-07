<?php
include "inc/koneksi.php";

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];
    $sql_cek = "SELECT * FROM tb_pengaduan WHERE id_pengaduan='$id_pengaduan'";
    $query_cek = $koneksi->query($sql_cek);
    $data_cek = $query_cek->fetch_assoc();

    if ($query_cek->num_rows > 0) {
        $tgl_pengaduan = $data_cek['tgl_pengaduan'];
        $tgl_diselesaikan = $data_cek['tgl_diselesaikan'];
        $subjek_pengaduan = $data_cek['subjek_pengaduan'];
        $deskripsi_pengaduan = $data_cek['deskripsi_pengaduan'];
        $foto_pengaduan = $data_cek['foto_pengaduan'];
        $keterangan = $data_cek['keterangan'];
        $bukti_pengaduan = $data_cek['bukti_pengaduan'];
    } else {
        echo "<script>alert('Pengaduan tidak ditemukan');window.location='index.php?halaman=". sha1('p_pengaduan_tampil'). "'</script>";
        exit;
    }
}
$foto_pengaduan_tampil = 'none';
$tgl_diselesaikan_tampil = 'none';
$button_alasan = 'none';

if ($data_cek['status_pengaduan'] == 'Selesai') {
    $foto_pengaduan_tampil = ''; $tgl_diselesaikan_tampil = '';$butki_display = ''; $button_display = 'none';

} else if ($data_cek['status_pengaduan'] == 'Batal') {
    $button_alasan = '';
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

                    <div class="form-group">
                        <label>Tanggal Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_pengaduan'];?>" readonly>
                    </div>

                    <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan;?>">
                    <div class="form-group">
                        <label>Subjek</label>
                        <input type="text" name="subjek_pengaduan" class="form-control" value="<?php echo $subjek_pengaduan;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea name="deskripsi_pengaduan" class="form-control" rows="5" readonly><?php echo $deskripsi_pengaduan;?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <br>
                        <?php if (!empty($foto_pengaduan)) {?>
                            <img src="uploads/pengaduan/<?php echo $foto_pengaduan;?>" alt="<?php echo $subjek_pengaduan;?>" width="300">
                        <?php }?>
                    </div>

                    <div class="form-group" style="display: <?php echo $button_alasan; ?>;">
                        <label>Alasan Pembatalan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3" readonly><?php echo $data_cek['keterangan']; ?></textarea>
                    </div>

                    <div class="form-group" style="display: <?php echo $tgl_diselesaikan_tampil; ?>;">
                        <label>Tanggal Pengaduan Selesai</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_diselesaikan'];?>" readonly>
                    </div>
                    <div class="form-group" style="display: <?php echo $foto_pengaduan_tampil; ?>;">
                        <label>Foto bukti Pengaduan</label>
                        <br>
                        <?php if (!empty($foto_pengaduan)) {?>
                            <img src="uploads/bukti_pengaduan/<?php echo $bukti_pengaduan;?>" alt="<?php echo $subjek_pengaduan;?>" width="300" >
                        <?php }?>
                    </div>

                    <a href="index.php?halaman=<?php echo sha1('p_pengaduan_tampil');?>" class="btn btn-default">Kembali</a>
                                     
                </form>
            </div>
        </div>
    </div>
</div>