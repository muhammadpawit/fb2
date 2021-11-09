<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="idsewa" value="<?php echo $p['id']?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker">
			</div>
			<div class="form-group">
				<label>CMT</label>
				<select name="cmt" class="form-control select2bs4" data-live-search="true">
					<option value="<?php echo $cmt['id_cmt']?>" selected><?php echo $cmt['cmt_name']?></option>
				</select>
			</div>
			<div class="form-group">
				<label>Total Potongan</label>
				<input type="number" name="totalpotongan" class="form-control" value="0">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-sm btn-info">Simpan</button>				
			</div>
		</div>
		<div class="col-md-6">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Pinjaman</th>
						<th>Potongan CMT</th>
						<th>Potongan FORBOYS</th>
						<th>Sisa</th>
						<th>Keterangan</th>
					</tr>
					<tr>
						<th></th>
						<th><?php echo number_format($p['totalpinjaman'])?></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $n=1;?>
					<?php foreach($details as $d){?>
						<tr>
							<td><?php echo $n++?></td>
							<td></td>
							<td><?php echo number_format($d['keluar']/2)?></td>
							<td><?php echo number_format($d['keluar']/2)?></td>
							<td><?php echo number_format($d['sisa'])?></td>
							<td><?php echo date('d/m/Y',strtotime($d['tanggal']))?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</form>