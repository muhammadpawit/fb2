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
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<!-- <select name="bulan" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach($bulan as $b){?>
					<option value="<?php echo $b['bulan']?>" <?php echo $b['bulan']==$bulans?'selected':'';?>><?php echo $b['nama']?></option>
				<?php } ?>
			</select> -->
			<input type="text" id="bulan" name="bulan" class="form-control datepicker" value="<?php echo $bulans ?>">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<!-- <select name="tahun" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php for($i=2021;$i<2030;$i++) {?>
					<option value="<?php echo $i?>" <?php echo $i==$tahun?'selected':'';?> ><?php echo $i?></option>
				<?php } ?>
			</select> -->
			<input type="text" id="tahun" name="tahun" class="form-control datepicker" value="<?php echo $tahun ?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Pilih Divisi</label>
			<select name="divisi" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach($divisis as $b){?>
					<option value="<?php echo $b['id']?>" <?php echo $b['id']==$divisi?'selected':'';?>><?php echo $b['nama']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterbln()">Filter</button>
			<a href="<?php echo $pdf ?>" class="btn btn-sm btn-primary" target="_blank">Print</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
			  <tr align="center">
			  	<th rowspan="2">No.</th>
			    <th rowspan="2">Nama</th>
			    <th rowspan="2">Bagian</th>
			    <th rowspan="2">Tanggal Masuk</th>
			    <th rowspan="2">Gaji/Bulan</th>
			    <th colspan="<?php echo !empty($tgl)?count($tgl):1?>">Kasbon Mingguan (Rp)</th>
			    <th rowspan="2">Sisa Pinjaman</th>
			    <th rowspan="2">Pinjaman baru</th>
			    <th rowspan="2">Sisa Gaji</th>
			    <th rowspan="2">Keterangan</th>
			  </tr>
			  <tr align="center">
			  	<?php if(!empty($tgl)){?>
			  		<?php foreach($tgl as $t){?>
			  			<th><?php echo date('d/m/Y',strtotime($t['tanggal'])) ?></th>
			  		<?php } ?>
			  	<?php }else{ ?>
			  	<?php } ?>
			    
			  </tr>
			</thead>
			<tbody>
			<?php foreach($kar as $k){?>
				<?php $kasbon=0; ?>
			  <tr>
			    <td><?php echo $k['no']?></td>
			    <td><?php echo strtoupper($k['nama'])?></td>
			    <td><?php echo $k['bagian']?></td>
			    <td><?php echo $k['tgl']?><br><small>(<?php echo $k['lama']?>)</small></td>
			    <td><?php echo number_format($k['gaji'])?></td>
			    <?php if(!empty($tgl)){?>
			  		<?php foreach($tgl as $t){?>
			  			<td align="center"><?php echo number_format($this->KasbonModel->getkasbon($k['id'],$t['tanggal'])); ?></td>
						  <?php $kasbon+=($this->KasbonModel->getkasbon($k['id'],$t['tanggal'])); ?>
			  		<?php } ?>
			  	<?php }else{ ?>
			  		<td align="center">-</td>
			  	<?php } ?>
				<td><?php echo !empty($k['sisapinjaman']) ? number_format($k['sisapinjaman']) : 0 ?></td> <!-- sisa pinjaman -->
			    <td><?php echo number_format($k['pinjaman'])?></td> <!-- pinjaman baru -->
			    <td><?php echo number_format($k['gaji']-$kasbon)?></td>
			    <td>ket</td>
			  </tr>
			 <?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function filterbln(){
	    var url='?';
	    // var bulan = $('select[name=\'bulan\']').val();	 
		var bulan = $('#bulan').val();	    
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }

	    // var tahun = $('select[name=\'tahun\']').val();
		var tahun = $('#tahun').val();	    
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }

		var divisi = $('select[name=\'divisi\']').val();
	    if (divisi != '*') {
	      url += '&divisi=' + encodeURIComponent(divisi);
	    }
	    
	    location =url;
	  }
</script>