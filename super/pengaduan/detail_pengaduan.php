<?php
include "inc/koneksi.php";

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengaduan = $_POST['id'];
    $current_status = $_POST['current_status'];

    // Determine the new status based on the current status
    $new_status = '';
    if ($current_status == 'Pending') {
        $new_status = 'Proses';
    } else if ($current_status == 'Proses') {
        $new_status = 'Selesai';
    }

    // If a file was uploaded, handle the file upload
    if (isset($_FILES['bukti_pengaduan']) && $_FILES['bukti_pengaduan']['error'] == 0) {
        $upload_dir = 'uploads/bukti_pengaduan/';
        $file_name = basename($_FILES['bukti_pengaduan']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['bukti_pengaduan']['tmp_name'], $target_file)) {
            $sql_update = "UPDATE tb_pengaduan SET status_pengaduan='$new_status', bukti_pengaduan='$file_name' WHERE id_pengaduan='$id_pengaduan'";
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        $sql_update = "UPDATE tb_pengaduan SET status_pengaduan='$new_status' WHERE id_pengaduan='$id_pengaduan'";
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
                        <label>Status Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['status_pengaduan']; ?>" readonly id="status_pengaduan" />
                    </div>

                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <img src="uploads/pengaduan/<?php echo $data_cek['foto_pengaduan']; ?>" alt="<?php echo $data_cek['subjek_pengaduan']; ?>" width="300">
                    </div>

                    <div class="form-group" id="uploadField" style="display: none;">
                        <label>Upload Foto Bukti Pengaduan</label>
                        <input type="file" class="form-control" name="bukti_pengaduan" id="bukti_pengaduan" accept="image/*" onchange="enableButton()">
                    </div>

                    <div class="form-group">
                        <a href="?halaman=lihat_pengaduan" title="Kembali" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary" id="ubahStatusButton" >
                            <?php echo $button_text; ?>
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
</script>
