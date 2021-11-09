<div class="row">
	<div class="col-md-12 text-center">
		<h4>Laporan Pembayaran Hasil Kerja Tim Potong <?php echo $timnya['nama']?></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama PO</th>
					<th>JML PO (Dz)</th>
					<th>JML PO (Pcs)</th>
					<th>Harga/Pcs</th>
					<th>Total Pendapatan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo number_format($p['lusin'],2)?></td>
						<td><?php echo number_format($p['pcs'])?></td>
						<td><?php echo number_format($p['harga'])?></td>
						<td><?php echo number_format($p['total'])?></td>
						<td></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="6"><b></b></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Total</b></td>
					<td><b><?php echo $total?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Saving 5%</b></td>
					<td><b><?php echo $saving?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Total yang diterima</b></td>
					<td><b><?php echo $nominal?></b></td>
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
<script type="text/javascript">
	
	function cetak(){
		window.print();
	}

	function excel(){
		var url='?&excel=1';
		location =url;
	}
</script>