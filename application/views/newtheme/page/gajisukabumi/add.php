<form method="post" action="<?php echo $action ?>">
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label>Tanggal / Periode </label>
				<input type="text" name="tanggal" value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" required="required" readonly>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" name="keterangan" class="form-control" required="required">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Rincian Gaji Karyawan</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Bagian</th>
							<th>Jml Hari Kerja</th>
							<th>Upah / Hari</th>
							<th>Keterangan</th>
							<th>
								<a onclick="additem()" class="btn btn-success text-white"><i class="fa fa-plus"></i></a>
							</th>
						</tr>
					</thead>
					<tbody id="bod">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Anggaran Operasional</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Keperluan</th>
							<th>JML Barang</th>
							<th>Harga</th>
							<th>Keterangan</th>
							<th>
								<a onclick="additemAnggaran()" class="btn btn-success text-white"><i class="fa fa-plus"></i></a>
							</th>
						</tr>
					</thead>
					<tbody id="bodanggaran">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group"><button class="btn btn-success btn-full full">Simpan</button></div>
		</div>
		<div class="col-md-6">
			<div class="form-group"><a href="<?php echo $batal?>" class="btn btn-danger full">Batal</a></div>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i=0;
	function additem(){
		html ='<tr>';
		//html +='<td><input type="text" name="prods['+i+'][nama]"></td>';
		html += '<td><select type="text" class="form-control selectpicker" name="prods['+i+'][nama]" data-live-search="true" data-title="Pilih item" required><option value="">Mohon dipilih</option><?php foreach ($karyawan as $key => $item) { ?><option value="<?php echo $item['nama'] ?>" data-item="<?php echo $item['nama'] ?>"><?php echo strtoupper($item['nama']) ?></option><?php } ?></select></td>';
		html +='<td><input type="text" class="bagian" name="prods['+i+'][bagian]"></td>';
		html +='<td><input type="text" name="prods['+i+'][jml_hari_kerja]"></td>';
		html +='<td><input type="text" class="upah" name="prods['+i+'][upah]"></td>';
		html +='<td><select name="prods['+i+'][keterangan]" class="form-control" required><option value="">Mohon dipilih</option><option value="1">UPAH HARIAN</option><option value="2">KASBON</option></select></td>';
		html +='<td><i class="fa fa-trash remove"></i></td>';
		html +='</tr>';

		$("#bod").append(html);
		$(".selectpicker").select2();
		i++;
		$(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'Gajisukabumi/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj.bagian);
            dai.find(".bagian").val(obj.bagian);
            dai.find(".upah").val(obj.nominal);
        });
    });
	}


    var i=0;
	function additemAnggaran(){
		html ='<tr>';
		html +='<td><input type="text" name="anggaran['+i+'][keperluan]"></td>';
		html +='<td><input type="text" name="anggaran['+i+'][jml]"></td>';
		html +='<td><input type="text" name="anggaran['+i+'][harga]"></td>';
		html +='<td><input type="text" name="anggaran['+i+'][keterangan]"></td>';		
		html +='<td><i class="fa fa-trash remove"></i></td>';
		html +='</tr>';

		$("#bodanggaran").append(html);
		i++;
	}

	$(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>