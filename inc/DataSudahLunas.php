<?php
// Sertakan file koneksi untuk terhubung ke database
include "koneksi.php";

// Ambil nilai bulan dan tahun dari permintaan POST
$bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
$tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);

// Buat kueri SQL untuk mengambil data pemakaian berdasarkan bulan dan tahun yang dipilih
$query = "SELECT p.id_pelanggan, p.nama_pelanggan, t.id_tagihan, t.tagihan, t.status,
          k.tahun, k.pakai, b.tgl_bayar, bl.nama_bulan
          FROM tb_pelanggan p 
          INNER JOIN tb_pakai k ON p.id_pelanggan = k.id_pelanggan
          INNER JOIN tb_tagihan t ON k.id_pakai = t.id_pakai
          INNER JOIN tb_pembayaran b ON t.id_tagihan = b.id_tagihan
          INNER JOIN tb_bulan bl ON k.bulan = bl.id_bulan
          WHERE t.status = 'Lunas' 
          AND bl.nama_bulan = '$bulan' 
          AND k.tahun = '$tahun'
          ORDER BY b.tgl_bayar DESC, k.tahun DESC, k.bulan DESC";

// Jalankan kueri
$result = mysqli_query($koneksi, $query);

// Periksa apakah ada data yang ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    // Inisialisasi variabel untuk menyimpan hasil
    $output = "";
    $no = 1;

    // Lakukan perulangan untuk setiap baris hasil kueri
    while ($row = mysqli_fetch_assoc($result)) {
        // Buat baris HTML untuk setiap baris data
        $output .= "<tr>";
        $output .= "<td>" . $no++ . "</td>"; // Tambahkan nomor urut di sini
        $output .= "<td>" . $row['id_pelanggan'] . " - " . $row['nama_pelanggan'] . "</td>";
        $output .= "<td>" . $row['nama_bulan'] . " - " . $row['tahun'] . "</td>";
        $output .= "<td>" . $row['pakai'] . " M<sup>3</sup></td>";
        $output .= "<td>" . $row['tagihan'] . "</td>";
        $output .= "<td>" . date("d - M - Y", strtotime($row['tgl_bayar'])) . "</td>";
        $output .= "<td>";
        $output .= "<a href='./report/cetak_pembayaran.php?id_tagihan=" . $row['id_tagihan'] . "' target='_blank' title='Cetak Struk Pembayaran' class='btn btn-success'><i class='glyphicon glyphicon-print'></i></a>";
        $output .= "</td>";
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
