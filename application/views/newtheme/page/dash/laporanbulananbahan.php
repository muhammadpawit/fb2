<style>
table, th, td {
  border: 1px solid black !important;
  border-collapse: collapse !important;
}
th, td {
  padding: 15px !important;
}
h5 { font-weight:bold !important; font-size:20px; text-decoration:underline ; margin-top:3%;}
</style>
<div class="row">
	<?php if(isset($bulanan)){?>
		<div class="col-md-4">
			<div class="form-group">
				<label>Bulan</label>
				<select name="bulan" class="form-control select2bs4" id="bulan">
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b ?>" <?php echo $b==$bulan?'selected':''; ?>><?php echo $val ?></option>
				<?php } ?>      
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Tahun</label>
				<select name="tahun" class="form-control select2bs4" id="tahun">
					<?php for($i=2019;$i<=date('Y',strtotime("+1 year"));$i++){?>
						<option value="<?php echo $i ?>" <?php echo $i==$tahun?'selected':''; ?>><?php echo $i ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Aksi</label><br>
				<button class="btn btn-info btn-sm" onclick="filterbulan()">Filter</button>
			</div>
		</div>
	<?php }else{ ?>
		<div class="col-md-4">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
			</div>
		</div>
		<?php if(isset($mingguan)){ ?>
		<div class="col-md-4">
			<div class="form-group">
				<label>Tanggal Akhir</label>
				<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
			</div>
		</div>
		<?php } ?>
		<div class="col-md-4">
			<div class="form-group">
				<label>Aksi</label><br>
				<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			</div>
		</div>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<div class="form-group text-center">
				<h5>Update Stock Bahan</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		<h5><b>Bahan Kaos Baru (Fresh)</b></h5>
			<table>
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">Warna</td>
		            <td colspan="1">Stok Bahan</td>
		            
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            
		            <td>Roll</td>
		            
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
		        	<?php foreach($kaos as $p){?>
						<?php if($p['total'] > 0){ ?>
						<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		
		        	</tr>
		        </tfoot>
			</table>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
		<h5><b>Bahan Celana</b></h5>
			<table>
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">Warna</td>
		            <td colspan="1">Stok Bahan</td>
		            
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            
		            <td>Roll</td>
		            
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
		        	<?php foreach($celana as $p){?>
						<?php if($p['total'] > 0){ ?>
						<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		
		        	</tr>
		        </tfoot>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<p>Update Terakhir : <?php echo hari(date('l',strtotime($update))) ?> , <?php echo date('d F Y',strtotime($update))?> <?php echo date('H:i:s') ?> </b>
			<br>
			<p>
				&bull; <?php echo isset($trans)?$trans['keterangan']:'';?>
			</b>
			<div class="form-group text-center">
				<h5><?php echo $title ?></h5>
			</div>
			<h5><b>Bahan Kaos</b></h5>
			<table>
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">No</td>
		            <td rowspan="2">Nama</td>
		            <td rowspan="2">Warna</td>
		            <td rowspan="2">Kode</td>
		            <td colspan="3">Bahan Masuk</td>
		            <td colspan="3">Bahan Keluar</td>
		            <td colspan="3">Stok Bahan</td>
		            <td rowspan="2">Total (Rp)</td>
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
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
		        	<?php foreach($kaos as $p){?>
						<?php if($p['total'] > 0){ ?>
						<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokmasukroll'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukharga'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirroll'],2)?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirharga'],2)?></td>
		        			<td><?php echo number_format($p['total'],2)?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>

			<h5><b>Bahan Kaos Sisa</b></h5>
			<table>
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">No</td>
		            <td rowspan="2">Nama</td>
		            <td rowspan="2">Warna</td>
		            <td rowspan="2">Kode</td>
		            <td colspan="3">Bahan Masuk</td>
		            <td colspan="3">Bahan Keluar</td>
		            <td colspan="3">Stok Bahan</td>
		            <td rowspan="2">Total (Rp)</td>
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
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
		        	<?php foreach($kaos_sisa as $p){?>
						<?php if($p['total'] > 0){ ?>
						<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokmasukroll'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukharga'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirroll'],2)?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirharga'],2)?></td>
		        			<td><?php echo number_format($p['total'],2)?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>

			<h5>Bahan Celana</h5>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">No</td>
		            <td rowspan="2">Nama</td>
		            <td rowspan="2">Warna</td>
		            <td rowspan="2">Kode</td>
		            <td colspan="3">Bahan Masuk</td>
		            <td colspan="3">Bahan Keluar</td>
		            <td colspan="3">Stok Bahan</td>
		            <td rowspan="2">Total (Rp)</td>
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
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
		        	<?php foreach($celana as $p){?>
						<?php if($p['total'] > 0){ ?>
						<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokmasukroll'])?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukharga'])?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'])?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'])?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirharga'])?></td>
		        			<td><?php echo number_format($p['total'])?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
			<h5>Bahan Kemeja</h5>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <td rowspan="2">No</td>
		            <td rowspan="2">Nama</td>
		            <td rowspan="2">Warna</td>
		            <td rowspan="2">Kode</td>
		            <td colspan="3">Bahan Masuk</td>
		            <td colspan="3">Bahan Keluar</td>
		            <td colspan="3">Stok Bahan</td>
		            <td rowspan="2">Total (Rp)</td>
		            <td rowspan="2">Ket</td>
		          </tr>
		          <tr>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
		            <td>Roll</td>
		            <td>Yard</td>
		            <td>Harga (Rp)</td>
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
		        	<?php foreach($kemeja as $p){?>
						<?php if($p['total'] > 0){ ?>
		        		<?php
							$color='';
							$ket='';
							if($p['stokakhirroll'] <= 1 && $p['stokakhiryard'] <=1){
								$color='#b83400';
								$ket='habis';
							}
						?>
		        		<tr style="color:<?php echo $color ?>">
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokmasukroll'])?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukharga'])?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'])?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'])?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirharga'])?></td>
		        			<td><?php echo number_format($p['total'])?></td>
		        			<td><?php echo $p['ket']?> <?php echo $ket ?></td>
		        		</tr>
						<?php } ?>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<form action="<?php echo BASEURL?>Dash/croscek_save/ADMIN_BAHAN" method="post">
		<div class="col-md-12">
			<label>Croscek Admin</label><br>
			<?php $array=[10,11];?>
			<?php if(in_array(callSessUser('id_user'), $array)){ ?>
				<?php if(empty($crosscek)){ ?>
					<h4 class="text-danger">Data ini belum di crosscek oleh admin yang bersangkutan</h4>
				<?php }else{ ?>
				<ul>
					<li>Data Ini telah dicroscek oleh <?php echo $crosscek['oleh']?> pada <?php echo date('d F Y',strtotime($crosscek['tanggal'])) ?> <?php echo date('H:i:s') ?> dengan keterangan <?php echo $crosscek['keterangan'] ?></li>
				</ul>
				<?php } ?>
			<?php }else{ ?>
				<textarea class="form-control" name="keterangan" required></textarea>
				<br>
				<button class="btn btn-success btn-sm full">Submit</button>
			<?php } ?>
		</div>
	</form>
</div>
<script type="text/javascript">
	function filters(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var supplier = $('select[name=\'supplier\']').val();

    if (supplier != '*') {
      url += '&supplier=' + encodeURIComponent(supplier);
    }

    var kategori = $('select[name=\'kategori\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }

    location =url;
  }

  function excels(){
    url='?&excel=1';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'cmt\']').val();

    var supplier = $('select[name=\'supplier\']').val();

    if (supplier != '*') {
      url += '&supplier=' + encodeURIComponent(supplier);
    }

     var kategori = $('select[name=\'kategori\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }


    location =url;
  }

</script>