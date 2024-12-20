<?php
$namafile='Laporan_Expedisi_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h1>Laporan Expedisi Forboys Production</h1>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Pendapatan</th>
						<th>Pengeluaran</th>
						<th>Saldo</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($prods as $p){?>
						<?php $tgl2=date('Y-m-d',strtotime($p['tanggal']."+6 day"));?>
					<tr>					
							<td><?php echo date('d F',strtotime($p['tanggal']))?> s.d <?php echo date('d F Y',strtotime($p['tanggal']."+6 day"))?></td>
							<td><?php echo ($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,1)); ?></td>
							<td><?php echo ($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,2)); ?></td>
							<td><?php echo ($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,1)-$this->ReportModel->ekspedisi($p['tanggal'],$tgl2,2)); ?></td>
							<td></td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
			          <td colspan="5" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>