<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<form method="post" action="<?php echo $action?>" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Bulan Mulai Produksi</label>
			<select name="bulan" class="form-control" data-live-serch="true">
							<option value="1" <?php echo $s['bulan']==1?'selected':'';?>>Januari</option>
							<option value="2" <?php echo $s['bulan']==2?'selected':'';?>>Februari</option>
							<option value="3" <?php echo $s['bulan']==3?'selected':'';?>>Maret</option>
							<option value="4" <?php echo $s['bulan']==4?'selected':'';?>>April</option>
							<option value="5" <?php echo $s['bulan']==5?'selected':'';?>>Mei</option>
							<option value="6" <?php echo $s['bulan']==6?'selected':'';?>>Juni</option>
							<option value="7" <?php echo $s['bulan']==7?'selected':'';?>>Juli</option>
							<option value="8" <?php echo $s['bulan']==8?'selected':'';?>>Agustus</option>
							<option value="9" <?php echo $s['bulan']==9?'selected':'';?>>September</option>
							<option value="10" <?php echo $s['bulan']==10?'selected':'';?>>Oktober</option>
							<option value="11" <?php echo $s['bulan']==12?'selected':'';?>>November</option>
							<option value="12" <?php echo $s['bulan']==12?'selected':'';?>>Desember</option>
						</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label>Tahun Mulai Produksi</label>
			<select name="tahun" class="form-control">
							<?php for($i=2021;$i<=date('Y',strtotime("+1 Year"));$i++){?>
								<option value="<?php echo $i;?>" <?php echo $s['tahun']==$i?'selected':'';?>><?php echo $i;?></option>
							<?php } ?>
						</select>
		</div>
	</div>
	<div class="col-md-12">
		<button type="submit" class="btn btn-success btn-sm full">Simpan</button>
	</div>
</div>
</form>