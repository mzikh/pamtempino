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
$edit_button = 'none';
$hapus_button = 'none';
$lihat_button = 'none';

if ($data['status_pengaduan'] == 'Pending') {
  $edit_button = ''; $hapus_button = '';

} else if ($data['status_pengaduan'] == 'Proses') {
  $lihat_button = ''; 
}  
 else if ($data['status_pengaduan'] == 'Selesai') {
  $lihat_button = ''; 
} 
  else if ($data['status_pengaduan'] == 'Batal') {
  $lihat_button = ''; 
} 
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
    <?php } elseif ($warna == 'Selesai') { ?>
        <span class="label label-success">Selesai</span>
    <?php } else { ?>
        <span class="label label-danger">Ditolak</span>
    <?php }?>
</td>

        <td>
            <a href="index.php?halaman=<?php echo sha1('p_pengaduan_edit');?>&id=<?= $data['id_pengaduan'];?>" class="btn btn-success " style="display: <?php echo $edit_button; ?>;"><i class="glyphicon glyphicon-edit"></i> </a>
            <a href="index.php?halaman=<?php echo sha1('p_pengaduan_hapus');?>&id=<?= $data['id_pengaduan'];?>" onclick="return confirm('Apakah anda yakin hapus pengaduan ini?')" title="Hapus" class="btn btn-danger" style="display: <?php echo $hapus_button; ?>;"><i class="glyphicon glyphicon-trash"></i></a>
            <a href="index.php?halaman=<?php echo sha1('p_pengaduan_lihat');?>&id=<?= $data['id_pengaduan'];?>" class="btn btn-info" style="display: <?php echo $lihat_button; ?>;"><i class="fa fa-eye"></i></a>
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

