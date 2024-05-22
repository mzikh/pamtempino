<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <a href="?halaman=pakai_tambah" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
                    <br><br>
                    <div class="form-group">
    <label>Pilih Bulan:</label>
    <select class="form-control" id="bulan" name="bulan">
        <option value="">-- Pilih Bulan --</option>
        <?php
        // Ambil data bulan dari tabel tb_bulan
        $query_bulan = "SELECT * FROM tb_bulan";
        $result_bulan = mysqli_query($koneksi, $query_bulan);
        while ($row_bulan = mysqli_fetch_assoc($result_bulan)) {
            echo "<option value='" . $row_bulan['id_bulan'] . "'>" . $row_bulan['nama_bulan'] . "</option>";
        }
        ?>
    </select>
</div>

<div class="form-group">
    <label>Pilih Tahun:</label>
    <input class="form-control" type="number" id="tahun" name="tahun" min="2000" max="2099" value="<?php echo date('Y'); ?>">
</div>
<button type="button" class="btn btn-primary" onclick="getData()" style="margin-bottom: 10px;">Tampilkan Data</button>


                    <div class="panel panel-info">
                        <div class="panel-heading">
                             <b>Data Pemakaian</b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID | Nama Pelanggan</th>
                                            <th>Bulan - Tahun</th>
                                            <th>Meter Awal</th>
                                            <th>Meter Akhir</th>
                                            <th>Aksi</th>

                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                    
                                    <?php

                                    $no = 1;
                                    $sql = $koneksi->query("select p.id_pelanggan, p.nama_pelanggan, k.id_pakai, k.tahun, k.awal, k.akhir, b.nama_bulan, t.status 
                                    from tb_pelanggan p inner join tb_pakai k on p.id_pelanggan=k.id_pelanggan
                                    inner join tb_tagihan t on k.id_pakai=t.id_pakai
                                    inner join tb_bulan b on k.bulan=b.id_bulan
                                    order by tahun desc, id_bulan desc");
                                    while ($data= $sql->fetch_assoc()) {

                                    ?>

                                    <tr>
                                        <td><?php echo $no++; ?></td>  
                                        <td><?php echo $data['id_pelanggan']; ?> - <?php echo $data['nama_pelanggan']; ?></td>
                                        <td><?php echo $data['nama_bulan']; ?> - <?php echo $data['tahun']; ?></td>
                                        <td><?php echo $data['awal']; ?> M<sup> 3</sup></td> 
                                        <td><?php echo $data['akhir']; ?> M<sup> 3</sup></td>   
                                             
                                        <td>

                                            <?php $stt = $data['status']  ?>
                                            <?php if ($stt == 'Belum Bayar') { ?>
                                                <a href="?halaman=pakai_hapus&kode=<?php echo $data['id_pakai']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                            <?php } elseif ($stt == 'Lunas') { ?> 
                                                <span class="label label-primary">Lunas</span>
                                            </td>
                                            <?php } ?>

                                        </td>

                                    </tr>
                                    <?php
                                    }
                                    ?>

                                    </tbody>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



<script>
    function getData() {
        var bulan = document.getElementById('bulan').value;
        var tahun = document.getElementById('tahun').value;

        // Kirim permintaan AJAX
        $.ajax({
            url: 'inc/DataPemakaian.php',
            type: 'POST',
            data: { bulan: bulan, tahun: tahun },
            success: function(response) {
                // Perbarui tabel dengan data yang diterima
                $('#dataTables-example tbody').html(response);
            }
        });
    }
</script>
