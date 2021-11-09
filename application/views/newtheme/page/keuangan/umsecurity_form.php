<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Periode</label>
				<input type="text" name="periode" class="form-control" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Tempat</label>
				<select name="tempat" class="form-control select2bs4" data-live-search="true" required>
					<option value="1">Rumah</option>
					<option value="2">Finishing</option>
					<option value="3">Cipadu</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Total Uang Makan</th>
						<th>Keterangan</th>
						<th style="text-align: right;"><a onclick="tambahs()" class="btn btn-sm btn-info text-white"><i class="fa fa-plus"></i></a></th>
					</tr>
				</thead>
				<tbody id="lisc">
					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
			<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Kembali</a>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i=0;
	function tambahs(){
		var html='<tr>';
		html+='<td><select name="products['+i+'][nama]" class="form-control select2bs4" required><option value="">Pilih</option><?php foreach($sec as $s){?><option value="<?php echo $s['id']?>"><?php echo $s['nama']?></option> <?php } ?></select></td>';
		html+='<td><input type="number" name="products['+i+'][nominal]" class="form-control"></td>';
		html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control"></td>';
		 html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
		html+='</tr>';
		$("#lisc").append(html);
		$('.select2bs4').selectpicker('refresh');
		i++;
	}
</script>