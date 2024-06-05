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

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <b>Simulasi Perhitungan Air</b>
      </div>
      <div class="panel-body">
        <form id="penggunaanAirForm" class="form-inline">
          <div class="form-group mx-sm-3 mb-2">
            <label for="penggunaan_air" class="sr-only">Penggunaan Air</label>
            <input type="number" class="form-control form-control-sm" id="penggunaan_air" name="penggunaan_air" min="0" step="1" required placeholder="Penggunaan Air (Meter Kubik)">
          </div>
          <br>
          <br>
          <button type="button" class="btn btn-primary mb-2" onclick="hitungBiaya()">Hitung Biaya</button>
        </form>
        <br>
        <div id="keterangan" style="display: none;"></div>
        <div id="hasilBiaya" class="alert alert-success" role="alert" style="display: none;"></div>
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

  var tarif_layanan = <?php echo $tarif_layanan; ?>;
  var tarif_beban = <?php echo $tarif_beban; ?>;

  var biaya_pemakaian_air = (penggunaan_air * tarif_layanan) + tarif_beban;

  // Keterangan tidak ditampilkan
  document.getElementById('keterangan').style.display = "none";

  var hasilBiaya = "<strong>Biaya pemakaian air</strong> untuk penggunaan <strong>" + penggunaan_air + " Meter Kubik</strong> adalah: <span class='text-success'><strong>Rp " + biaya_pemakaian_air.toFixed(2) + "</strong></span>";

  document.getElementById('hasilBiaya').innerHTML = hasilBiaya;
  document.getElementById('hasilBiaya').style.display = "block";
}
</script>