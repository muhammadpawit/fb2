<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<table class="table table-bordered" id="po">
					<tr>
						<td>Tanggal</td>
						<td>Kode PO</td>
						<td>Cmt Tujuan</td>
						<td>Keterangan</td>
						<td><a class="btn btn-sm btn-info" onclick="tambahs()"><i class="fa fa-plus"></i></a></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<button class="btn btn-info btn-sm">Simpan</button>
				<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i=0;
	function tambahs(){
		var html='<tr>';
			html+='<td><input type="text" name="prods['+i+'][tanggal]" value="<?php echo date('Y-m-d')?>" class="datepicker"></td>';
			html += '<td><select type="text" class="form-control selectpicker kodepo" name="prods['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kirim as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>-<?php echo $po['idsj'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['kode_po'] ?> <?php echo $po['tglsj'] ?> <?php echo $po['nosj'] ?></option><?php } ?></select></td>';
			html += '<td><select type="text" class="form-control selectpicker kodepo" name="prods['+i+'][cmt_tujuan]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($cmt as $key => $po) { ?><option value="<?php echo $po['id_cmt'] ?>-<?php echo $po['idsj'] ?>" data-item="<?php echo $po['id_cmt'] ?>"><?php echo $po['cmt_name'] ?> - <?php echo $po['tglsj'] ?> -<?php echo $po['nosj'] ?></option><?php } ?></select></td>';
			html+='<td><input type="text" name="prods['+i+'][keterangan]" class="form-control"></td>';
			html+='<td><i class="fa fa-trash remove"></i></td>';
			html+='</tr>';
			$("#po").append(html);
			//$('.selectpicker').selectpicker('refresh');
			$('.selectpicker').select2();
			$( ".datepicker" ).datepicker({ 
	          dateFormat: 'yy-mm-dd',
	          maxDate:+1,
	          yearRange: '2019:2030',
	        });
			i++;
	}
</script>