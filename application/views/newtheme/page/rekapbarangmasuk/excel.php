<?php
$namafile='Laporan_Rekap_Barang_Masuk'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h1>Laporan Rekap Barang Masuk</h1>
<b>
	<?php 
	foreach($supplier as $s){?>
		<?php echo $cmt==$s['id']?$s['nama']:'';?>
	<?php } ?>
	<?php foreach(bulan() as $b=>$val){?>
		<?php echo $b==$bulan?$val:'';?>
	<?php } ?>
	<?php echo $tahun ?>
</b>
			<table border="1" style="width: 100%;border-collapse: collapse;">
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
							<td><?php echo ($p['harga'])?></td>
							<td><?php echo ($p['qty'])?></td>
							<td><?php echo ($p['qty']*$p['harga'])?></td>
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
						<td><b><?php echo ($qty)?></b></td>
						<td><b><?php echo ($total)?></b></td>
					</tr>
					<tr>
						<td colspan="5"></td>
					</tr>
					<tr>
			          <td colspan="5" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>