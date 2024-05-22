<?php
include "inc/koneksi.php";  
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <b>Tambah Layanan</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">

                    <div class="form-group">
                        <label>Nama Layanan</label>
                        <input class="form-control" name="beban" placeholder="Masukkan nama Beban"/>
                    </div>

                    <div class="form-group">
                        <label>Tarif Per Pengguna</label>
                        <input class="form-control" name="harga_beban" placeholder="Masukkan tarif Beban"/>
                    </div>

                    <div>
                        <input type="submit" name="Simpan" value="Simpan" class="btn btn-success" >
                        <a href="?halaman=layanan_tampil" title="Kembali" class="btn btn-default">Batal</a>
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>


<?php

    if (isset ($_POST['Simpan'])){
        //mulai proses simpan data
        $sql_simpan = "INSERT INTO tb_beban (beban, harga_beban) VALUES (
        '".$_POST['beban']."',
        '".$_POST['harga_beban']."')";
        $query_simpan = mysqli_query($koneksi, $sql_simpan);
        if ($query_simpan) {
            echo "<script>alert('Simpan Berhasil')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
        }else{
            echo "<script>alert('Simpan Gagal')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=layanan_tampil'>";
        }
        //selesai proses simpan data
        }
    

?>