<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="id" value="<?php echo $k['id']?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker" value="<?php echo $k['tanggal']?>">
			</div>
			<div class="form-group">
				<label>Nominal</label>
				<input type="text" name="nominal" class="form-control" value="<?php echo $k['nominal']?>">
			</div>
			<div class="form-group">
	            <label>Bagian</label>
	            <select name="bagian" class="form-control select2bs4" required="required">
	              <option value="1" <?php echo ($k['bagian']==1)?'selected':'';?>>Konveksi</option>
	              <option value="2" <?php echo ($k['bagian']==2)?'selected':'';?>>Bordir</option>
	              <option value="3" <?php echo ($k['bagian']==3)?'selected':'';?>>Sablon</option>
	            </select>
	          </div>
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" name="keterangan" class="form-control" value="<?php echo $k['keterangan']?>">
			</div>
		</div>
	</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<button class="btn btn-success btn-sm full">Simpan</button>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<a href="<?php echo $batal?>" class="btn btn-danger btn-sm full">Batal</a>
				</div>
			</div>
		</div>	
</form>