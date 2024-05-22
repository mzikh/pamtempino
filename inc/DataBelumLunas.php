<?php
// Sertakan file koneksi untuk terhubung ke database
include "koneksi.php";

// Ambil nilai bulan dan tahun dari permintaan POST
$bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
$tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);

// Buat kueri SQL untuk mengambil data pemakaian berdasarkan bulan dan tahun, serta menggabungkan tabel tb_pakai dengan tb_pelanggan dan tb_tagihan
$query = "SELECT k.id_pakai, p.id_pelanggan, t.id_tagihan, p.nama_pelanggan, b.nama_bulan, k.tahun, k.awal, k.akhir, k.pakai, t.status, t.tagihan
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
        $status = $row['status'];
        if ($status == 'Belum Bayar') {
            $output .= "<tr>";
            $output .= "<td>" . $no++ . "</td>"; // Tambahkan nomor urut di sini
            
            // Periksa apakah indeks 'id_pelanggan' dan 'nama_pelanggan' ada sebelum mengaksesnya
            $output .= "<td>" . (isset($row['id_pelanggan']) && isset($row['nama_pelanggan']) ? $row['id_pelanggan'] . " - " . $row['nama_pelanggan'] : '') . "</td>";
            $output .= "<td>" . (isset($row['nama_bulan']) && isset($row['tahun']) ? $row['nama_bulan'] . " - " . $row['tahun'] : '') . "</td>";
            $output .= "<td>" . (isset($row['pakai']) ? $row['pakai'] . " M<sup>3</sup>" : '') . "</td>";
            $output .= "<td>" . (isset($row['tagihan']) ? $row['tagihan'] : '') . "</td>"; // Menampilkan nilai tagihan
        
            // Periksa apakah indeks 'id_tagihan' ada sebelum mengaksesnya
            $output .= "<td>";
            
                $output .= "<a href='?halaman=tagih_bayar&kode=" . $row['id_tagihan'] . "' title='Bayar Tagihan Ini' class='btn btn-primary'><i class='glyphicon glyphicon-send'></i></a>";
            
            $output .= "</td>";
            
            $output .= "</tr>";
        }
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
