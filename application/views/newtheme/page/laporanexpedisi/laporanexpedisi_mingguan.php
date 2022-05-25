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
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama CMT</th>
						<th>Lokasi/Cabang</th>
						<th>Biaya Cas Transport</th>
						<th>Rincian</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalpd=0;?>
					<?php foreach($prods as $p){?>
							<tr>
								<td><?php echo $p['tanggal']?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php foreach($p['pendapatan'] as $pd){?>
							<tr>
								<td></td>
								<td><?php echo $pd['namacmt']?></td>
								<td></td>
								<td><?php echo number_format($pd['nominal'])?></td>
								<td></td>
								<td><?php echo $pd['keterangan']?></td>
							</tr>
							<?php 
								$totalpd+=($pd['nominal']);
							?>
						<?php } ?>
					<?php } ?>
					<tr align="center" style="background-color:#ffa621;font-size:16px">
						<td colspan="3"><b>Total Pendapatan</b></td>
						<td><b><?php echo number_format($totalpd) ?></b></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<tbody>
					<?php $totalpt=0;?>
					<?php foreach($prods as $p){?>
							<tr>
								<td><?php echo $p['tanggal']?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php foreach($p['pengeluaran'] as $pd){?>
							<tr>
								<td></td>
								<td><?php echo $pd['namacmt']?></td>
								<td></td>
								<td><?php echo number_format($pd['nominal'])?></td>
								<td></td>
								<td><?php echo $pd['keterangan']?></td>
							</tr>
							<?php 
								$totalpt+=($pd['nominal']);
							?>
						<?php } ?>
					<?php } ?>
					<tr align="center" style="background-color:#ffa621;font-size:16px">
						<td colspan="3"><b>Total Pengeluaran</b></td>
						<td><b><?php echo number_format($totalpt) ?></b></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr align="center" style="background-color:yellow;font-size:16px">
			          <td colspan="3"><b>Saldo</b></td>
			          <td><b><?php echo number_format($totalpd-$totalpt) ?></b></td>
			          <td></td>
			          <td></td>
			        </tr>
					<tr>
			          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>
			<table class="table table-bordered">
				
			</table>
		</div>
	</div>
</div>