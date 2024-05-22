<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>Data Layanan 1</b>
            </div>
            <div class="panel-body">
            <a href="?halaman=layanan_tambah" class="btn btn-primary">Tambah Layanan</a>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Tarif Per Meter</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_layanan");
                            while ($data= $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['layanan']; ?></td>
                                <td><?php echo rupiah($data['tarif']); ?></td>                 
                                <td>
                                    <a href="?halaman=layanan_ubah&kode=<?php echo $data['id_layanan']; ?>" title="Ubah" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a href="?halaman=layanan_hapus&kode=<?php echo $data['id_layanan']; ?>" onclick="return confirm('Apakah anda yakin hapus layanan ini ?')" title="Hapus" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>Data Layanan 2</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                <a href="?halaman=layanan_tambah_beban" class="btn btn-primary">Tambah Beban</a>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Tarif Per Pengguna</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_beban");
                            while ($data= $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['beban']; ?></td>
                                <td><?php echo rupiah($data['harga_beban']); ?></td>                 
                                <td>
                                    <a href="?halaman=layanan_ubah_beban&kode=<?php echo $data['id_beban']; ?>" title="Ubah" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a href="?halaman=layanan_hapus_beban&kode=<?php echo $data['id_beban']; ?>" onclick="return confirm('Apakah anda yakin hapus layanan ini ?')" title="Hapus" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
