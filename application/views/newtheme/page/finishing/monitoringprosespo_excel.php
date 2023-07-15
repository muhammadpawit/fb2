<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Monitoring_PO_".time().".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<label>PO Kaos</label>
            <table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>Type/Jenis</th>
						<td>Jumlah PO</td>
						<td>QC</td>
						<td>Siap Cucian</td>
						<td>Proses Cucian</td>
						<td>Siap Kirim CMT</td>
						<td>Proses Packing</td>
						<td>Kirim Sample</td>
						<td>Retur</td>
						<td>Siap Kirim Gudang</td>
						<td>Pending</td>
						<td>Selesai</td>
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
					<tr align="center">
						<td><b>Total</b></td>
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
						<td colspan="12">Di Update terakhir 
							<?php if(!empty($log)){ ?>
								<b><?php echo $log['oleh']; ?>, tanggal : <?php echo date('d F Y H:i:s',strtotime($log['tanggal'])); ?></b>
							<?php } ?>
						</td>
					</tr>
                    <tr>
			          <td colspan="12" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>