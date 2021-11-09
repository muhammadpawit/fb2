<div class="row">
	<div class="col-md-12">
		<table class="table text-center">
			<thead>
				<tr>
					<th colspan="8"><?php echo $u['keterangan']?></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<label>Periode <?php echo $u['periode']?></label>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead class="text-center">
				<tr>
					<th rowspan="2">NO</th>
				    <th class="tg-0pky" colspan="4">PO Pasangan</th>
				    <th class="tg-0pky" rowspan="2">Jumlah</th>
				    <th class="tg-0pky" rowspan="2">Model</th>
				    <th class="tg-0pky" rowspan="2">Ket</th>
				</tr>
			  	<tr>
			    	<td class="tg-0pky">Nama PO</td>
			    	<td class="tg-0pky">Jml Dz</td>
			    	<td class="tg-0pky">Nama PO</td>
			    	<td class="tg-0pky">Jml Dz</td>
			  	</tr>
			</thead>
			<tbody>
				<?php $no=1;$dz1=0;$dz2=0;$total=0;?>
				<?php foreach($d as $dt){?>
					<?php
						$dz1+=$dt['jml_dz1'];
						$dz2+=$dt['jml_dz2'];
						$total+=$dt['jumlah'];
					?>
					<tr>
						<td><?php echo $no++?></td>
						<td><?php echo $dt['po1']?></td>
						<td><?php echo $dt['jml_dz1']?></td>
						<td><?php echo $dt['po2']?></td>
						<td><?php echo $dt['jml_dz2']?></td>
						<td><?php echo $dt['jumlah']?></td>
						<td><?php echo $dt['model']?></td>
						<td><?php echo $dt['keterangan']?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td><?php echo $dz1?></td>
					<td></td>
					<td><?php echo $dz2?></td>
					<td><?php echo $total?></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-12 text-right">
		<a href="<?php echo $batal?>" class="btn btn-danger">Cancel</a>
		<button onclick="window.print()" class="btn btn-info">Cetak</button>
		<a href="<?php echo $excel?>" class="btn btn-success">Excel</a>
	</div>
</div>