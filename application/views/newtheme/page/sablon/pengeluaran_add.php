<form method="post" action="<?php echo $action?>" id="form-id">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tanggal Awal</label>
						<input type="text" name="tanggal" id="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d',strtotime('-14 days'))?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Tanggal Akhir</label>
						<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo date('Y-m-d',strtotime('-7 days'))?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>CMT</label>
				<select name="idcmt" class="form-control select2bs4" data-live-search="true">
					<option value="*">Pilih CMT</option>
					<?php foreach($cmt as $c){?>
						<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Pembelanjaan Cat dan Afdruk</label>
				<input type="number" name="belanjacat" class="form-control">
			</div>
			<div class="form-group">
				<label>Pilih Gaji harian</label>
				<select name="gajiharian" id="gajiharian" class="form-control select2bs4" data-live-search="true">
					<option value="*">Pilih</option>
					<?php foreach($gajisablonharian as $c){?>
						<option value="<?php echo $c['periode']?>" data-id="<?php echo $c['periode']?>"><?php echo $c['periode']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Upah Tukang Harian</label>
				<input type="number" name="upahtukang_harian" id="upahtukang_harian" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Upah Tukang Borongan</label>
				<input type="number" name="upahtukang_borongan" id="upahtukang_borongan" class="form-control">
			</div>
			<div class="form-group">
				<label>Biaya lain-lain</label>
				<input type="number" name="biayalain" class="form-control">
			</div>
			<div class="form-group">
				<label>Tokenlistrik</label>
				<input type="number" name="tokenlistrik" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info btn-sm">Simpan</button>
			</div>
		</div>
	</div>
</form>

<script>
	$('#gajiharian').on('change', function() {
        gajiharian();
    });

	function gajiharian() {
    // Ambil nilai yang dipilih
    var selectedValue = $('#gajiharian').val();
    var tanggal1 = $('#tanggal').val();
	var tanggal2 = $('#tanggal2').val();
	
    // Jika ingin melakukan AJAX request berdasarkan pilihan
    
    $.ajax({
        url: '<?php echo BASEURL?>Sablon/sumgajiharian', // Ganti dengan URL yang sesuai
        type: 'POST',
		dataType: 'json',
        data: { periode: selectedValue },
        success: function(response) {
            console.log('Response:', response); // Debugging line
			if (Array.isArray(response)) {
				// Bersihkan tabel sebelum mengisi data baru
				$('#data-table tbody').empty();
				var grandtotal=0;
				// Looping untuk menambahkan data ke tabel
				$.each(response, function(index, item) {
					grandtotal+=Number(item.total);
					$('#form-id').append(
						'<input type="hidden" name="idgajiharian['+index+'][id]" value="' + item.id + '">'
					);
				});
				$("#upahtukang_harian").val(grandtotal);
			} else {
				console.error('Response tidak berupa array:', response);
			}
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

	$.ajax({
        url: '<?php echo BASEURL?>Sablon/sumgajiborongan', // Ganti dengan URL yang sesuai
        type: 'POST',
		dataType: 'json',
        data: { tanggal1: tanggal1, tanggal2:tanggal2 },
        success: function(response) {
            console.log('Response:', response); // Debugging line
			$("#upahtukang_borongan").attr("readonly",true);
			$("#upahtukang_borongan").val(response.total);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
	
    
}
</script>