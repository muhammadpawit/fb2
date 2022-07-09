<form method="post" action="<?php echo $action?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama Produk</label>
				<input type="text" name="nama" value="<?php echo $prod['nama']?>" class="form-control">
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
					<option value="1" <?php echo $prod['kategori']==1?'selected':''?>>Hangtag</option>
					<option value="2" <?php echo $prod['kategori']==2?'selected':''?>>Slip</option>
					<option value="3" <?php echo $prod['kategori']==3?'selected':''?>>Kerah</option>
					<option value="4" <?php echo $prod['kategori']==4?'selected':''?>>Kancing</option>
					<option value="5" <?php echo $prod['kategori']==5?'selected':''?>>Kancing</option>
					<option value="6" <?php echo $prod['kategori']==6?'selected':''?>>Barang Bordir</option>
					<option value="7" <?php echo $prod['kategori']==7?'selected':''?>>Resleting</option>
					<option value="8" <?php echo $prod['kategori']==8?'selected':''?>>Resleting Kantong</option>
					<option value="9" <?php echo $prod['kategori']==9?'selected':''?>>Pita</option>
					<option value="10" <?php echo $prod['kategori']==10?'selected':''?>>Sleting</option>
					<option value="11" <?php echo $prod['kategori']==11?'selected':''?>>Gesper</option>
					<option value="12" <?php echo $prod['kategori']==12?'selected':''?>>Spandek</option>
					<option value="13" <?php echo $prod['kategori']==13?'selected':''?>>ATK</option>
					<option value="14" <?php echo $prod['kategori']==14?'selected':''?>>Benang Konveksi</option>
					<option value="15" <?php echo $prod['kategori']==15?'selected':''?>>Bahan Kaos</option>
					<option value="16" <?php echo $prod['kategori']==16?'selected':''?>>Bahan Celana</option>
					<option value="17" <?php echo $prod['kategori']==17?'selected':''?>>Bahan Kemeja</option>
				</select>
			</div>
			<div class="form-group">
				<label>Warna</label>
				<input type="text" name="warna" value="<?php echo $prod['warna_item']?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Minimal Stok</label>
				<input type="text" name="minstok" value="<?php echo $prod['minstok']?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Satuan</label>
				<select name="satuan" class="form-control select2bs4" data-live-search="true">
                                <option value="">Pilih</option>
                                <?php foreach(table('master_satuan_barang') as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>" <?php echo $st['kode_satuan_barang']==$prod['satuan']?'selected':''; ?>><?php echo $st['kode_satuan_barang']?></option>
                                <?php } ?>
                </select>
			</div>
		</div>
		<div class="col-md-12">
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
				<label>Stok Saat ini</label>
				<h3><?php echo $prod['quantity']?></h3>
			</div>
			<div class="form-group">
				<label>Harga HPP</label>
				<input type="text" name="price" class="form-control" value="<?php echo $prod['price']?>">
			</div>
			<div class="form-group">
				<label>Harga Beli</label>
				<input type="text" name="harga_beli" class="form-control" value="<?php echo $prod['harga_beli']?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input type="hidden" name="product_id" value="<?php echo $prod['product_id']?>">
				<input type="submit" class="btn btn-sm btn-info full" value="Simpan">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo $batal?>" class="btn btn-sm btn-danger full">Batal</a>
			</div>
		</div>
	</div>
</form>