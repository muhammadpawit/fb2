<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker">
			</div>
			<div class="form-group">
				<label>CMT</label>
				<select name="idcmt" class="form-control select2bs4" data-live-search="true">
					<option value="*">Pilih CMT</option>
					<?php foreach($cmt as $c){?>
						<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Pembelanjaan Cat dan Afdruk</label>
				<input type="number" name="belanjacat" class="form-control">
			</div>
			<div class="form-group">
				<label>Upah Tukang Harian</label>
				<input type="number" name="upahtukang_harian" class="form-control">
			</div>
			<div class="form-group">
				<label>Upah Tukang Borongan</label>
				<input type="number" name="upahtukang_borongan" class="form-control">
			</div>
			<div class="form-group">
				<label>Biaya lain-lain</label>
				<input type="number" name="biayalain" class="form-control">
			</div>
			<div class="form-group">
				<label>Tokenlistrik</label>
				<input type="number" name="tokenlistrik" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info btn-sm">Simpan</button>
			</div>
		</div>
	</div>
</form>