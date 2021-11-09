<?php
$namafile='laporan_Rekap_Kirim_Setor_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>
	<label>Rekap <?php echo $cmtnya?> Bulan : <?php echo $bln ?> <?php echo $tahun ?></label>
</h1>
<?php foreach($products as $pds){?>
<caption><?php echo $pds['nama']?></caption>
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead class="thead-light">
				<tr>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Nama PO</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;background-color: #1db4f5 !important">Rekap Kirim CMT</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;background-color:#f5a91d !important">Rekap Setor CMT</th>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Keterangan</th>
				</tr>
				<tr>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml1=0;$jml2=0;$kirimdz=0;$kirimpcs=0;$setordz=0;$setorpcs=0;?>
				<?php foreach($pds['prods'] as $p){?>
					<?php 
						$jml1+=($p['jmlkirim']);
						$jml2+=($p['jmlsetor']);
						$kirimdz+=($p['kirimdz']);
						$kirimpcs+=($p['kirimpcs']);
						$setordz+=($p['setordz']);
						$setorpcs+=($p['setorpcs']);
						?>
					<tr>
						<td><?php echo $p['nama']?></td>
						<td align="center"><?php echo $p['jmlkirim']?></td>
						<td align="center"><?php echo number_format($p['kirimdz'],2)?></td>
						<td align="center"><?php echo $p['kirimpcs']?></td>
						<td align="center"><?php echo $p['jmlsetor']?></td>
						<td align="center"><?php echo number_format($p['setordz'],2)?></td>
						<td align="center"><?php echo $p['setorpcs']?></td>
						<td></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td align="center"><b>Total</b></td>
					<td align="center"><b><?php echo $jml1 ?></b></td>
					<td align="center"><b><?php echo number_format($kirimdz,2)?></b></td>
					<td align="center"><b><?php echo $kirimpcs?></b></td>
					<td align="center"><b><?php echo $jml2?></b></td>
					<td align="center"><b><?php echo number_format($setordz,2)?></b></td>
					<td align="center"><b><?php echo $setorpcs?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
		<br>	
<?php } ?>		