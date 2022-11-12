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
			<label>Tanggal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<!-- <div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div> -->
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
		<h1 class="text-center">Rincian Pengambilan Bahan Keluar <?php echo bulan()[date('n',strtotime($tanggal1))] .' '.date('Y',strtotime($tanggal1))?></h1>
	</div>
</div>
<div class="row">
	<div class="col-md-7">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th align="center">Jumlah (Roll)</th>
						<th align="center" colspan="2">Satuan</th>
						<!-- <th>Harga (Rp)</th>
						<th>Total (Rp)</th> -->
					</tr>
				</thead>
				<tbody>
					<?php foreach($prods as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['roll']?></td>
							<td><?php echo $p['yardkg']?></td>
							<td><?php echo $p['satuan']?></td>
							<!-- <td><?php echo number_format($p['harga'])?></td>
							<td><?php echo number_format($p['total'])?></td> -->
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center"><b>Total</b></td>
						<td><b><?php echo number_format($roll)?></b></td>
						<td><b><?php echo number_format($yardkg)?></b></td>
						<!-- <td></td>
						<td><b><?php echo number_format($total)?></b></td> -->
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Kemeja</h3>
		</div>
	</div>
</div>