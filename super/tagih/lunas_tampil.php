<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="form-group">
            <label>Pilih Bulan:</label>
            <select class="form-control" id="bulan" name="bulan">
                <option value="">-- Pilih Bulan --</option>
                <?php
                // Ambil data bulan dari tabel tb_bulan
                $query_bulan = "SELECT * FROM tb_bulan";
                $result_bulan = mysqli_query($koneksi, $query_bulan);
                while ($row_bulan = mysqli_fetch_assoc($result_bulan)) {
                    echo "<option value='" . $row_bulan['nama_bulan'] . "'>" . $row_bulan['nama_bulan'] . "</option>";
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
                <b>Tagihan Lunas</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID | Nama Pelanggan</th>
                                <th>Bulan - Tahun</th>
                                <th>Pemakaian</th>
                                <th>Tagihan</th>
                                <th>Tgl Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("select p.id_pelanggan, p.nama_pelanggan, t.id_tagihan, t.tagihan, t.status,
                                    k.tahun, k.pakai, b.tgl_bayar, bl.nama_bulan
                                    from tb_pelanggan p inner join tb_pakai k on p.id_pelanggan=k.id_pelanggan
                                    inner join tb_tagihan t on k.id_pakai=t.id_pakai
                                    inner join tb_pembayaran b on t.id_tagihan=b.id_tagihan
                                    inner join tb_bulan bl on k.bulan=bl.id_bulan where t.status='Lunas' order by tgl_bayar desc, tahun desc, id_bulan desc");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['id_pelanggan']; ?> - <?php echo $data['nama_pelanggan']; ?></td>
                                    <td><?php echo $data['nama_bulan']; ?> - <?php echo $data['tahun']; ?></td>
                                    <td><?php echo $data['pakai']; ?> M<sup> 3</sup></td>
                                    <td><?php echo rupiah($data['tagihan']); ?></td>
                                    <td><?php $tgl = $data['tgl_bayar'];
                                        echo date("d - M - Y", strtotime($tgl)) ?></td>
                                    <td>
                                        <a href="./report/cetak_pembayaran.php?id_tagihan=<?php echo $data['id_tagihan']; ?>" target=" _blank" title="Cetak Struk Pembayaran" class="btn btn-success"><i class="glyphicon glyphicon-print"></i></a>
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

        console.log(bulan)
        // Kirim permintaan AJAX
        $.ajax({
            url: 'inc/DataSudahLunas.php',
            type: 'POST',
            data: {
                bulan: bulan,
                tahun: tahun
            },
            success: function(response) {
                // Perbarui tabel dengan data yang diterima
                $('#dataTables-example tbody').html(response);
            }
        });
    }
</script>