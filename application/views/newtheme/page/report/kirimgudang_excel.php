<?php
$namafile='Kirim_gudang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<table style="width:100%">
	<tr>
		<td colspan="12" align="center">
			<h1 style="text-decoration: underline;">Laporan Kirim Gudang Minggu Ini</h1>
		</td>
	</tr>
</table>
<p>Periode : <?php echo date('d-m-Y',strtotime($tanggal1))?> s.d <?php echo date('d-m-Y',strtotime($tanggal2))?></p>
<table border="1" style="border-collapse: collapse;width:100%; text-align:center">
	<tr>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead>
				<tr style="background-color: #d1869e;" align="center">
					<th>No</th>
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
			<tbody align="center">
				<?php $jml=0; $nilai=0;$dz=0;$totalpo=0;$gdz=0;$gnilai=0;?>
				<?php foreach($products as $p){?>
					<tr align="center">
							<td><?php echo $p['no']?></td>
							<td>
								<?php

									//if(0==$p['no']){
										echo $p['hari'];
									//}

								?>
								
							</td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['jml']?> </td>
							<td><?php echo $p['nama']?></td>
							<td><?php //echo $p['jml']?></td>
							
							<td><?php echo $p['dz'] > 0 ? number_format($p['dz'],2):''?></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['nilai']):''?></td>
							<td><?php echo $p['dz'] > 0 ? $p['keterangan']:''?></td>
					</tr>
					<?php foreach($p['dets'] as $d){ ?>
						<tr align="center">
							<td></td>
							<td>
								<?php

									//if(0==$p['no']){
										//echo $p['hari'];
									//}

								?>
								
							</td>
							<td></td>
							<td></td>
							<td><?php echo $d['nama']?></td>
							<td><?php echo $d['jml']?></td>
							
							<td><?php echo number_format($d['dz'], 2, '.', '.') ?></td>
							<td><?php echo number_format($d['nilai'])?></td>
							<td><?php echo $d['keterangan']?></td>
						</tr>

						<?php
							$jml+=($d['jml']);
							$nilai+=($d['nilai']);
							$dz+=($d['dz']);
						?>
					<?php } ?>
					<?php 
						$gdz+=($p['dz']); 
						$gnilai+=($p['nilai']); 
					?>
				<?php } ?>
			</tbody>
			<tfoot align="center">
				<tr style="background-color: yellow;font-weight:700" align="center">
					<td colspan="3" align="center"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo $jml?></td>
					<td><?php echo number_format($dz+$gdz,2)?></td>
					<td><?php echo number_format($nilai+$gnilai)?></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2"><b>Di update terakhir</b></td>
					<td colspan="5">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d F Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
		</td>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead style="background-color: yellow" align="center">
				<tr style="background-color: #d1869e;">
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
				</tr>
			</thead>
			<tbody align="center">
				<?php $jmlkaos=0;$jmlkemeja=0;$jmldzk=0;$jmldzkmj=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr align="center">
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
				<tr style="background-color: yellow" align="center">
					<td colspan="2"><b>Jumlah Kemeja</b></td>
					<td><b><?php echo $jmlkaos?></b></td>
				</tr>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==2){?>
					<tr align="center">
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
					<tr style="background-color: yellow" align="center">
						<td colspan="2"><b>Jumlah Kaos</b></td>
						<td><b><?php echo $jmlkemeja?></b></td>
					</tr>
				<?php $celana=0;$jmlc=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==3){?>
					<tr align="center">
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
					<tr style="background-color: yellow" align="center">
						<td colspan="2"><b>Jumlah Celana</b></td>
						<td><b><?php echo $celana?></b></td>
					</tr>
					<tr style="background-color: yellow" align="center">
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