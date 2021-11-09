<?php
$namafile=$title.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	table{width: 100% !important;}
</style>
<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
	<tr>
		<td colspan="10" align="center" valign="top"><h4>Tagihan Bordir<br>Pemilik H.Rizon</h4></td>
	</tr>
</table>
<br>

<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
	         <thead>
                <tr style="background-color: yellow;">
                  <th>Tgl Kirim</th>
                  <th>PO</th>
                  <th>Keterangan</th>
                  <th>Size</th>
                  <th>Sticth</th>
                  <th>Qty</th>
                  <th>Tot Sticth</th>
                  <th>Harga (Pc)</th>
                  <th>Total</th>
                  <th>Ket</th>
                </tr>
              </thead>
              <tbody>
              	<?php $total=0?>
                <?php if(isset($products)){?>
                  <?php foreach($products as $d){?>
                      <tr>
                        <td><?php echo $d['tanggal']?></td>
                        <td><?php echo $d['namapo']?></td>
                        <td><?php echo $d['keterangan']?></td>
                        <td><?php echo $d['size']?></td>
                        <td><?php echo $d['sticth']?></td>
                        <td><?php echo $d['qty']?></td>
                        <td><?php echo $d['totalsticth']?></td>
                        <td><?php echo $d['harga']?></td>
                        <td align="right"><?php echo $d['total']?></td>
                        <td><?php echo $d['ket']?></td>
                      </tr>
                      <?php $total+=($d['total'])?>
                  <?php }?>
                <?php } ?>
              </tbody>
              <tfoot>
              	<tr>
              		<td colspan="8" align="center"><b>Total</b></td>
              		<td align="right"><b><?php echo $total?></b></td>
              	</tr>
              </tfoot>
            </table>
<br>            
<table cellpadding="5">
	<tr>
		<td colspan="3"></td>
		<td>
			<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
				<tr align="center" >
					<td colspan="2">SPV</td>
					<td colspan="2">KA Bordir</td>
					<td colspan="2">Adm Bordir</td>
				</tr>
				<tr height="125">
					<td colspan="2"></td>
					<td colspan="2"></td>
					<td colspan="2"></td>
				</tr>
				<tr align="center">
					<td colspan="2">(Muchlas)</td>
					<td colspan="2"></td>
					<td colspan="2">(Tiara)</td>
				</tr>
			</table>
		</td>
	</tr>
</table>            