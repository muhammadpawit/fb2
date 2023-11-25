<?php
$namafile='Kirim_gudang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");

?>
<table style="width:100%">
	<tr>
		<td colspan="12" align="center">
			<h1 style="text-decoration: underline;">
				Laporan Kirim Gudang Minggu Ini<br>
				<small style="font-size:22px !important">
				Periode : <?php echo date('m',strtotime($tanggal1)) == date('m',strtotime($tanggal2)) ? date('d',strtotime($tanggal1)) :date('d-m-Y',strtotime($tanggal1))?> s.d <?php echo date('d-m-Y',strtotime($tanggal2))?>
				</small>
			</h1>
			<br><br>
		</td>
	</tr>
</table>

<table border="1" style="border-collapse: collapse;width:100%; text-align:center">
	<tr>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead>
				<tr style="background-color: #cdfacf;">
					<th rowspan="2">NO</th>
					<th rowspan="2">Hari/Tanggal</th>
					<th rowspan="2">PO Dikirim</th>
					<th rowspan="2">Jenis PO</th>
					<th colspan="3">Jumlah</th>
					<th rowspan="2">Nilai PO (Rp)</th>
					<th rowspan="2">Keterangan</th>
				</tr>
				<tr style="background-color: #cdfacf;">
					<th>PO</th>
					<th>DZ</th>
					<th>PCS</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;$dz=0;$gdz=0;$gnilai=0;$pcs=0;?>
				<?php foreach($products as $p){?>
					<tr>
							<td align="center"><?php echo $p['no']?></td>
							<td>
								<?php

									//if(0==$p['no']){
										echo $p['hari'].'/'.$p['tanggal'];
									//}

								?>
								
							</td>
							<td align="center"><?php echo $p['jml'] ?></td>
							<td></td>
							<td></td>
							<td align="center"><?php echo $p['dz'] > 0 ? number_format($p['dz'],2):''?></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['dz']*12):''?></td>
							<td align="center"><?php echo $p['dz'] > 0 ? number_format($p['nilai']):''?></td>
							<td><?php echo $p['dz'] > 0 ? $p['keterangan']: ''?></td>
					</tr>
					<?php foreach($p['dets'] as $d){ ?>
						
						<?php if($d['jml'] > 0){ ?>
							<tr>
								<td></td>
								<td>
									<?php

										//if(0==$p['no']){
											//echo $p['hari'];
										//}

									?>
									
								</td>
								<td></td>
								<td align="center"><?php echo $d['nama']?></td>
								<td align="center"><?php echo $d['jml']?></td>
								<td align="center"><?php echo number_format($d['dz'],2)?></td>
								<td><?php echo number_format($d['dz']*12)?></td>
								<td align="center"><?php echo number_format($d['nilai'])?></td>
								<td><?php echo $d['keterangan']?></td>
							</tr>
						<?php } ?>

						<?php
							$jml+=($d['jml']);
							$nilai+=($d['nilai']);
							$dz+=($d['dz']);
							$pcs+=($d['dz']*12);
						?>
					<?php } ?>
					<?php 
						$gdz+=($p['dz']); 
						$gnilai+=($p['nilai']); 
					?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr style="background-color: #cdfacf;font-weight:700">
					<td colspan="2" align="center"><b>Total</b></td>
					<td align="center"><?php echo $jml?></td>
					<td></td>
					<td align="center"><?php echo $jml?></td>
					<td align="center"><?php echo number_format($dz+$gdz,2)?></td>
					<td><?php echo number_format($pcs)?></td>
					<td align="center"><?php echo number_format($nilai+$gnilai)?></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><b>Di update terakhir</b></td>
					<td colspan="5">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d-m-Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
		</td>
		<td>
			<table border="1" style="border-collapse: collapse;width:100%">
			<thead style="background-color: #cdfacf" align="center">
				<!-- <tr style="background-color: #d1869e;">
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
				</tr> -->
				<tr style="background-color: #cdfacf;">
					<th class="tg-0pky" rowspan="2">Resume</th>
					<th class="tg-0pky" rowspan="2">Jenis PO</th>
					<th class="tg-0pky" colspan="3">Jumlah</th>
				</tr>
				<tr style="background-color: #cdfacf;">
					<th class="tg-0pky">PO</th>
					<th class="tg-0pky">DZ</th>
					<th class="tg-0pky">PCS</th>
				</tr>
			</thead>
			<tbody align="center">
				<?php $jmlkaos=0;$jmlkemeja=0;$jmldzk=0;$jmldzkmj=0;$jmlpcsk=0;$jmlpcskmj=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr align="center">
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$jmlkaos+=$r['jml'];
							$jmldzk+=($r['dz']);
							$jmlpcsk+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
				<tr style="background-color: #cdfacf" align="center">
					<td><b>Jumlah Kemeja</b></td>
					<td></td>
					<td><b><?php echo $jmlkaos?></b></td>
					<td><b><?php echo number_format($jmlpcsk)?></b></td>
					<td></td>
				</tr>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==2){?>
					<tr align="center">
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$jmlkemeja+=$r['jml'];
							$jmldzkmj+=($r['dz']);
							$jmlpcskmj+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: #cdfacf" align="center">
						<td><b>Jumlah Kaos</b></td>
						<td></td>
						<td><b><?php echo $jmlkemeja?></b></td>
						
						<td></td>
						<td><b><?php echo number_format($jmlpcskmj)?></b></td>
					</tr>
				<?php $celana=0;$jmlc=0;$jmlcpcs=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==3){?>
					<tr align="center">
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$celana+=$r['jml'];
							$jmlc+=($r['dz']);
							$jmlcpcs+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: #cdfacf" align="center">
						<td><b>Jumlah Celana</b></td>
						<td></td>
						<td><b><?php echo $celana?></b></td>
						<td><b><?php echo number_format($jmlcpcs)?></b></td>
						<td></td>
					</tr>
					<tr style="background-color: #cdfacf" align="center">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo ($jmlkemeja+$jmlkaos+$celana)?></b></td>
						<td><b><?php echo number_format($dz+$gdz,2)?></b></td>
						<td><b><?php echo number_format(($jmldzk+$jmldzkmj+$jmlc)*12)?></b></td>
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