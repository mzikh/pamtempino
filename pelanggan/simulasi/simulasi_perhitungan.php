<?php
// Ambil id_layanan dari data pelanggan yang sedang login
// Sesuaikan dengan struktur data Anda

// Gunakan id_layanan untuk mengambil tarif layanan dari tabel tb_layanan
$sql_tarif_layanan = "SELECT l.tarif FROM tb_layanan l JOIN tb_pelanggan p ON l.id_layanan = p.id_layanan WHERE p.id_pelanggan = '$data_rek'";
$query_tarif_layanan = mysqli_query($koneksi, $sql_tarif_layanan);

if ($query_tarif_layanan) {
    $result_tarif_layanan = mysqli_fetch_assoc($query_tarif_layanan);
    $tarif_layanan = isset($result_tarif_layanan['tarif']) ? $result_tarif_layanan['tarif'] : 0;
} else {
    // Handle error jika query tidak berhasil
    $tarif_layanan = 0;
}

// Ambil tarif beban dari database
$sql_tarif_beban = "SELECT harga_beban FROM tb_beban";
$query_tarif_beban = mysqli_query($koneksi, $sql_tarif_beban);

if ($query_tarif_beban) {
    $result_tarif_beban = mysqli_fetch_assoc($query_tarif_beban);
    $tarif_beban = isset($result_tarif_beban['harga_beban']) ? $result_tarif_beban['harga_beban'] : 0;
} else {
    // Handle error jika query tidak berhasil
    $tarif_beban = 0;
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">    
      <div class="panel panel-success">
        <div class="panel-heading">
          <b>Simulasi Perhitungan Air</b>
        </div>
        <div class="panel-body">
          <form id="penggunaanAirForm">
            <div class="form-group">
              <label for="penggunaan_air">Penggunaan Air (Meter Kubik):</label>
              <input type="number" class="form-control" id="penggunaan_air" name="penggunaan_air" min="0" step="1" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="hitungBiaya()">Hitung Biaya</button>
          </form>
          <br>
          <div id="keterangan"></div> <!-- Tempat untuk menampilkan keterangan kepada pelanggan -->
          <div id="hasilBiaya"></div>
        </div>
      </div>
    </div>
  </div>
</div>



    <script>
        function hitungBiaya() {
            var penggunaan_air = parseFloat(document.getElementById('penggunaan_air').value);

            if (isNaN(penggunaan_air)) {
                alert("Masukkan angka untuk penggunaan air.");
                return;
            }

            var tarif_layanan = <?php echo $tarif_layanan; ?>; // Tarif layanan air yang diambil dari database
            var tarif_beban = <?php echo $tarif_beban; ?>; // Tarif beban air yang diambil dari database

            var biaya_pemakaian_air = (penggunaan_air * tarif_layanan) + tarif_beban;

            // Menampilkan keterangan kepada pelanggan
            var 
            
            keterangan = "Biaya pemakaian air = (Penggunaan Air * Tarif Layanan) + Tarif Beban";
            keterangan += "<br>";
            keterangan += "Tarif layanan anda = "+ tarif_layanan;
            keterangan += "<br>";
            keterangan += "Tarif Beban anda = "+ tarif_beban;
            keterangan += "<br>";
            keterangan += "Biaya pemakaian air = (" + penggunaan_air + " * " + tarif_layanan + ") + " + tarif_beban;
            keterangan += "<br>";
            keterangan += "Biaya pemakaian air = " + biaya_pemakaian_air.toFixed(2) + " Rupiah.";

            document.getElementById('keterangan').innerHTML = keterangan;
            document.getElementById('hasilBiaya').innerHTML = "Biaya pemakaian air untuk penggunaan " + penggunaan_air + " Meter Kubik adalah: Rp " + biaya_pemakaian_air.toFixed(2);
        }
    </script>



