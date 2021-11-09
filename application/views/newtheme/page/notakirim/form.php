<div class="row">
	<div class="col-md-12">
		<form method="post" action="<?php echo $action?>">
			<div class="row">
				<div class="col-md-4">
					<label>Tanggal</label>
					<input type="date" name="tanggal" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Tujuan</label>
					<input type="text" name="tujuan" value="Gudang Tanah Abang" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Keterangan</label>
					<input type="text" name="ketarangan" class="form-control" required="required">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Kode Artikel</th>
								<th>Nama PO</th>
								<th>Rincian PO</th>
								<th>Harga Satuan</th>
								<th>Jumlah</th>
								<th>
									<a class="btn btn-info btn-sm text-white" onclick="addkg()"><i class="fa fa-plus"></i></a>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>