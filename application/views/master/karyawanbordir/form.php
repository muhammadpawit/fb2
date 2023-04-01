<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<div class="col-md-12">
						<form method="post" action="<?php echo $insert?>">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" name="nama" class="form-control" required="required">
							</div>
							<div class="form-group">
								<label>Tanggal Masuk</label>
								<input type="text" name="tgl_masuk" class="form-control datepicker" autocomplete="off" required="required">
							</div>
							<div class="form-group">
								<label>No.Telp</label>
								<input type="text" name="no_telp" class="form-control" required="required">
							</div>
							<div class="form-group">
								<label>Gaji Harian</label>
								<input type="number" onkeyup="update()" name="karyawan_gaji_weekday" class="form-control" value="0" required="required">
							</div>
							<div class="form-group">
								<label>Gaji Mingguan</label>
								<input type="number" name="karyawan_gaji_weekend" class="form-control" value="0" required="required">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-sm">Simpan</button>
								<a class="btn btn-sm btn-danger text-white" href="<?php echo $batal?>">Batal</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function update() {
		let harian= $('input[name=\'karyawan_gaji_weekday\']').val();
		 $('input[name=\'karyawan_gaji_weekend\']').val(Number(harian*7));
	}
</script>