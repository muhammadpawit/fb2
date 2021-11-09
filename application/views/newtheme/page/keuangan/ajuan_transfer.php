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
			<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group text-right">
			<br>
			<button onclick="filtertglonly()" class="btn btn-info">Filter</button>
			<a href="<?php echo $tambah?>" class="btn btn-info text-white">Tambah</a>
			<a href="<?php echo $bayar?>" class="btn btn-success text-white">Pembayaran</a>
			<a href="<?php echo $excel?>" class="btn btn-warning text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Pembayaran</th>
					<th>Metode</th>
					<th>Atas Nama</th>
					<th>No.Rekening</th>
					<th>Tgl Nota/Barang</th>
					<th>Jumlah (Rp)</th>
					<th>Tgl Bayar</th>
					<th>Status</th>
					<th>Keterangan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['pembayaran']?></td>
						<td><?php echo $p['metode']?></td>
						<td><?php echo $p['a_nama']?></td>
						<td><?php echo $p['no_rek']?></td>
						<td><?php echo $p['tgl_nota']?></td>
						<td align="right"><?php echo number_format($p['nominal'])?>&nbsp;</td>
						<td><?php echo $p['tglbayar']?></td>
						<td><?php echo $p['status_pemb']?></td>
						<td><?php echo $p['keterangan']?></td>
						<td>
							<?php if(akseshapus()==1){?>
								<a href="<?php echo $p['hapus']?>" class="btn btn-danger btn-sm text-white">Batalkan</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>