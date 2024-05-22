<?php
$data_cek = array('id_beban' => '', 'beban' => '', 'harga_beban' => ''); // Inisialisasi dengan nilai default

if(isset($_GET['kode'])){
    $sql_cek = "SELECT * FROM tb_beban WHERE id_beban='".$_GET['kode']."'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    
    if($query_cek && mysqli_num_rows($query_cek) > 0){
        $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
    }
}
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <b>Ubah Beban</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <input type='hidden' class="form-control" name="id_beban" value="<?php echo $data_cek['id_beban']; ?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Nama Beban</label>
                        <input class="form-control" name="beban" value="<?php echo $data_cek['beban']; ?>"/>
                    </div>

                    <div class="form-group">
                        <label>Tarif Per Pengguna</label>
                        <input class="form-control" name="harga_beban" value="<?php echo $data_cek['harga_beban']; ?>"/>
                    </div>

                    <div>
                        <input type="submit" name="Ubah" value="Ubah" class="btn btn-success" >
                        <a href="?halaman=layanan_tampil" title="Kembali" class="btn btn-default">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset ($_POST['Ubah'])){
    //mulai proses ubah
    $sql_ubah = "UPDATE tb_beban SET
        beban='".$_POST['beban']."',
        harga_beban='".$_POST['harga_beban']."'
        WHERE id_beban='".$_POST['id_beban']."'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    if ($query_ubah) {
        echo "<script>alert('Ubah Berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
    }else{
        echo "<script>alert('Ubah Gagal')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
    }

    //selesai proses ubah
}
?>
