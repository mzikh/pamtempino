<div class="row">
  <div class="col-md-12">
    <!-- Advanced Tables -->
    <a href="?halaman=cc9b7c956e4e89f74028b82cef6c7e67432948fc" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
    <br><br>
    <div class="panel panel-info">
      <div class="panel-heading">
        <b>Data Pengaduan</b>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Pengaduan</th>
                <th>Nama Pengadu</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            <?php
$no = 1;
$sql = $koneksi->query("SELECT p.*, pl.nama_pelanggan AS nama_pelanggan 
                        FROM tb_pengaduan p 
                        LEFT JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                        WHERE p.id_pelanggan = '$data_rek'");
while ($data = $sql->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $data['tgl_pengaduan'];?></td>
        <td><?php echo $data['nama_pelanggan'];?></td>
        <td><?php echo $data['subjek_pengaduan'];?></td>
    <?php $warna = $data['status_pengaduan']; ?>
        

<td> 
    <?php if ($warna == 'Pending') { ?> 
        <span class="label label-warning">Pending</span>
    <?php } elseif ($warna == 'Proses') { ?>
        <span class="label label-info">Proses</span>
    <?php } else { ?>
        <span class="label label-success">Selesai</span>
    <?php } ?>
</td>

        <td>
            <a href="?halaman=pengaduan_detail&kode=<?php echo $data['id_pengaduan']; ?>" title="Detail" class="btn btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
            <a href="?halaman=pengaduan_ubah&kode=<?php echo $data['id_pengaduan']; ?>" title="Ubah" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i></a>
            <a href="?halaman=pengaduan_hapus&kode=<?php echo $data['id_pengaduan']; ?>" onclick="return confirm('Apakah anda yakin hapus pengaduan ini?')" title="Hapus" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
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
