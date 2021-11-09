<form method="post" action="<?php echo $action; ?>">
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Pembayaran</th>
					<th>Metode</th>
					<th>Atas Nama</th>
					<th>No.Rekening</th>
					<th>Tgl Nota/Barang</th>
					<th>Jumlah (Rp)</th>
					<th>Keterangan</th>
					<th><a onclick="addkol()" class="btn btn-sm btn-success text-white"><i class="fa fa-plus"></i></a></th>
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
		html+='<td><input type="text" name="products['+i+'][tanggal]" class="form-control datepicker" required></td>';
		html+='<td><input type="text" name="products['+i+'][pembayaran]" class="form-control" required></td>';
		html+='<td><input type="text" name="products['+i+'][metode]" class="form-control" value="Transfer"></td>';
		html+='<td><input type="text" name="products['+i+'][a_nama]" class="form-control" required></td>';
		html+='<td><input type="text" name="products['+i+'][no_rek]" class="form-control" required></td>';
		html+='<td><input type="text" name="products['+i+'][tgl_note]" class="form-control datepicker" required></td>';
		html+='<td><input type="number" name="products['+i+'][nominal]" class="form-control"></td>';
		html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control" required></td>';
		html+='<td><i class="fa fa-trash remove"></i></td>';
		html+='</tr>';
		i++;
		$("tbody").after(html);
		$( ".datepicker" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          maxDate:+1,
          yearRange: '2019:2030',
        });
	} 
</script>