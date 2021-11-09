<form action="<?php echo $action?>" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Hari</label>
				<!-- <input type="text" name="hari" class="form-control" required="required"> -->
				<select name="hari" class="form-control select2bs4" required="required" data-live-search="true">
					<option value="Minggu">Minggu</option>
					<option value="Senin">Senin</option>
					<option value="Selasa">Selasa</option>
					<option value="Rabu">Rabu</option>
					<option value="Kamis">Kamis</option>
					<option value="Jumat">Jumat</option>
					<option value="Sabtu">Sabtu</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker" required="required">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Tempat</label>
				<select name="tempat" class="form-control select2bs4" required="required" data-live-search="true">
					<option value="">Pilih</option>
					<option value="1">Rumah</option>
					<option value="2">Cipadu</option>
				</select>
			</div
			>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Shift</label>
				<select name="shift" class="form-control select2bs4" required="required" data-live-search="true">
					<option value="">Pilih</option>
					<option value="Pagi">Pagi</option>
					<option value="Malam">Malam</option>
				</select>
			</div
			>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Mandor</label>
				<input type="text" name="mandor" class="form-control" required="required">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered" style="width: 100% !important;">
				<thead>
					<th>Nama Karyawan</th>
					<th>Keterangan</th>
					<th>Stich</th>
					<th>Mesin</th>
					<th>Bonus</th>
					<th>Jam Kerja</th>
					<th>
						<div class="text-right"><a onclick="tambahk()" class="btn btn-sm btn-info text-white"><i class="fa fa-plus"></i></a></div>
					</th>
				</thead>
				<tbody id="listk">
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" align="right"><button class="btn btn-info btn-sm">Simpan</button></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
<form action="<?php echo $action?>" method="post">
<script type="text/javascript">
	var i=0;
	function tambahk(){
		var html='<tr>';
		 html+='<td><select name="products['+i+'][idkaryawan]" class="form-control select2bs4" required data-live-search="true"><option value="">Pilih</option><?php foreach($karyawan as $k){?><option value="<?php echo $k['id_master_karyawan_bordir']?>"><?php echo strtolower($k['nama_karyawan_bordir'])?></option><?php } ?></select></td>';
		html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control" required="required" value="-"></td>';
		html+='<td><input type="number" name="products['+i+'][stich]" class="form-control stich-'+i+'" required="required" value="0"></td>';
		html+='<td><select name="products['+i+'][mesin]" class="form-control select2bs4 mesin" required data-live-search="true"><option value="">Pilih</option><?php for($i=1;$i<=10;$i++){?><option value="<?php echo $i?>" data-item="<?php echo $i ?>"><?php echo $i?></option><?php } ?></select></td>';
		html+='<td><input type="number" name="products['+i+'][bonus]" class="form-control bonus" required="required" value="0" readonly></td>';
		html+='<td><select name="products['+i+'][jamkerja]" class="form-control select2bs4" required data-live-search="true"><option value="">Pilih</option><?php for($i=0;$i<=12;$i++){?><option value="<?php echo $i?>" data-item="<?php echo $i ?>" <?php echo $i==12?'selected':''; ?>><?php echo $i?></option><?php } ?></select></td>'
		html+='<td><i class="fa fa-trash remove"></i></td>';
		html+='</tr>';
		i++;
		$('#listk').append(html);
		 $('.select2bs4').selectpicker('refresh');
		 $(document).on('change', '.mesin', function(e){
		 	var mesin = $(this).find(':selected').data('item');
	       	var stich= $(".stich-"+(i-1)).val();
	       	//console.log(id);
	       	var dai = $(this).closest('tr');
	        $.get( "<?php echo BASEURL?>Bordir/bonus", { stich: stich,mesin:mesin } )
              .done(function( result ) {
               //(result);
	           dai.find(".bonus").val(result); 
            });
		 });

		 
	}


	$(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

</script>