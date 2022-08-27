<?php
$namafile='Laporan_Bulanan_Rekapan_Supplier_'.time();
//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table border="1" style="width: 100%;border-collapse: collapse;">
	<thead>
		<tr>
			<th colspan="4">
				<h3>
					<?php foreach($supplier as $s) {?>
						<?php if($s['id']==$sup) { ?>
						REKAPAN SUPPLIER ( <?php echo $s['nama'] ?> )
						<?php } ?>
					<?php } ?>
				</h3>
			</th>
		</tr>
	</thead>
</table>
			<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
			  <tr align="center">
			  	<th>NO</th>
			  	<th>BULAN</th>
			  	<th>JUMLAH ( Rp )</th>
			  	<th>KET</th>
			  </tr>
			</thead>
			<tbody>
			<?php $no=1; ?>
			<?php foreach($prods as $k){?>
			  <tr>
			    <td><?php echo $no++?></td>
			    <td><?php echo strtoupper($k['periode'])?></td>
			    <td>
			    	<?php echo number_format($k['total'],2)?>
			    </td>
			    <td>
			    	<?php echo $k['ket']?>
			    </td>
			  </tr>
			 <?php } ?>
			</tbody>
		</table>