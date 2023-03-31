<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<label>Bulan</label>
			<select name="bulan" id="bulan" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b ?>" <?php echo $b==$bulan?'selected':'';?>><?php echo $val ?></option>
				<?php } ?>
			</select>			
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Tahun</label>
			<select name="tahun" class="form-control select2bs4" required>
				<option value="*">Pilih</option>
				<?php for($t=2020;$t<=2050;$t++){?>
				<option value="<?php echo $t?>" <?php echo $tahun==$t?'selected':'';?>><?php echo $t?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Supplier</label>
			<select name="supplier" id="supplier" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach($supplier as $s){?>
				<option value="<?php echo $s['id']?>" <?php echo $cmt==$s['id']?'selected':'';?>><?php echo $s['nama']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-2">
		<label>Tanggal Awal</label>
		<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1?>" autocomplete="off" placeholder="awal" readonly>
	</div>
	<div class="col-md-2">
		<label>Tanggal Akhir</label>
		<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2?>" autocomplete="off" placeholder="akhir" readonly>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filter()"><i class="fa fa-search"></i></button>
			<button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<?php $no=1;?>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Harga</th>
						<th>Qty</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $qty=0;$total=0;?>
					<?php foreach($prods as $p){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo number_format($p['harga'])?></td>
							<td><?php echo number_format($p['qty'])?></td>
							<td><?php echo number_format($p['qty']*$p['harga'])?></td>
						</tr>
					<?php
						$total+=$p['qty']*$p['harga'];
						$qty+=$p['qty'];
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><b>Total Keseluruhan</b></td>
						<td><b><?php echo number_format($qty)?></b></td>
						<td><b><?php echo number_format($total)?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	function filter(){
	    url='?';

	    var tanggal1 =$("#tanggal1").val();
	    var tanggal2 =$("#tanggal2").val();
	    if(tanggal1){
	      url+='&tanggal1='+tanggal1;
	    }
	    if(tanggal2){
	      url+='&tanggal2='+tanggal2;
	    }
	    
	    var bulan = $('select[name=\'bulan\']').val();
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }else{
	    	alert("Bulan harus dipilih");
	    	return false
	    }

	    var tahun = $('select[name=\'tahun\']').val();
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }else{
	    	alert("Tahun harus dipilih");
	    	return false
	    }

	    var supplier = $('select[name=\'supplier\']').val();
	    if (supplier != '*') {
	      url += '&supplier=' + encodeURIComponent(supplier);
	    }else{
	    	alert("Supplier harus dipilih");
	    	return false
	    }


	    location =url;
	  }

	  function excel(){
	    url='?&excel=1';

	    var tanggal1 =$("#tanggal1").val();
	    var tanggal2 =$("#tanggal2").val();
	    if(tanggal1){
	      url+='&tanggal1='+tanggal1;
	    }
	    if(tanggal2){
	      url+='&tanggal2='+tanggal2;
	    }
	    
	    var bulan = $('select[name=\'bulan\']').val();
	    if (bulan != '*') {
	      url += '&bulan=' + encodeURIComponent(bulan);
	    }else{
	    	alert("Bulan harus dipilih");
	    	return false
	    }

	    var tahun = $('select[name=\'tahun\']').val();
	    if (tahun != '*') {
	      url += '&tahun=' + encodeURIComponent(tahun);
	    }else{
	    	alert("Tahun harus dipilih");
	    	return false
	    }

	    var supplier = $('select[name=\'supplier\']').val();
	    if (supplier != '*') {
	      url += '&supplier=' + encodeURIComponent(supplier);
	    }else{
	    	alert("Supplier harus dipilih");
	    	return false
	    }


	    location =url;
	  }
</script>