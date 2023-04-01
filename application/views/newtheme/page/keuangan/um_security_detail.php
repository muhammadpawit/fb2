<div class="row">
	<div class="col-md-12 text-center">
		<h3>Hitungan Uang Makan Security <?php echo $prods['tempat']==1?'Rumah & Finishing':'Cipadu'?></h3>
	</div>
</div>
<?php if(!isset($edit)){ ?>
<div class="row">
	<div class="col-md-12">
		<p>Periode <?php echo strtolower($prods['periode'])?></p>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Uang Makan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($details as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['nama']?></td>
						<td align="right"><?php echo number_format($p['nominal'])?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td align="right"><b><?php echo number_format($total)?></b></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-12">
		<button onclick="cetak()" class="btn btn-info btn-sm text-white">Cetak</button>
		<button onclick="excel()" class="btn btn-info btn-sm text-white">Excel</button>
		<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Kembali</a>
	</div>
</div>
<?php }else{ ?>
<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id">
	<div class="row">
		<div class="col-md-12">
			<p>Periode <?php echo strtolower($prods['periode'])?></p>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Uang Makan</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($details as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<input type="hidden" name="prods[<?php echo $p['id']?>][id]" value="<?php echo ($p['id'])?>" class="form-control">
								<?php echo ($p['nama'])?>
							</td>
							<td align="right">
								<input type="text" name="prods[<?php echo $p['id']?>][nominal]" value="<?php echo ($p['nominal'])?>" class="form-control">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $p['id']?>][keterangan]" value="<?php echo $p['keterangan']?>" class="form-control"></td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2"><b>Total</b></td>
						<td align="right"><b><?php echo number_format($total)?></b></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<button class="btn btn-success btn-sm full">Simpan</button>
		</div>
		<div class="col-md-6">
			<a href="<?php echo $batal ?>" class="btn btn-sm btn-danger full">Batal</a>
		</div>
	</div>
</form>
<?php } ?>
<script type="text/javascript">
	function cetak(){
		window.print();
	}
	function excel(){
		location='?&excel=1';
	}
</script>