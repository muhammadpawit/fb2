<div class="row no-print">
	<div class="col-md-3">
		<div class="form-group">
			<a href="<?php echo $tambah ?>" class="btn btn-info full">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Biaya</th>
					<th>Nominal</th>
					<th>PO</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($prods as $p){ ?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $p['nama_biaya']?></td>
						<td><?php echo $p['nominal']?></td>
						<td><?php echo $p['kode_po']?></td>
					</tr>
					<?php $no++ ;?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function filtertglonly_pot(){
		var url='?';
		var tanggal1 =$("#tanggal1").val();
		var tanggal2 =$("#tanggal2").val();
		if(tanggal1){
		url+='&tanggal1='+tanggal1;
		}
		if(tanggal2){
		url+='&tanggal2='+tanggal2;
		}

		var tanggal1_pot =$("#tanggal1_pot").val();
		var tanggal2_pot =$("#tanggal2_pot").val();
		if(tanggal1_pot){
		url+='&tanggal1_pot='+tanggal1_pot;
		}
		if(tanggal2_pot){
		url+='&tanggal2_pot='+tanggal2_pot;
		}

		location =url;
	}
</script>