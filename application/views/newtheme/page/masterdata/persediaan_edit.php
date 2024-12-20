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
					<option value="5" <?php echo $prod['jenis']==5?'selected':''?>>Alat Sisa Produksi Konveksi</option>
					<option value="6" <?php echo $prod['jenis']==6?'selected':''?>>Alat Sisa Produksi Bordir</option>
				</select>
			</div>
			<div class="form-group">
				<label>Kategori Barang</label>
				<select name="kategori" class="form-control select2bs4" data-live-search="true">
					<option value="">Pilih</option>
					<?php foreach($kat as $k){ ?>
						<option value="<?php echo $k['id']?>" <?php echo $prod['kategori']==$k['id']?'selected':''?>><?php echo $k['nama']?></option>
					<?php } ?>
					<!-- <option value="1" <?php echo $prod['kategori']==1?'selected':''?>>Hangtag</option>
					<option value="2" <?php echo $prod['kategori']==2?'selected':''?>>Slip</option>
					<option value="3" <?php echo $prod['kategori']==3?'selected':''?>>Kerah</option>
					<option value="4" <?php echo $prod['kategori']==4?'selected':''?>>Kancing Baru</option>
					<option value="5" <?php echo $prod['kategori']==5?'selected':''?>>Kancing Lama</option>
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
					<option value="18" <?php echo $prod['kategori']==18?'selected':''?>>Alat-alat PO</option>
					<option value="19" <?php echo $prod['kategori']==19?'selected':''?>>Hangtag Kiddreams</option>
					<option value="20" <?php echo $prod['kategori']==20?'selected':''?>>Hangtag Agola</option>
					<option value="21" <?php echo $prod['kategori']==19?'selected':''?>>Hangtag Forboys</option> -->
				</select>
			</div>
			<div class="form-group">
				<label>Warna</label>
				<input type="text" name="warna" value="<?php echo $prod['warna_item']?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Minimal Stok</label>
				<input type="text" name="minstok" value="<?php echo $prod['minstok']?>" class="form-control" readonly>
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
                                  <option value="<?php echo $st['id'] ?>" <?php echo $st['id']==$prod['supplier'] ? 'selected':''; ?>><?php echo $st['nama']?></option>
                                <?php } ?>
                              </select>
                            </div>
			<div class="form-group">
				<label>Gambar saat ini</label><br>
				<input type="hidden" name="userfile" value="<?php echo $prod['foto'] ?>">
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
			<div class="form-group">
				<label>Harga Jual SKB</label>
				<input type="text" name="harga_skb" class="form-control" value="<?php echo $prod['harga_skb']?>">
			</div>
			<div class="form-group">
				<label>Tipe </label>
				<select name="tipe" class="form-control">
					<option value=""></option>
					<option value="1" <?php echo $prod['tipe']==1 ? 'selected':'' ?>>Bahan Utuh</option>
					<option value="2" <?php echo $prod['tipe']==2 ? 'selected':'' ?>>Bahan Sisa</option>
				</select>
			</div>
			<div class="form-group">
				<label>Status </label>
				<select name="status" class="form-control">
					<option value=""></option>
					<option value="terpakai" <?php echo $prod['status']=='terpakai' ? 'selected':'' ?>>Terpakai</option>
					<option value="tidak terpakai" <?php echo $prod['status']=='tidak terpakai' ? 'selected':'' ?>>Tidak Terpakai</option>
				</select>
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" class="form-control" name="keterangan_tipe" value="<?php echo $prod['keterangan_tipe']?>">
			</div>
			<div class="form-group">
				<label>Tampilkan ACC Satuan </label>
				<select name="accsatuan" class="form-control">
					<option value=""></option>
					<option value="0" <?php echo $prod['accsatuan']=='0' ? 'selected':'' ?>>Tidak</option>
					<option value="1" <?php echo $prod['accsatuan']=='1' ? 'selected':'' ?>>Ya</option>
				</select>
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