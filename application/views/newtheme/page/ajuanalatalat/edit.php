<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
	<input type="hidden" name="bagian" value="<?php echo $prods['bagian'] ?>">
	<input type="hidden" name="stok" value="<?php echo $prods['stok'] ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama Barang</label>
				<select name="id_persediaan" class="form-control select2bs4" disabled readonly>
					<?php foreach($barang as $b){ ?>
						<option value="<?php echo $b['id_persediaan']?>"
							<?php echo $b['id_persediaan']==$prods['id_persediaan']?'selected':'';?>><?php echo $b['nama_item']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Stok</label><br>
				<b><?php echo $prods['stok'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Ajuan</label><br>
				<b><?php echo $prods['ajuan'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Kebutuhan</label><br>
				<input type="text" name="kebutuhan" value="<?php echo $prods['kebutuhan'] ?>" class="form-control" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Keterangan</label><br>
				<input type="text" name="keterangan" value="<?php echo $prods['keterangan'] ?>" class="form-control">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal Ajuan</label><br>
				<input type="text" name="tanggal" value="<?php echo $prods['tanggal'] ?>" class="form-control datepicker" autocomplete="off">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<button class="btn btn-success btn-sm full">Simpan</button>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
			</div>
		</div>
	</div>
</form>
<h2>Laporan Mingguan Alat-alat Forboys Production</h2>
<div class="table-responsive">
			<table border="1" cellpadding="3" style="border-collapse: collapse;width: 100%" >
				<thead style="text-align: center;">
				  <tr style="text-align: center !important;">
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="4"><center>Stok</center></th>
		            <th rowspan="2">Satuan</th>
		            <th rowspan="2">Harga</th>
		            <th rowspan="2">Total</th>
		            <th rowspan="2">Ket</th>
		            <th rowspan="2">Barang Masuk Terakhir</th>
		          </tr>
		          <tr style="text-align: center !important;">
				  	<th>Awal </th>
		            <th>Masuk</th>
		            <th>Keluar</th>
		            <th>Stok</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		$stokawalroll=0;
		        		$stokawalyard=0;
		        		$stokmasukroll=0;
		        		$stokmasukyard=0;
		        		$stokkeluarroll=0;
		        		$stokkeluaryard=0;
		        		$stokakhirroll=0;
		        		$stokakhiryard=0;
		        		$total=0;
		        	?>
		        	<?php foreach($prods_rincian as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo strtoupper($p['nama'])?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo ($p['stokawal'])?></td>
		        			<!-- <td><?php echo ($p['stokawalharga'])?></td> -->
		        			<td><?php echo ($p['stokmasuk'])?></td>
		        			<!-- <td><?php echo ($p['stokmasukharga'])?></td> -->
		        			<td><?php echo ($p['stokkeluarroll'])?></td>
		        			<!-- <td><?php echo ($p['stokkeluarharga'])?></td> -->
		        			<td><?php echo ($p['stokakhirroll'])?></td>
		        			<!-- <td><?php echo ($p['stokakhirharga'])?></td> -->
		        			<td><?php echo $p['satuan']?></td>
		        			<td><?php echo ($p['stokakhirharga'])?></td>
		        			<td><?php echo (($p['stokakhirroll']*$p['stokakhirharga']))?></td>
		        			<td><?php echo $p['ket']?></td>
		        			<td><?php echo $p['masukterakhir']?></td>
		        		</tr>
		        		<?php
			        		$total+=(($p['stokakhirroll']*$p['stokakhirharga']));
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="10" align="center"><b>Jumlah</b></td>
		        		<!-- <td><?php echo ($stokawalroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokmasukroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokkeluarroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokakhirroll)?></td>
		        		<td></td> -->
		        		<td><?php echo ($total)?></td>
		        		<td></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
<table>
</div>