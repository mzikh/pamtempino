<?php

include "inc/koneksi.php";

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
                <form id="ubahStatusForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tanggal Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['tgl_pengaduan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input class="form-control" value="<?php echo $data_cek['nama_pelanggan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Subjek Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['subjek_pengaduan'];?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea class="form-control" readonly><?php echo $data_cek['deskripsi_pengaduan'];?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Status Pengaduan</label>
                        <input class="form-control" value="<?php echo $data_cek['status_pengaduan'];?>" readonly id="status_pengaduan"/>
                    </div>

                    <div class="form-group">
                        <label>Foto Pengaduan</label>
                        <img src="uploads/pengaduan/<?php echo $data_cek['foto_pengaduan'];?>" alt="<?php echo $data_cek['subjek_pengaduan'];?>" width="300">
                    </div>

                    <!-- File upload field, hidden initially -->
                    <div class="form-group" id="uploadField" style="display: none;">
                        <label>Upload Foto Bukti Pengaduan</label>
                        <input type="file" class="form-control" name="bukti_pengaduan" id="bukti_pengaduan" accept="image/*" onchange="enableButton()">
                    </div>

                    <div class="form-group">
                        <a href="?halaman=lihat_pengaduan" title="Kembali" class="btn btn-default">Kembali</a>
                        <button type="button" class="btn btn-primary" id="ubahStatusButton" onclick="ubahStatus('<?php echo $data_cek['id_pengaduan'];?>')" disabled>
                            <?php echo $button_text; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentStatus = document.getElementById('status_pengaduan').value;
        if (currentStatus == 'Proses') {
            document.getElementById('uploadField').style.display = 'block';
        }
        enableButton(); // Check the button state on load
    });

    function enableButton() {
        var currentStatus = document.getElementById('status_pengaduan').value;
        if (currentStatus == 'Proses') {
            var fileInput = document.getElementById('bukti_pengaduan');
            document.getElementById('ubahStatusButton').disabled = !fileInput.files.length;
        } else {
            document.getElementById('ubahStatusButton').disabled = false;
        }
    }

    function ubahStatus(id_pengaduan) {
        var currentStatus = document.getElementById('status_pengaduan').value;
        var newStatus = '';
        var newButtonText = '';

        if (currentStatus == 'Pending') {
            newStatus = 'Proses';
            newButtonText = 'Selesai';
        } else if (currentStatus == 'Proses') {
            newStatus = 'Selesai';
            newButtonText = 'Selesai';
        } else {
            alert("Pengaduan sudah selesai.");
            return;
        }

        var formData = new FormData(document.getElementById('ubahStatusForm'));
        formData.append('id_pengaduan', id_pengaduan);
        formData.append('status', newStatus);
        formData.append('ubah_status', true);

        $.ajax({
            url: "<?php echo $_SERVER['PHP_SELF'];?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == "success") {
                    document.getElementById('status_pengaduan').value = newStatus; // Update the status display
                    document.getElementById('ubahStatusButton').innerText = newButtonText; // Update the button text
                    alert("Status pengaduan berhasil diubah.");
                    if (newStatus == 'Selesai') {
                        document.getElementById('uploadField').style.display = 'none'; // Hide upload field
                    }
                } else {
                    alert("Gagal mengubah status pengaduan.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert("Gagal mengubah status pengaduan.");
            }
        });
    }
</script>

<?php
if (isset($_POST['ubah_status'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = $_POST['status'];

    if ($status == 'Selesai' && isset($_FILES['bukti_pengaduan'])) {
        $target_dir = "uploads/bukti/";
        $target_file = $target_dir . basename($_FILES["bukti_pengaduan"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["bukti_pengaduan"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["bukti_pengaduan"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["bukti_pengaduan"]["tmp_name"], $target_file)) {
                $sql_ubah = "UPDATE tb_pengaduan SET status_pengaduan='$status', bukti_pengaduan='".basename($_FILES["bukti_pengaduan"]["name"])."' WHERE id_pengaduan='$id_pengaduan'";
                $query_ubah = mysqli_query($koneksi, $sql_ubah);
                if ($query_ubah) {
                    echo "success";
                } else {
                    echo "failed";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $sql_ubah = "UPDATE tb_pengaduan SET status_pengaduan='$status' WHERE id_pengaduan='$id_pengaduan'";
        $query_ubah = mysqli_query($koneksi, $sql_ubah);
        if ($query_ubah) {
            echo "success";
        } else {
            echo "failed";
        }
    }
}
?>
