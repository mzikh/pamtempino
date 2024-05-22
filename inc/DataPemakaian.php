<?php
// Sertakan file koneksi untuk terhubung ke database
include "koneksi.php";

// Ambil nilai bulan dan tahun dari permintaan POST
$bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
$tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);

// Buat kueri SQL untuk mengambil data pemakaian berdasarkan bulan dan tahun, serta menggabungkan tabel tb_pakai dengan tb_pelanggan dan tb_tagihan
$query = "SELECT k.id_pakai, p.id_pelanggan, p.nama_pelanggan, b.nama_bulan, k.tahun, k.awal, k.akhir, t.status
          FROM tb_pakai k 
          INNER JOIN tb_pelanggan p ON k.id_pelanggan = p.id_pelanggan 
          INNER JOIN tb_tagihan t ON k.id_pakai = t.id_pakai
          INNER JOIN tb_bulan b ON k.bulan = b.id_bulan
          WHERE k.bulan = '$bulan' AND k.tahun = '$tahun'";



// Jalankan kueri
$result = mysqli_query($koneksi, $query);

// Periksa apakah ada data yang ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    // Inisialisasi variabel untuk menyimpan hasil
    $output = "";
    $no =1;

    // Lakukan perulangan untuk setiap baris hasil kueri
    while ($row = mysqli_fetch_assoc($result)) {
        // Buat baris HTML untuk setiap baris data
        $output .= "<tr>";
        $output .= "<td>" . $no++ .  "</td>";
        $output .= "<td>" . $row['id_pelanggan'] . " - " . $row['nama_pelanggan'] ."</td>";
        $output .= "<td>" . $row['nama_bulan'] . " - " . $row['tahun'] . "</td>";
        $output .= "<td>" . $row['awal'] . " M<sup> 3</sup></td>";
        $output .= "<td>" . $row['akhir'] . " M<sup> 3</sup></td>";
        $output .= "<td>";
        // Tambahkan kode untuk menampilkan status pembayaran
        $status = $row['status'];
        if ($status == 'Belum Bayar') {
            $output .= "<a href='?halaman=pakai_hapus&kode=" . $row['id_pakai'] . "' onclick='return confirm(\"Apakah anda yakin hapus data ini ?\")' title='Hapus' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a>";
        } elseif ($status == 'Lunas') {
            $output .= "<span class='label label-primary'>Lunas</span>";
        }
        
        $output .= "</td>";
        // Lanjutkan menambahkan kolom lain sesuai kebutuhan
        $output .= "</tr>";
    }

    // Cetak hasil ke layar
    echo $output;
} else {
    // Jika tidak ada data yang ditemukan, cetak pesan kosong
    echo "<tr><td colspan='5'>Tidak ada data yang ditemukan</td></tr>";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
