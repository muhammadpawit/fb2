<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="products[0][tanggal]" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Cash</label>
				<input type="text" name="products[0][cash]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Pengisian E-Toll</label>
				<input type="text" name="products[0][pengisian_etoll]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Saldo Awal E-Toll</label>
				<input type="text" name="products[0][saldo_awal_etoll]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Pemakaian E-Toll</label>
				<input type="text" name="products[0][pemakaian_etoll]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Sisa E-Toll</label>
				<input type="text" name="products[0][sisa_etoll]" class="form-control" readonly>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Solar</label>
				<input type="text" name="products[0][solar]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Uang Makan</label>
				<input type="text" name="products[0][uang_makan]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Biaya Lain-Lain</label>
				<input type="text" name="products[0][biaya_lain]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Driver</label>
				<input type="text" name="products[0][namadriver]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Nominal</label>
				<input type="text" name="products[0][nominal]" class="form-control" readonly>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Sisa Cash</label>
				<input type="text" name="products[0][sisa_cash]" class="form-control" readonly>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>KM</label>
				<input type="text" name="products[0][km]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Tujuan</label>
				<input type="text" name="products[0][tujuan]" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Keterangan</label>
				<textarea name="products[0][keterangan]" class="form-control" rows="5"></textarea>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Keterangan 2</label>
				<textarea name="products[0][keterangan2]" class="form-control" rows="5"></textarea>
			</div>
		</div>
	</div>

		<div class="col-md-6">
			<a href="<?php echo $url?>" class="btn btn-danger full">Batal</a>
		</div>
		<div class="col-md-6">
			<button type="submit" class="btn btn-success full">Simpan</button>
		</div>
	</div>
</form>
<script type="text/javascript">
    function hitungNominal() {
        // Mengambil nilai dari input form
        var pengisian_etoll = parseFloat(document.querySelector('input[name="products[0][pengisian_etoll]"]').value) || 0;
        var solar = parseFloat(document.querySelector('input[name="products[0][solar]"]').value) || 0;
        var uang_makan = parseFloat(document.querySelector('input[name="products[0][uang_makan]"]').value) || 0;
        
        // Menghitung total nominal
        var nominal = pengisian_etoll + solar + uang_makan;

        // Memasukkan nilai nominal ke input form
        document.querySelector('input[name="products[0][nominal]"]').value = nominal;
        
        // Hitung sisa cash
        hitungSisaCash();
    }

    function hitungSisaEtoll() {
        // Mengambil nilai dari input form
        var pengisian_etoll = parseFloat(document.querySelector('input[name="products[0][pengisian_etoll]"]').value) || 0;
        var saldo_awal_etoll = parseFloat(document.querySelector('input[name="products[0][saldo_awal_etoll]"]').value) || 0;
        var pemakaian_etoll = parseFloat(document.querySelector('input[name="products[0][pemakaian_etoll]"]').value) || 0;
        
        // Menghitung sisa etoll
        var sisa_etoll = pengisian_etoll + saldo_awal_etoll - pemakaian_etoll;

        // Memasukkan nilai sisa etoll ke input form
        document.querySelector('input[name="products[0][sisa_etoll]"]').value = sisa_etoll;
    }

    function hitungSisaCash() {
        // Mengambil nilai dari input form
        var cash = parseFloat(document.querySelector('input[name="products[0][cash]"]').value) || 0;
        var nominal = parseFloat(document.querySelector('input[name="products[0][nominal]"]').value) || 0;

        // Menghitung sisa cash
        var sisa_cash = cash - nominal;

        // Memasukkan nilai sisa cash ke input form
        document.querySelector('input[name="products[0][sisa_cash]"]').value = sisa_cash;
    }

    // Event listeners untuk menghitung nominal, sisa etoll, dan sisa cash secara otomatis
    document.querySelector('input[name="products[0][pengisian_etoll]"]').addEventListener('input', function() {
        hitungNominal();
        hitungSisaEtoll();
    });
    document.querySelector('input[name="products[0][solar]"]').addEventListener('input', hitungNominal);
    document.querySelector('input[name="products[0][uang_makan]"]').addEventListener('input', hitungNominal);
    document.querySelector('input[name="products[0][saldo_awal_etoll]"]').addEventListener('input', hitungSisaEtoll);
    document.querySelector('input[name="products[0][pemakaian_etoll]"]').addEventListener('input', hitungSisaEtoll);
    document.querySelector('input[name="products[0][cash]"]').addEventListener('input', hitungSisaCash);
</script>
