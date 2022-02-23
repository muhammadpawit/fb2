<div class="row no-print">
	<div class="col-md-12">
		<div class="form-group">
			<button onclick="window.print()" class="btn btn-info btn-xs">Print</button>
			<button onclick="excelwithtgl()" class="btn btn-info btn-xs">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Masuk <?php echo $p['satuan_ukuran_item']?></th>
						<th>Keluar <?php echo $p['satuan_ukuran_item']?></th>
						<th>Saldo <?php echo $p['satuan_ukuran_item']?></th>
						<th>Masuk <?php echo $p['satuan_jumlah_item']?></th>
						<th>Keluar <?php echo $p['satuan_jumlah_item']?></th>
						<th>Saldo <?php echo $p['satuan_jumlah_item']?></th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($kartustok as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
							<td><?php echo $k['nama']?></td>
							<td><?php echo $k['saldomasuk_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['saldokeluar_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['sisa_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['saldomasuk_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['saldokeluar_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['sisa_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['keterangan']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>		
		</div>
	</div>
</div>