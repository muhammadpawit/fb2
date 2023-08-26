<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Monitoring_PO_Kaos".time().".xls");
?>
<table border="0" style="border-collapse: collapse;width: 100%;" cellpadding="12">
  	<tr>
		<th align="center" colspan="13">
		<label>Monitoring PO Kaos<br>Keseluruhan<br>Tahun Produksi 2023-2024</label>
		</th>
	</tr>
</table>

			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead style="background-color: pink;">
					<tr style="text-align:center;font-weight:bold">
						<th rowspan="2">No</th>
						<th rowspan="2">Jenis PO</th>
						<td rowspan="2">Jumlah PO Setor</td>
						<td rowspan="2">Proses Cek BPO</td>
						<td colspan="4">PO Celana Jeans</td>
						<td rowspan="2">Kirim Sample Toko</td>
						<td rowspan="2">Retur Ke CMT</td>
						<td rowspan="2">Siap Kirim Gudang</td>
						<td rowspan="2">PO Permak</td>
						<td rowspan="2">PO Sudah Kirim Gudang HS</td>
					</tr>
					<tr style="text-align:center;font-weight:bold">
						<td>Siap Masuk Laundry</td>
						<td>Proses Laundry</td>
						<td>Siap Kirim Ke CMT</td>
						<td>Proses Packing Di CMT</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$jmlpo=0;
						$qc=0;
						$siapcucian=0;
						$prosescucian=0;
						$siapkirimcmt=0;
						$prosespacking=0;
						$kirimsample=0;
						$retur=0;
						$siapkirimgudang=0;
						$pending=0;
						$selesai=0;
						$no_1=1;
						$no_2=1;
						
					?>
					<?php foreach($kaos_all as $k){?>
						<?php if($k['jmlpo'] > 0){ ?>
							<tr align="center">
								<td><?php echo $no_1++;?></td>
								<td><?php echo $k['nama']?></td>
								<td><?php echo $k['jmlpo']?></td>
								<td><?php echo $k['qc']?></td>
								<td><?php echo $k['siapcucian']?></td>
								<td><?php echo $k['prosescucian']?></td>
								<td><?php echo $k['siapkirimcmt']?></td>
								<td><?php echo $k['prosespacking']?></td>
								<td><?php echo $k['kirimsample']?></td>
								<td><?php echo $k['retur']?></td>
								<td><?php echo $k['siapkirimgudang']?></td>
								<td><?php echo $k['pending']?></td>
								<td><?php echo $k['selesai']?></td>
							</tr>
							<?php
								$jmlpo+=($k['jmlpo']);
								$qc+=($k['qc']);
								$siapcucian+=($k['siapcucian']);
								$prosescucian+=($k['prosescucian']);
								$siapkirimcmt+=($k['siapkirimcmt']);
								$prosespacking+=($k['prosespacking']);
								$kirimsample+=($k['kirimsample']);
								$retur+=($k['retur']);
								$siapkirimgudang+=($k['siapkirimgudang']);
								$pending+=($k['pending']);
								$selesai+=($k['selesai']);
							?>
						<?php } ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center" style="background-color: yellow;">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo $jmlpo ?></b></td>
						<td><b><?php echo $qc ?></b></td>
						<td><b><?php echo $siapcucian ?></b></td>
						<td><b><?php echo $prosescucian ?></b></td>
						<td><b><?php echo $siapkirimcmt ?></b></td>
						<td><b><?php echo $prosespacking ?></b></td>
						<td><b><?php echo $kirimsample ?></b></td>
						<td><b><?php echo $retur ?></b></td>
						<td><b><?php echo $siapkirimgudang ?></b></td>
						<td><b><?php echo $pending ?></b></td>
						<td><b><?php echo $selesai ?></b></td>
					</tr>
					<!-- <tr>
						<td colspan="13">Di Update terakhir 
							<?php if(!empty($log)){ ?>
								<b><?php echo $log['oleh']; ?>, tanggal : <?php echo date('d F Y H:i:s',strtotime($log['tanggal'])); ?></b>
							<?php } ?>
						</td>
					</tr> -->
				</tfoot>
			</table>

            <label>PO Kaos Bulanan</label>
                <table border="1" style="width: 100%;border-collapse: collapse;">
				<thead style="background-color: pink;">
					<tr style="text-align:center;font-weight:bold">
						<th rowspan="2">No</th>
						<th rowspan="2">Jenis PO</th>
						<td rowspan="2">Jumlah PO Setor</td>
						<td rowspan="2">Proses Cek BPO</td>
						<td colspan="4">PO Celana Jeans</td>
						<td rowspan="2">Kirim Sample Toko</td>
						<td rowspan="2">Retur Ke CMT</td>
						<td rowspan="2">Siap Kirim Gudang</td>
						<td rowspan="2">PO Permak</td>
						<td rowspan="2">PO Sudah Kirim Gudang HS</td>
					</tr>
					<tr style="text-align:center;font-weight:bold">
						<td>Siap Masuk Laundry</td>
						<td>Proses Laundry</td>
						<td>Siap Kirim Ke CMT</td>
						<td>Proses Packing Di CMT</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$jmlpo=0;
						$qc=0;
						$siapcucian=0;
						$prosescucian=0;
						$siapkirimcmt=0;
						$prosespacking=0;
						$kirimsample=0;
						$retur=0;
						$siapkirimgudang=0;
						$pending=0;
						$selesai=0;
						
					?>
					<?php foreach($kaos as $k){?>
						<?php if($k['jmlpo'] > 0){ ?>
							<tr align="center">
								<td><?php echo $no_2++;?></td>
								<td><?php echo $k['nama']?></td>
								<td><?php echo $k['jmlpo']?></td>
								<td><?php echo $k['qc']?></td>
								<td><?php echo $k['siapcucian']?></td>
								<td><?php echo $k['prosescucian']?></td>
								<td><?php echo $k['siapkirimcmt']?></td>
								<td><?php echo $k['prosespacking']?></td>
								<td><?php echo $k['kirimsample']?></td>
								<td><?php echo $k['retur']?></td>
								<td><?php echo $k['siapkirimgudang']?></td>
								<td><?php echo $k['pending']?></td>
								<td><?php echo $k['selesai']?></td>
							</tr>
							<?php
								$jmlpo+=($k['jmlpo']);
								$qc+=($k['qc']);
								$siapcucian+=($k['siapcucian']);
								$prosescucian+=($k['prosescucian']);
								$siapkirimcmt+=($k['siapkirimcmt']);
								$prosespacking+=($k['prosespacking']);
								$kirimsample+=($k['kirimsample']);
								$retur+=($k['retur']);
								$siapkirimgudang+=($k['siapkirimgudang']);
								$pending+=($k['pending']);
								$selesai+=($k['selesai']);
							?>
						<?php } ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center" style="background-color: yellow;">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo $jmlpo ?></b></td>
						<td><b><?php echo $qc ?></b></td>
						<td><b><?php echo $siapcucian ?></b></td>
						<td><b><?php echo $prosescucian ?></b></td>
						<td><b><?php echo $siapkirimcmt ?></b></td>
						<td><b><?php echo $prosespacking ?></b></td>
						<td><b><?php echo $kirimsample ?></b></td>
						<td><b><?php echo $retur ?></b></td>
						<td><b><?php echo $siapkirimgudang ?></b></td>
						<td><b><?php echo $pending ?></b></td>
						<td><b><?php echo $selesai ?></b></td>
					</tr>
					<tr>
						<td colspan="13">Di Update terakhir 
							<?php if(!empty($log)){ ?>
								<b><?php echo $log['oleh']; ?>, tanggal : <?php echo date('d F Y H:i:s',strtotime($log['tanggal'])); ?></b>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td colspan="13" align="right">
						<i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
						</td>
					</tr>
				</tfoot>
			</table>