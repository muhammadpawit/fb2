<form method="post" action="<?php echo $action?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Nama Produk</label>
				<h3><input type="text" name="nama" value="<?php echo $prod['nama']?>"></h3>
			</div>
			<div class="form-group">
				<label>Jenis Barang</label>
				<select name="jenis" class="form-control select2bs4" data-live-search="true">
					<option value="0">Pilih</option>
					<option value="1" <?php echo $prod['jenis']==1?'selected':''?>>Konveksi</option>
					<option value="2" <?php echo $prod['jenis']==2?'selected':''?>>Bordir</option>
					<option value="3" <?php echo $prod['jenis']==3?'selected':''?>>Sablon</option>
					<option value="4" <?php echo $prod['jenis']==4?'selected':''?>>Bahan</option>
				</select>
			</div>
			<div class="form-group">
				<label>Kategori Barang</label>
				<select name="kategori" class="form-control select2bs4" data-live-search="true">
					<option value="">Pilih</option>
					<option value="1" <?php echo $prod['jenis']==1?'selected':''?>>Hangtag</option>
					<option value="2" <?php echo $prod['jenis']==2?'selected':''?>>Slip</option>
					<option value="3" <?php echo $prod['jenis']==3?'selected':''?>>Kerah</option>
					<option value="4" <?php echo $prod['jenis']==4?'selected':''?>>Kancing</option>
					<option value="5" <?php echo $prod['jenis']==5?'selected':''?>>Kancing</option>
					<option value="6" <?php echo $prod['jenis']==6?'selected':''?>>Barang Bordir</option>
					<option value="7" <?php echo $prod['jenis']==7?'selected':''?>>Resleting</option>
					<option value="8" <?php echo $prod['jenis']==8?'selected':''?>>Resleting Kantong</option>
					<option value="9" <?php echo $prod['jenis']==9?'selected':''?>>Pita</option>
					<option value="10" <?php echo $prod['jenis']==10?'selected':''?>>Sleting</option>
					<option value="11" <?php echo $prod['jenis']==11?'selected':''?>>Gesper</option>
					<option value="12" <?php echo $prod['jenis']==12?'selected':''?>>Spandek</option>
					<option value="13" <?php echo $prod['jenis']==13?'selected':''?>>ATK</option>
					<option value="14" <?php echo $prod['jenis']==14?'selected':''?>>Benang Konveksi</option>
				</select>
			</div>
			<div class="form-group">
                              <label>Supplier</label>
                              <select name="supplier" class="form-control select2bs4" data-live-search="true">
                                <option value="0">Pilih</option>
                                <?php foreach($supplier as $st){?>
                                  <option value="<?php echo $st['id'] ?>"><?php echo $st['nama']?></option>
                                <?php } ?>
                              </select>
                            </div>
			<div class="form-group">
				<label>Gambar saat ini</label><br>
				<img src="<?php echo BASEURL.'uploads/persediaan/'.$prod['foto'] ?>" class="img-thumbnail" >
			</div>
			<div class="form-group">
				<label>Gambar / Foto</label>
				<input type="file" name="gambarPO1" class="form-control">
			</div>
			<div class="form-group">
				<input type="hidden" name="product_id" value="<?php echo $prod['product_id']?>">
				<input type="submit" class="btn btn-sm btn-info" value="Simpan">
				<a href="<?php echo $batal?>" class="btn btn-sm btn-danger">Batal</a>
			</div>
		</div>
	</div>
</form>