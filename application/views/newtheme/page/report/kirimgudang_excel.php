<?php
$namafile='Kirim_gudang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>Laporan Kirim Gudang Harian</h1>
<p>Periode : <?php echo date('d-m-Y',strtotime($tanggal1))?> s.d <?php echo date('d-m-Y',strtotime($tanggal2))?></p>
<table border="1" style="border-collapse: collapse;width:100%">
	<tr>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead>
				<tr>
					<th>Hari</th>
					<th>Tanggal</th>
					<th>Jml PO</th>
					<th>Nama PO</th>
					<th>Nilai PO (Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;?>
				<?php foreach($products as $p){?>
					<tr>
						<td>
							<?php

								//if(0==$p['no']){
									echo $p['hari'];
								//}

							?>
							
						</td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['jml']?></td>
						<td><?php echo $p['nama']?></td>
						<td><?php echo ($p['nilai'])?></td>
					</tr>
				<?php
					$jml+=($p['jml']);
					$nilai+=($p['nilai']);
				?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo ($nilai)?></td>
				</tr>
			</tfoot>
		</table>
		</td>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead>
				<tr style="background-color: yellow">
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
				</tr>
			</thead>
			<tbody>
				<?php $jmlkaos=0;$jmlkemeja=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<?php 
							$jmlkaos+=$r['jml'];
						?>
					</tr>
					<?php } ?>
				<?php }?>
				<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Kaos</b></td>
						<td><b><?php echo $jmlkaos?></b></td>
					</tr>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==2){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<?php 
							$jmlkemeja+=$r['jml'];
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Kemeja</b></td>
						<td><b><?php echo $jmlkemeja?></b></td>
					</tr>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo $jmlkemeja+$jmlkaos?></b></td>
					</tr>
			</tbody>
		</table>
		</td>
	</tr>
</table>		