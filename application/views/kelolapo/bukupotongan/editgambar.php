<div class="row">
	<div class="col-md-12">
		<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>
	</div>
</div>
<form method="post" enctype="multipart/form-data" action="<?php echo $action ?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input type="hidden" name="kode_po" value="<?php echo $kode_po?>">
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Gambar Bahan Utama 1</th>
						<th>Gambar Bahan Utama 2</th>
					</tr>
					<tr>
						<th>
							<img style="height: 249px;width: 100%;" src="<?php echo $prods['sample_bahan_utama_img'] ?>"><br>
							<input type="hidden" name="gbrbahanold" value="<?php echo $prods['sample_bahan_utama_img'] ?>"><br>
							<label>Silahkan upload gambar baru</label>
							<input type="file" name="gbrbahan" class="form-control">
						</th>
						<th>
							<img style="height: 249px;width: 100%;" src="<?php echo $prods['sample_bahan_utama_img2'] ?>"><br>
							<input type="hidden" name="gbrbahan2old" value="<?php echo $prods['sample_bahan_utama_img2'] ?>"><br>
							<label>Silahkan upload gambar baru</label>
							<input type="file" name="gbrbahan2" class="form-control">
						</th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<input type="hidden" name="kode_po" value="<?php echo $kode_po?>">
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Gambar Bahan Variasi 1</th>
						<th>Gambar Bahan Variasi 2</th>
					</tr>
					<tr>
						<th>
							<img style="height: 249px;width: 100%;" src="<?php echo $prods['sample_bahan_variasi_img'] ?>"><br>
							<input type="hidden" name="gbrbahanold" value="<?php echo $prods['sample_bahan_variasi_img'] ?>"><br>
							<label>Silahkan upload gambar baru</label>
							<input type="file" name="gbrbahanvar1" class="form-control">
						</th>
						<th>
							<img style="height: 249px;width: 100%;" src="<?php echo $prods['sample_bahan_variasi_img2'] ?>"><br>
							<input type="hidden" name="gbrbahanvar2old" value="<?php echo $prods['sample_bahan_variasi_img2'] ?>"><br>
							<label>Silahkan upload gambar baru</label>
							<input type="file" name="gbrbahanvar2" class="form-control">
						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn btn-info btn-sm">Simpan</button>
			<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm text-white">Kembali</a>
		</div>
	</div>
</form>