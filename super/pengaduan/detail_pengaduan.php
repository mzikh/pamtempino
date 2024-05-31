
<?php

include "inc/koneksi.php";

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];
    
    $sql_cek = "SELECT *, pl.nama_pelanggan 
                FROM tb_pengaduan p 
                LEFT JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                WHERE p.id_pengaduan='$id_pengaduan'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <b>Detail Pengaduan</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form>

                    <div class="form-group">
                        <label>Tanggal Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_pengaduan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input class="form-control" value="<?php echo $data_cek['nama_pelanggan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Subjek Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['subjek_pengaduan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea class="form-control" readonly><?php echo $data_cek['deskripsi_pengaduan'];?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Status Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['status_pengaduan'];?>" readonly/>
                        <button type="button" class="btn btn-primary" onclick="ubahStatus('<?php echo $data_cek['id_pengaduan'];?>')">Ubah Status</button>
                    </div>

                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <img src="uploads/pengaduan/<?php echo $data_cek['foto_pengaduan'];?>" alt="<?php echo $data_cek['subjek_pengaduan'];?>" width="300">
                    </div>

                    <div>
                        <a href="?halaman=lihat_pengaduan" title="Kembali" class="btn btn-default">Kembali</a>
                    </div>

            </div>
            </form>
        </div>

    </div>
</div>

<script>
    function ubahStatus(id_pengaduan) {
        var status = '';
        if ('<?php echo $data_cek['status_pengaduan'];?>' == 'Pending') {
            status = 'Proses';
        } else if ('<?php echo $data_cek['status_pengaduan'];?>' == 'Proses') {
            status = 'Selesai';
        }
$.ajax({
            url: "<?php echo $_SERVER['PHP_SELF'];?>",
            type: "POST",
            data: {
                id_pengaduan: id_pengaduan,
                status: status,
                ubah_status: true
            },
            success: function(response) {
                if (response == "success") {
                    alert("Status pengaduan berhasil diubah.");
                    window.location.reload();
                } else {
                    alert("Gagal mengubah status pengaduan.");
                }
            }
        });
    }
</script>

<?php
if (isset($_POST['ubah_status'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = $_POST['status_pengaduan'];
    
    $sql_ubah = "UPDATE tb_pengaduan SET status_pengaduan='$status' WHERE id_pengaduan='$id_pengaduan'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    
    if ($query_ubah) {
        echo "success";
    } else {
        echo "failed";
    }
}
?>
