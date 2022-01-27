<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
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
							<td><?php echo number_format($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,1)); ?></td>
							<td><?php echo number_format($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,2)); ?></td>
							<td><?php echo number_format($this->ReportModel->ekspedisi($p['tanggal'],$tgl2,1)-$this->ReportModel->ekspedisi($p['tanggal'],$tgl2,2)); ?></td>
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