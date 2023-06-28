<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Tanggal</label>
			<?php echo date('d F Y',strtotime($prods['tanggal'])) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Nama CMT</label>
			<?php echo $cmt?>
		</div>
	</div>
</div>
<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="id" value="<?php echo $prods['id']?>">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Kode PO</th>
							<th width="50%">Keterangan</th>
							<th style="text-align: right !important;"><a onclick="adds()" class="btn btn-sm btn-info text-white"><i class="fa fa-plus"></i></a></th>
						</tr>
					</thead>
					<?php $row=0;?>
					<tbody id="list">
						<?php foreach($details as $d){?>
							<tr>
								<td>
									<select name="products[<?php echo $row?>][kode_po]" class="form-control select2bs4" style="width:100%" required>
										<?php foreach ($kodepo as $key => $po) { ?>
											<option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>" <?php echo $d['kode_po']==$po['kode_po']?'selected':'';?>><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<!-- <input type="text" name="products[<?php echo $row?>][keterangan]" class="form-control" value="<?php echo $d['keterangan']?>"> -->
									<select class="form-control select2bs4" name="products[<?php echo $row?>][keterangan]">
										<?php foreach ($ket as $k): ?>
											<option value="<?php echo $k['id'] ?>" <?php echo $k['id']==$d['keterangan'] ? 'selected' :'' ?>><?php echo $k['nama'] ?></option>
										<?php endforeach ?>
									</select>
								</td>
								<td align="center"><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
							</tr>
						<?php $row++?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
			<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i='<?php echo $row?>';
	function adds(){
		var html = '';
        html += '<tr>';
        html += '<td><select type="text" class="form-control selectpicker kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" style="width:100%" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
		//html+="<td><input type='text' name='products["+i+"][keterangan]' class='form-control' value='-'></td>";
		html += '<td><select class="form-control selectpicker" name="products['+i+'][keterangan]"><?php foreach ($ket as $k): ?><option value="<?php echo $k['id'] ?>"><?php echo $k['nama'] ?></option><?php endforeach ?></select></td>';
		html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>';
        html+="</tr>";
       	i++;
        $('#list').append(html);
        $('.selectpicker').select2();
	}

	$(document).on('click', '.remove', function(){
	    $(this).closest('tr').remove();
	});
</script>