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
	<!-- <div class="col-md-3">
		<div class="form-group">
			<label>Pilih Bulan</label>
			<select name="bulan" multiple="true" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach($bulan as $b=>$val){?>
					<option value="<?php echo $b ?>" <?php echo $b==$bulans?'selected':'';?>><?php echo $val?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tahun</label>
			<select name="tahun" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php for($i=2021;$i<2030;$i++) {?>
					<option value="<?php echo $i?>" <?php echo $i==$tahun?'selected':'';?> ><?php echo $i?></option>
				<?php } ?>
			</select>
		</div>
	</div> -->
	<div class="col-md-3">
		<div class="form-group">
			<label>Supplier</label>
			<select name="sup" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach($supplier as $s) {?>
					<option value="<?php echo $s['id']?>" <?php echo $sup==$s['id']?'selected':'';?> ><?php echo $s['nama'] ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterbln()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
			  <tr align="center">
			  	<th>Periode</th>
			  	<th>Nama Supplier</th>
			  	<th>Keterangan</th>
			  	<th>Action</th>
			  </tr>
			</thead>
			<tbody>
			<?php foreach($prods as $k){?>
			  <tr>
			    <td><?php echo $k['periode']?></td>
			    <td><?php echo strtoupper($k['nama'])?></td>
			    <td><?php echo $k['ket']?></td>
			    <td>
			    	<a href="<?php echo $k['detail']?>" class="btn btn-success btn-sm">Detail</a>
			    </td>
			  </tr>
			 <?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function filterbln(){
	    var url='?';
	   /*
	    var bulan = $('select[name=\'bulan\']').val();	    
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }

	    var tahun = $('select[name=\'tahun\']').val();
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }
		*/

	    var sup = $('select[name=\'sup\']').val();
	    if (sup != '*') {
	      url += 'sup=' + encodeURIComponent(sup);
	    }
	    
	    location =url;
	  }

	  function excel(){
	    var url='?excel=1';
	   /*
	    var bulan = $('select[name=\'bulan\']').val();	    
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }

	    var tahun = $('select[name=\'tahun\']').val();
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }
		*/

	    var sup = $('select[name=\'sup\']').val();
	    if (sup != '*') {
	      url += '&sup=' + encodeURIComponent(sup);
	    }
	    
	    location =url;
	  }
</script>