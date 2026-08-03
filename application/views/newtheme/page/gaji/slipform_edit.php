<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Bulan Tahun</label>
				<input type="text" name="tanggal" class="form-control" value="<?php echo date('F Y', strtotime($gaji['tanggal'])) ?>" readonly>
			</div>
			<div class="form-group">
				<label>Nama Karyawan</label>
				<input type="text" class="form-control" value="<?php echo strtoupper($karyawan['nama']) ?>" readonly>
				<input type="hidden" name="idkaryawan" value="<?php echo $gaji['idkaryawan'] ?>">
			</div>
			<div class="form-group">
				<label>Bonus</label>
				<input type="number" id="bonus" name="bonus" class="form-control" value="<?php echo $gaji['bonus'] ?>" onblur="updatetotal()">
			</div>
			<div class="form-group">
				<label>THR</label>
				<input type="number" id="thr" name="thr" class="form-control" value="<?php echo $gaji['thr'] ?>" onblur="updatetotal()">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Gaji Pokok</label>
				<input type="number" name="gajipokok" id="gajipokok" class="form-control" value="<?php echo $gaji['gajipokok'] ?>" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Gantungan Gaji</label>
				<input type="number" onblur="updatetotal()" id="gantungan_gaji" name="gantungan_gaji" class="form-control" value="<?php echo $gaji['gantungan_gaji'] ?>">
			</div>
			<div class="form-group">
				<label>Potongan Kasbon</label>
				<input type="number" onblur="updatetotal()" id="potongan_kasbon" name="potongan_kasbon" class="form-control" value="<?php echo $gaji['potongan_kasbon'] ?>">
			</div>
			<div class="form-group">
				<label>Potongan Pinjaman</label>
				<input type="number" id="potongan_pinjaman" onblur="updatetotal()" name="potongan_pinjaman" class="form-control" value="<?php echo $gaji['potongan_pinjaman'] ?>">
			</div>
			<div class="form-group">
				<label>Potongan Claim</label>
				<input type="number" id="potongan_claim" onblur="updatetotal()" name="potongan_claim" class="form-control" value="<?php echo $gaji['potongan_claim'] ?>">
			</div>
			<div class="form-group">
				<label>Potongan Absensi</label>
				<input type="number" id="potongan_absensi" onblur="updatetotal()" name="potongan_absensi" class="form-control" value="<?php echo $gaji['potongan_absensi'] ?>">
			</div>
			<div class="form-group">
				<label>Potongan Keterlambatan</label>
				<input type="number" id="potongan_terlambat" onblur="updatetotal()" name="potongan_terlambat" class="form-control" value="<?php echo $gaji['potongan_terlambat'] ?>">
			</div>
			<div class="form-group">
				<label>Subtotal (Gaji Kotor)</label>
				<input type="number" name="subtotal" id="subtotal" class="form-control" value="<?php echo $gaji['subtotal'] ?>" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Total (Gaji Bersih)</label>
				<input type="number" name="total" id="total" class="form-control" value="<?php echo $gaji['total'] ?>" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Metode Pembayaran</label><br>
				<input type="radio" name="metode" value="1" required <?php echo ($gaji['metode'] == 1 || empty($gaji['metode'])) ? 'checked' : '' ?>> Cash&nbsp;
				<input type="radio" name="metode" value="2" required <?php echo ($gaji['metode'] == 2) ? 'checked' : '' ?>> Transfer
			</div>
			<div class="form-group">
				<button class="btn btn-info btn-sm text-white">Simpan</button>
				<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	function updatetotal(){
		var sub=0;
		var grand=0;
		var total=$("#total").val();
		var bonus=$("#bonus").val() || 0;
		var thr=$("#thr").val() || 0;
		var gajipokok=$("#gajipokok").val() || 0;
		var potongan_kasbon=$("#potongan_kasbon").val() || 0;
		var potongan_pinjaman=$("#potongan_pinjaman").val() || 0;
		var potongan_claim=$("#potongan_claim").val() || 0;
		var potongan_abensi=$("#potongan_absensi").val() || 0;
		var potongan_terlambat=$("#potongan_terlambat").val() || 0;
		var gantungan_gaji=$("#gantungan_gaji").val() || 0;
		sub = Number(gajipokok)+Number(bonus)+Number(thr);
		grand = Number(sub)-Number(potongan_kasbon)-Number(potongan_pinjaman)-Number(potongan_claim)-Number(potongan_abensi)-Number(potongan_terlambat)-Number(gantungan_gaji);
		$("#total").val(grand);
		$("#subtotal").val(sub);
	}
</script>
