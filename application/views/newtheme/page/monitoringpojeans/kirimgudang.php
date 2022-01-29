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
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered yessearch">
				<thead align="center">
					<tr>
					    <th valign="top" rowspan="2">NO</th>
					    <th valign="top" rowspan="2">Nama CMT</th>
					    <th valign="top" rowspan="2">Nama PO</th>
					    <th valign="top" rowspan="2">JML Kirim</th>
					    <th valign="top" colspan="2">Setor Packing</th>
					    <th valign="top" colspan="2">Kirim Gudang</th>
					    <th valign="top">Status</th>
					    <th valign="top">Ket</th>
					</tr>
					<tr>
					    <th valign="top">TGL</th>
					    <th valign="top">JML (PC)</th>
					    <th valign="top">TGL</th>
					    <th valign="top">JML (PC)</th>
					    <th valign="top"></th>
					    <th valign="top"></th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $no++;?></td>
							<td><?php echo $p['namacmt']?></td>
							<td><?php echo $p['kode_po']?></td>
							<td><?php echo $p['kirim']?></td>
							<td><?php echo $p['tglpacking']?></td>
							<td><?php echo $p['pcspacking']?></td>
							<td><?php echo $p['tglkg']?></td>
							<td><?php echo $p['jmlkg']?></td>
							<td>
								<?php 
									if($p['kirim']==$p['jmlkg']){
										echo 'OK';
									}
								?>		
							</td>
							<td>
								<?php 
									if($p['kirim']>$p['jmlkg']){
										echo 'Kurang '.($p['kirim']-$p['jmlkg']).' pcs';
									}
								?>
							</td>
						</tr>
					<?php } ?>
				</tbody>				
			</table>
		</div>
	</div>
</div>