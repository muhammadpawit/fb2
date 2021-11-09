<form method="post" action="<?php echo $action; ?>">
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal</label>
			<input type="text" class="form-control datepicker" name="tanggal" required="required">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>periode</label>
			<input type="text" class="form-control" name="periode" required="required">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Keterangan</label>
			<input type="text" class="form-control" name="keterangan" required="required">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead class="text-center">
				<tr>
				    <th class="tg-0pky" colspan="4">PO Pasangan</th>
				    <th class="tg-0pky" rowspan="2">Jumlah</th>
				    <th class="tg-0pky" rowspan="2">Model</th>
				    <th class="tg-0pky" rowspan="2">Ket</th>
				    <th class="tg-0pky" rowspan="2"><a onclick="addkol()" class="btn btn-sm btn-success text-white"><i class="fa fa-plus"></i></a></th>
				</tr>
			  	<tr>
			    	<td class="tg-0pky">Nama PO</td>
			    	<td class="tg-0pky">Jml Dz</td>
			    	<td class="tg-0pky">Nama PO</td>
			    	<td class="tg-0pky">Jml Dz</td>
			  	</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		<a href="<?php echo $batal?>" class="btn btn-danger">Cancel</a>
		<button type="submit" class="btn btn-info">Simpan</button>
	</div>
</div>
</form>
<script type="text/javascript">
	var i=0;
	function addkol(){
		var html='';
		html+='<tr>';
		html+='<td><input type="text" name="products['+i+'][po1]" class="form-control" value="-"></td>';
		//html+='<td><select name="products['+i+'][po1]" class="form-control prods" data-live-search="true"><option value="-">Pilih</option><?php foreach($po as $p){?><option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option><?php } ?></select></td>';
		html+='<td><input type="number" name="products['+i+'][jml_dz1]" class="form-control" value="0"></td>';
		html+='<td><input type="text" name="products['+i+'][po2]" class="form-control" value="-"></td>';
		//html+='<td><select name="products['+i+'][po2]" class="form-control prods" data-live-search="true"><option value="-">Pilih</option><?php foreach($po as $p){?><option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option><?php } ?></select></td>';
		html+='<td><input type="number" name="products['+i+'][jml_dz2]" class="form-control" value="0"></td>';
		html+='<td><input type="number" name="products['+i+'][jumlah]" class="form-control" value="2"></td>';
		html+='<td><input type="text" name="products['+i+'][model]" class="form-control"></td>';
		html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control"></td>';
		html+='<td><i class="fa fa-trash remove"></i></td>';
		html+='</tr>';
		i++;
		$("tbody").after(html);
		$(".prods").selectpicker();
	} 
</script>