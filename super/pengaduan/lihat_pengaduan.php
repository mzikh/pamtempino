<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                 <b>Data Pengaduan Pelanggan</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Nama Pelanggan</th>
                                <th>Subjek Pengaduan</th>
                                <th>Status Pengaduan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "inc/koneksi.php";

                            // Query untuk mengambil semua pengaduan pelanggan
                            $no = 1;
                            $sql = $koneksi->query("SELECT p.*, pl.nama_pelanggan FROM tb_pengaduan p JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan ORDER BY p.tgl_pengaduan DESC");

                            while ($data = $sql->fetch_assoc()) {
                          ?>
                            <tr>
                                <td><?= $no++;?></td>
                                <td><?= $data['tgl_pengaduan'];?></td>
                                <td><?= $data['nama_pelanggan'];?></td>
                                <td><?= $data['subjek_pengaduan'];?></td>
                                <td> 
                                    <?php 
                                    $warna = $data['status_pengaduan'];
                                    if ($warna == 'Pending') {?> 
                                        <span class="label label-warning">Pending</span>
                                    <?php } elseif ($warna == 'Proses') {?>
                                        <span class="label label-info">Proses</span>
                                    <?php } elseif($warna == 'Selesai') {?>
                                        <span class="label label-success">Selesai</span>
                                    <?php } else {?>
                                        <span class="label label-danger">Ditolak</span>
                                    <?php }?>
                                </td>
                                <td>
                                <a href="?halaman=detail_pengaduan&id=<?= $data['id_pengaduan'];?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            <?php
                            }
                          ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>