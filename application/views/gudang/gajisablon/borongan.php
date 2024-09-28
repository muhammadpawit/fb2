<div class="row no-print">
	<div class="col-md-4">
		<div class="form-group">
			<label>Nama Karyawan</label>
			<select name="id_karyawan_harian" class="select2bs4 kar" required>
				<option value="*"></option>
				<?php foreach($kar as $k){ ?>
					<option value="<?php echo $k['id']?>" data-item="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button onclick="window.print()" class="btn btn-info btn-sm">Print</button>
			<button onclick="excelwithtgl()" class="btn btn-info btn-sm">Excel</button>
			 <a class="btn btn-info btn-sm" href="<?php echo $tambah ?>">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Kode PO</th>
						<th>Gambar</th>
						<th>Model</th>
						<th>Lusin</th>
						<th>Putaran</th>
						<th>Harga</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$total=0;?>
					<?php foreach($prods as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $k['tanggal'] ?></td>
							<td><?php echo $k['namakar'] ?></td>
							<td><?php echo $k['kode_po'] ?></td>
							<td><?php echo $k['gambar'] ?></td>
							<td><?php echo $k['model'] ?></td>
							<td><?php echo $k['dz'] ?></td>
							<td><?php echo $k['putaran'] ?></td>
							<td><?php echo $k['harga'] ?></td>
							<td><?php echo $k['total'] ?></td>
							<td>
								<a href="<?php echo BASEURL?>Gajisablon/hapusborongan/<?php echo $k['id']?>" onclick="return confirm('Apakah yakin?')" class="btn btn-xs btn-danger btn-xs"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php $total+=($k['total']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9"><b>Total</b></td>
						<td>
							<b><?php echo number_format($total) ?></b>
						</td>
					</tr>
				</tfoot>
			</table>		
		</div>
	</div>
</div>