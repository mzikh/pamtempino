<?php
include "inc/koneksi.php";

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengaduan = $_POST['id'];
    $current_status = $_POST['current_status'];
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';


    // Determine the new status based on the current status
    $new_status = '';
    if ($current_status == 'Pending')  {
        if (isset($_POST['cancel'])) { // check if the cancel button was clicked
            $new_status = 'Batal';
        } else {
            $new_status = 'Proses';
        } 
        }else if ($current_status == 'Batal'){
            if (isset($_POST['batalcancel'])) { // check if the cancel button was clicked
                $new_status = 'Pending';
                $keterangan = '';
            } else {
                $new_status = 'Batal';
            } 
            }
            
        else if ($current_status == 'Proses') {
        $new_status = 'Selesai';
        }

    // If a file was uploaded, handle the file upload
    if (isset($_FILES['bukti_pengaduan']) && $_FILES['bukti_pengaduan']['error'] == 0) {
        $upload_dir = 'uploads/bukti_pengaduan/';
        $file_name = basename($_FILES['bukti_pengaduan']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['bukti_pengaduan']['tmp_name'], $target_file)) {
            $sql_update = "UPDATE tb_pengaduan SET status_pengaduan='$new_status', bukti_pengaduan='$file_name', keterangan='$keterangan' WHERE id_pengaduan='$id_pengaduan'";
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        $sql_update = "UPDATE tb_pengaduan SET status_pengaduan='$new_status', keterangan='$keterangan' WHERE id_pengaduan='$id_pengaduan'";
    }

    $query_update = mysqli_query($koneksi, $sql_update);

    if ($query_update) {
        echo "<script>window.location = '?halaman=lihat_pengaduan';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}

// Fetch and display the complaint details
if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];
    
    $sql_cek = "SELECT *, pl.nama_pelanggan 
                FROM tb_pengaduan p 
                LEFT JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                WHERE p.id_pengaduan='$id_pengaduan'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

    // Set button text based on the current status
    $button_text = "";
    if ($data_cek['status_pengaduan'] == 'Pending') {
        $button_text = "Proses";
    } else if ($data_cek['status_pengaduan'] == 'Proses') {
        $button_text = "Selesai";
    } else {
        $button_text = "Selesai";
    }

    // Determine the display status of the upload field and button disable state
    $upload_field_display = 'none';
    $tgl_diselesaikan_input = 'none';
    $butki_display = 'none';
    $button_disabled = '';
    $batalkan_btn = 'none';
    $button_alasan = 'none';
    $button_read = '';
    $batalkan_tolak = 'none';

    if ($data_cek['status_pengaduan'] == 'Proses') {
        $upload_field_display = 'block'; 
        $button_disabled = 'disable'; 
    
    } else if ($data_cek['status_pengaduan'] == 'Pending') {
        $batalkan_btn = '';
    } 
    
    else if ($data_cek['status_pengaduan'] == 'Selesai') {
        $butki_display = ''; 
        $button_display = 'none'; 
        $tgl_diselesaikan_input = '';
    } 
    else if ($data_cek['status_pengaduan'] == 'Batal') {
        $button_display = 'none';
        $button_alasan = '';
        $button_read = 'readonly';
        $batalkan_tolak_button = 'Pulihkan';
        $batalkan_tolak = '';
    }

}
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <b>Detail Pengaduan</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form id="ubahStatusForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $data_cek['id_pengaduan']; ?>" />
                    <input type="hidden" name="current_status" value="<?php echo $data_cek['status_pengaduan']; ?>" />
                    
                    <div class="form-group">
                        <label>Tanggal Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_pengaduan']; ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input class="form-control" value="<?php echo $data_cek['nama_pelanggan']; ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label>Subjek Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['subjek_pengaduan']; ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea class="form-control" readonly><?php echo $data_cek['deskripsi_pengaduan']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <br>
                        <img src="uploads/pengaduan/<?php echo $data_cek['foto_pengaduan']; ?>" alt="<?php echo $data_cek['subjek_pengaduan']; ?>" width="300">
                    </div>

                    <div class="form-group" id="uploadField" style="display: <?php echo $upload_field_display; ?>;">
                        <label>Upload Foto Bukti Pengaduan</label>
                        <input type="file" class="form-control" name="bukti_pengaduan" id="bukti_pengaduan" accept="image/*" onchange="enableButton()">
                    </div>

                    <div class="form-group" style="display: <?php echo $tgl_diselesaikan_input; ?>;">
                        <label>Tanggal Pengaduan Selesai</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_diselesaikan'];?>" readonly>
                    </div>

                    <div class="form-group" style="display: <?php echo $butki_display; ?>;">
                        <label>Bukti Foto Pengaduan</label>
                        <br>
                        <img src="uploads/bukti_pengaduan/<?php echo $data_cek['bukti_pengaduan']; ?>" alt="<?php echo $data_cek['subjek_pengaduan']; ?>" width="300">
                    </div>

                    <div class="form-group" id="alasanField" style="display: <?php echo $button_alasan; ?>;">
                        <label>Alasan Pembatalan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3" <?php echo $button_read; ?>><?php echo $data_cek['keterangan']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <a href="?halaman=lihat_pengaduan" title="Kembali" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary" id="ubahStatusButton" style="display: <?php echo $button_display; ?>;" <?php echo $button_disabled; ?>>
                            <?php echo $button_text; ?>
                        </button>

                        <button onclick="batalkantolakConfirm()"  type="submit" class="btn btn-primary" id="ubahStatusButton" style="display: <?php echo $batalkan_tolak; ?>;" name="batalcancel">
                            <?php echo $batalkan_tolak_button; ?>
                        </button>
                        
                        <button onclick="hideProsesButton()" type="button" class="btn btn-danger" id="BatalkanButton" style="display: <?php echo $batalkan_btn; ?>;" name="cancel">
                            <?php echo 'Batalkan'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function enableButton() {
    document.getElementById('ubahStatusButton').disabled = false;
    document.getElementById('uploadField').style.display = 'block';
}

document.getElementById('BatalkanButton').addEventListener('click', function() {
    var alasanField = document.getElementById('alasanField');
    alasanField.style.display = 'block';

    var alasanBatal = document.getElementById('keterangan');
    if (alasanBatal.value.trim() !== '') {
        // Add a hidden input to mark the form submission as a cancel action
        var cancelInput = document.createElement('input');
        cancelInput.type = 'hidden';
        cancelInput.name = 'cancel';
        cancelInput.value = '1';
        document.getElementById('ubahStatusForm').appendChild(cancelInput);
        
        // Submit the form
        document.getElementById('ubahStatusForm').submit();
    } else {
        alert("Alasan pembatalan harus diisi.");
    }
});

</script>
<script>
    function hideProsesButton() {
        // Dapatkan elemen tombol "Proses" menggunakan id-nya
        var prosesButton = document.getElementById('ubahStatusButton');
        
        // Sembunyikan tombol "Proses" dengan mengubah properti display-nya
        prosesButton.style.display = 'none';
    }
</script>
