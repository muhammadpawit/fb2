<form method="post" action="<?php echo $action; ?>">
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Pembayaran</th>
					<th>Atas Nama</th>
					<th>No.Rekening</th>
					<th>Keterangan</th>
					<th>Jumlah (Rp)</th>
					<th>Tanggal Bayar</th>
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
		html+='<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4" data-live-search="true" data-title="pilih" name="products['+i+'][id]" required><option value="">Pilih</option><?php foreach ($k as $key => $item) { ?><option value="<?php echo $item['id'] ?>" data-item="<?php echo $item['id'] ?>"><?php echo $item['pembayaran'] ?> <?php echo $item['keterangan'] ?></option><?php } ?></select></td>';
		html+='<td><input type="text" name="products['+i+'][a_nama]" class="form-control nama" readonly></td>';
		html+='<td><input type="text" name="products['+i+'][no_rek]" class="form-control norek" readonly></td>';
		html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control keterangan" readonly></td>';
		html+='<td><input type="number" name="products['+i+'][nominal]" class="form-control nominal"></td>';
		html+='<td><input type="text" name="products['+i+'][tglbayar]" class="form-control datepicker"></td>';
		html+='<td><i class="fa fa-trash remove"></i></td>';
		html+='</tr>';
		i++;
		$("tbody").after(html);
		$( ".datepicker" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          maxDate:+1,
          yearRange: '2019:2030',
        });
        $(".select2bs4").selectpicker('refresh');
        $(document).on('change', '.select2bs4', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            var jumlahItem = $('#piecesPo').val();
            $.get( "<?php echo BASEURL.'Keuangan/searchbayar' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".nama").val(obj.a_nama);
                dai.find(".norek").val(obj.no_rek);
                dai.find(".keterangan").val(obj.keterangan);
                dai.find(".nominal").val(obj.nominal);
            });
        });
	} 
</script>