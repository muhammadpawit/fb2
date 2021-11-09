<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<div class="col-6">
						<form method="post" action="<?php echo $update?>">
							<div class="form-group">
								<label>Nama</label>
								<input type="hidden" name="id" class="form-control" value="<?php echo $k['id_master_karyawan_bordir']?>">
								<input type="text" name="nama" class="form-control" value="<?php echo $k['nama_karyawan_bordir']?>">
							</div>
							<div class="form-group">
								<label>Gaji Harian</label>
								<input type="number" onkeyup="update()"  name="karyawan_gaji_weekday" class="form-control" required="required" value="<?php echo $k['karyawan_gaji_weekday']?>">
							</div>
							<div class="form-group">
								<label>Gaji Mingguan</label>
								<input type="number" name="karyawan_gaji_weekend" class="form-control" required="required" value="<?php echo $k['karyawan_gaji_weekend']?>">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-sm">Update</button>
								<a class="btn btn-sm btn-danger text-white" href="<?php echo $cancel?>">Cancel</a>
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