<?php
$namafile='Kirim_gudang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>Laporan Kirim Gudang Minggu Ini</h1>
<p>Periode : <?php echo date('d-m-Y',strtotime($tanggal1))?> s.d <?php echo date('d-m-Y',strtotime($tanggal2))?></p>
<table border="1" style="border-collapse: collapse;width:100%">
	<tr>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead>
				<tr>
					<th>Hari</th>
					<th>Tanggal</th>
					<th>Total PO</th>
					<th>Nama PO</th>
					<th>Jml PO</th>
					<th>Jml Dz</th>
					<th>Nilai PO (Rp)</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;$dz=0;?>
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
						<td></td>
						<td><?php echo $p['nama']?></td>
						<td><?php echo $p['jml']?></td>
						<td><?php echo number_format($p['dz'],2)?></td>
						<td><?php echo number_format($p['nilai'])?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php
					$jml+=($p['jml']);
					$nilai+=($p['nilai']);
					$dz+=($p['dz']);
				?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td><?php echo number_format($dz,2)?></td>
					<td><?php echo number_format($nilai)?></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
		</td>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead style="background-color: yellow">
				<tr>
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
				</tr>
			</thead>
			<tbody>
				<?php $jmlkaos=0;$jmlkemeja=0;$jmldzk=0;$jmldzkmj=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<?php 
							$jmlkaos+=$r['jml'];
							$jmldzk+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
				<tr style="background-color: yellow">
					<td colspan="2"><b>Jumlah Kemeja</b></td>
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
							$jmldzkmj+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Kaos</b></td>
						<td><b><?php echo $jmlkemeja?></b></td>
					</tr>
				<?php $celana=0;$jmlc=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==3){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<?php 
							$celana+=$r['jml'];
							$jmlc+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Celana</b></td>
						<td><b><?php echo $celana?></b></td>
					</tr>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo round($jmlkemeja+$jmlkaos+$celana)?></b></td>
					</tr>
			</tbody>
		</table>
		</td>
	</tr>
</table>	
<br>
<table>
	<tr>
          <td colspan="11" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
        </tr>
</table>	