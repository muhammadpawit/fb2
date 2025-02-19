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
		<h1 class="text-center">Bahan Datang <?php echo bulan()[date('n',strtotime($tanggal1))] .' '.date('Y',strtotime($tanggal1))?></h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Supplier</th>
						<th>Nama</th>
						<th>Jumlah (Roll)</th>
						<th>KG</th>
						<th>Harga (Rp)</th>
						<th>Total (Rp)</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$previous_supplier = null;
					$totalroll = 0;
					$totalyard = 0;
					$totalhg = 0;
					?>

					<?php foreach ($prods as $p) { ?>
						<?php  
						// Jika supplier berubah dan bukan iterasi pertama, tampilkan total sebelumnya
						if ($previous_supplier !== null && $previous_supplier !== $p['supplier']) { ?>
							<tr><td colspan="8"></td></tr>
							<tr>
								<td colspan="4" align="center"><b>Total</b></td>
								<td><b><?php echo number_format($totalroll) ?></b></td>
								<td><b><?php echo number_format($totalyard) ?></b></td>
								<td></td>
								<td><b><?php echo number_format($totalhg) ?></b></td>
							</tr>
							<tr><td colspan="8"></td></tr>
							<?php  
							// Reset total untuk supplier baru
							$totalroll = 0;
							$totalyard = 0;
							$totalhg = 0;
						} 
						?>

						<tr>
							<td><?php echo $p['no'] ?></td>
							<td><?php echo $p['tanggal'] ?></td>
							<td><?php echo $p['supplier'] ?></td>
							<td><?php echo $p['nama'] ?></td>
							<td><?php echo $p['roll'] ?></td>
							<td><?php echo $p['yardkg'] ?></td>
							<td><?php echo number_format($p['harga']) ?></td>
							<td><?php echo number_format($p['total']) ?></td>
						</tr>

						<?php 
						// Akumulasi total
						$totalroll += $p['roll'];
						$totalyard += $p['yardkg'];
						$totalhg += $p['total'];

						// Simpan supplier sebelumnya untuk iterasi berikutnya
						$previous_supplier = $p['supplier'];
						?>
					<?php } ?>

					<?php 
					// Tampilkan total untuk supplier terakhir
					if ($previous_supplier !== null) { ?>
						<tr><td colspan="8"></td></tr>
						<tr>
							<td colspan="4" align="center"><b>Total</b></td>
							<td><b><?php echo number_format($totalroll) ?></b></td>
							<td><b><?php echo number_format($totalyard) ?></b></td>
							<td></td>
							<td><b><?php echo number_format($totalhg) ?></b></td>
						</tr>
					<?php } ?>
				</tbody>

				<tfoot>
					<tr>
						<td colspan="4" align="center"><b></b></td>
						<td><b></b></td>
						<td><b></b></td>
						<td></td>
						<td><b></b></td>
					</tr>
					<tr>
						<td colspan="4" align="center"><b></b></td>
						<td><b></b></td>
						<td><b></b></td>
						<td></td>
						<td><b></b></td>
					</tr>
					
					<tr>
						<td colspan="4" align="center"><b>Grand Total</b></td>
						<td><b><?php echo number_format($roll)?></b></td>
						<td><b><?php echo number_format($yardkg)?></b></td>
						<td></td>
						<td><b><?php echo number_format($total)?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>