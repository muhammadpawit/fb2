<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Jenis</label>
			<select name="jenis" id="jenis" class="form-control select2bs4">
				<option value="*"></option>
				<option value="1" <?php echo $jenis==1?'selected':'' ?>>Kemeja</option>
				<option value="2" <?php echo $jenis==2?'selected':'' ?>>Kaos</option>
				<option value="3" <?php echo $jenis==3?'selected':'' ?>>Celana</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-sm btn-primary" onclick="fil()">Filter</button>
			<button class="btn btn-sm btn-success" onclick="ex()">Excel</button>
		</div>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama CMT</th>
					<th>Kode PO</th>
					<th>Jumlah Bangke (pcs)</th>
					<th>Jumlah Rijek (pcs)</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $total=0;$rijek=0;?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['cmt']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['bangke']?></td>
						<td><?php echo $p['rijek']?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php $total+=($p['bangke']);?>
				<?php $rijek+=($p['rijek']);?>
				<?php } ?>
				<tr>
					<td colspan="4"><b>Total</b></td>
					<td><b><?php echo $total ?></b></td>
					<td><b><?php echo $rijek ?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function fil(){
		var url='?';
		var jenis=$("#jenis").val();
		if(jenis!='*'){
			url+='&jenis='+jenis;
		}
		location = url;
	}

	function ex(){
		var url='?&excel=1';
		var jenis=$("#jenis").val();
		if(jenis!='*'){
			url+='&jenis='+jenis;
		}
		location = url;
	}
</script>