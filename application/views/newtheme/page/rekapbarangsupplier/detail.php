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
	<div class="col-md-2">
		<div class="form-group">
			<label>Aksi</label><br>
			<a href="<?php echo $cancel?>" class="btn btn-info btn-sm">Batal</a>
		</div>
	</div>
</div>
<div class="row text-center">
	<div class="col-md-12">
		<h3>
			REKAPAN BARANG MASUK SUPPLIER ( <?php echo strtoupper($nama)?> )				
		</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
			  <tr align="center">
			  	<th>Periode</th>
			  	<th>Nama Supplier</th>
			  	<th>Total (Rp)</th>
			  	<th>Keterangan</th>
			  </tr>
			</thead>
			<tbody>
			<?php $total=0;?>
			<?php foreach($d as $k){?>
			  <tr>
			    <td>
			    	<?php echo date('d',strtotime($k['tanggal_awal']))?> - <?php echo date('d-m-Y',strtotime($k['tanggal_akhir']))?></td>
			    <td><?php echo strtoupper($k['nama'])?></td>
			    <td align="right"><?php echo number_format($k['total'],2)?></td>
			    <td>
			    	-
			    </td>
			  </tr>
			  <?php $total+=($k['total']);?>
			 <?php } ?>
			 	<tr>
			 		<td colspan="2" align="center"><b>Total</b></td>
			 		<td align="right"><b><?php echo number_format($total,2) ?></b></td>
			 		<td></td>
			 	</tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function filterbln(){
	    var url='?';
	    var bulan = $('select[name=\'bulan\']').val();	    
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }

	    var tahun = $('select[name=\'tahun\']').val();
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }
	    
	    location =url;
	  }
</script>