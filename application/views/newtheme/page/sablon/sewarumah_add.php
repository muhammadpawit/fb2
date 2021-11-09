<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker">
			</div>
			<div class="form-group">
				<label>CMT</label>
				<select name="cmt" class="form-control select2bs4" data-live-search="true">
					<option value="*">Pilih</option>
					<?php foreach($cmt as $c){?>
						<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Total Pinjaman / Sewa</label>
				<input type="number" name="totalpinjaman" class="form-control" value="0">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-sm btn-info">Simpan</button>				
			</div>
		</div>
	</div>
</form>