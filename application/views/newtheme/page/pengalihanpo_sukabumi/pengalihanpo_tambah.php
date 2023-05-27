<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" value="<?php echo date('Y-m-d')?>" class="form-control datepicker">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama CMT</label>
			<select  style="width:100%" type="text" id="idcmt" class="form-control select2bs4 kodepo" name="id_cmt" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="*">Pilih</option><?php foreach ($cmt as $key => $po) { ?><option value="<?php echo $po['id_cmt'] ?>" data-item="<?php echo $po['id_cmt'] ?>"><?php echo strtoupper($po['cmt_name']) ?> </option><?php } ?></select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<table class="table table-bordered" id="po">
					<tr>
						<!-- <td>Tanggal</td> -->
						<td>Kode PO</td>
						<td>Jumlah Pcs</td>
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
	$(document).on('click', '.remove', function(){
		$(this).closest('tr').remove();
	});
	var i=0;
	function tambahs(){
		var cmt = $("#idcmt").val();
		if(cmt=='*'){
			alert("CMT harus dipilih");
			return false;
		}
		var html='<tr>';
			//html+='<td><input type="text" name="prods['+i+'][tanggal]" value="<?php echo date('Y-m-d')?>" class="datepicker"></td>';
			html += '<td><select style="width:100%" type="text" class="form-control selectpicker kodepo" name="prods['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($kirim as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>-<?php echo $po['idsj'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo strtoupper($po['kode_po']) ?> </option><?php } ?></select></td>';
			//html += '<td><select  style="width:100%" type="text" class="form-control selectpicker kodepo" name="prods['+i+'][cmt_tujuan]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($cmt as $key => $po) { ?><option value="<?php echo $po['id_cmt'] ?>" data-item="<?php echo $po['id_cmt'] ?>"><?php echo strtoupper($po['cmt_name']) ?> </option><?php } ?></select></td>';
			html+='<td><input type="text" name="prods['+i+'][pcs]" class="form-control pcs" readonly></td>';
			html+='<td><input type="text" name="prods['+i+'][keterangan]" class="form-control ket"></td>';
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

			$(document).on('change', '.kodepo', function(e){
				var dataItem = $(this).find(':selected').data('item');
				var dai = $(this).closest('tr');
				var jumlahItem = $('#piecesPo').val();
				$.get( "<?php echo BASEURL.'PengalihanPoSukabumi/carip' ?>", { id: dataItem } )
				.done(function( data ) {
					var obj = JSON.parse(data);
					console.log(obj);
					dai.find(".ket").val(obj.keterangan);
					dai.find(".pcs").val(obj.jumlah_pcs);
				});
			});
	}
</script>