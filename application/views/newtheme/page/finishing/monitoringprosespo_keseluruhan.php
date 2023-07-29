<div class="row">
	<div class="col-md-12">
		<div class="form-group text-center">
			<label>Monitoring PO Kaos (Keseluruhan)<br>Tahun Produksi 2023-2024</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>PO Kemeja</label>
			<table class="table table-bordered table striped">
				<thead>
					<tr>
						<th>Jenis PO</th>
						<td>Jumlah PO</td>
						<td>QC</td>
						<td>LB Kancing</td>
						<td>Siap Cucian</td>
						<td>Proses Cucian</td>
						<td>Siap Buang Benang</td>
						<td>Proses Buang Benang</td>
						<td>Siap Packing</td>
						<td>Proses Packing</td>
						<td>Siap Kirim Gudang</td>
						<td>Pending</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($kemeja as $k){?>
						<?php if($k['jmlpo'] >0){ ?>
							<tr>
								<td><?php echo $k['nama']?></td>
								<td><?php echo $k['jmlpo']?></td>
								<td><?php echo $k['qc']?></td>
								<td><?php echo $k['kancing']?></td>
								<td><?php echo $k['siapcucian']?></td>
								<td><?php echo $k['prosescucian']?></td>
								<td><?php echo $k['siapbuangbenang']?></td>
								<td><?php echo $k['prosesbuangbenang']?></td>
								<td><?php echo $k['siappacking']?></td>
								<td><?php echo $k['prosespacking']?></td>
								<td><?php echo $k['siapkirimgudang']?></td>
								<td><?php echo $k['pending']?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row table-responsive">
	<div class="col-md-12">
		<div class="form-group">
			<label>PO Kaos</label>
			<table class="table table-bordered table striped">
				<thead style="background-color: pink;">
					<tr style="text-align:center;font-weight:bold">
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
						<td colspan="13">Di Update terakhir 
							<?php if(!empty($log)){ ?>
								<b><?php echo $log['oleh']; ?>, tanggal : <?php echo date('d F Y H:i:s',strtotime($log['tanggal'])); ?></b>
							<?php } ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1>Laporan Bulanan :</h1>
        <?php foreach($bul as $b){ ?>
            <a href="<?php echo $b['link']?>" class="btn btn-primary"><?php echo $b['bulan']?></a>
        <?php } ?>
    </div>
</div>
<!-- <div class="row no-print">
	<div class="col-md-6">
		<div class="form-group">
			<button onclick="window.print()" class="btn btn-info btn-sm full">Print</button>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<button onclick="filtertglonly_excel()" class="btn btn-success btn-sm full">Excel</button>
		</div>
	</div>
</div> -->