<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>Laporan Pemasukan</b>
            </div>
            <div class="panel-body">
                <form action="./report/laporan_pemasukan.php" method="post" enctype="multipart/form-data" target="_blank">
                    <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input type="date" class="form-control" name="tgl1" id="tgl1" required />
                    </div>
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tgl2" id="tgl2" required />
                    </div>
                    <button type="submit" class="btn btn-primary" name="btnCetak">Cetak</button>
                </form>
            </div>
            <div class="panel-footer">
                Panel Footer
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; // January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("tgl1").setAttribute("max", today);
        document.getElementById("tgl2").setAttribute("max", today);
    }
</script>
