<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>CMT</label>
				<select name="idcmt" class="form-control select2bs4" data-live-search="true">
					<option value="*">Pilih</option>
					<?php foreach($cmt as $c){?>
						<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama PO</th>
						<th>Jumlah Kirim Pcs</th>
						<th>Keterangan</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</form>