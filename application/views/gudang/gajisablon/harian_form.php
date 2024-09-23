<form action="<?php echo $action ?>" method="POST">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="">Periode</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<input type="text" name="periode" id="periode" class="form-control">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="">Pilih Pegawai</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select name="id_karyawan_harian" class="select2bs4 kar" required>
						<option value="*"></option>
						<?php foreach($kar as $k){ ?>
							<option value="<?php echo $k['id']?>" data-item="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="">Gaji</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<input type="text" name="gaji" id="gaji" class="form-control" required>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="">Hari</label>
				</div>
			</div>
			<div class="col-md-10">
				<div class="form-group">
					<table class="table table-bordered">
						<tr>
							<td>Senin</td>
							<td>Selasa</td>
							<td>Rabu</td>
							<td>Kamis</td>
							<td>Jum'at</td>
							<td>Sabtu</td>
						</tr>
						<tr>
							<td><input type="number" class="form-control" name="senin" value="0" onblur="updatetotal()"></td>
							<td><input type="number" class="form-control" name="selasa" value="0" onblur="updatetotal()"></td>
							<td><input type="number" class="form-control" name="rabu" value="0" onblur="updatetotal()"></td>
							<td><input type="number" class="form-control" name="kamis" value="0" onblur="updatetotal()"></td>
							<td><input type="number" class="form-control" name="jumat" value="0" onblur="updatetotal()"></td>
							<td><input type="number" class="form-control" name="sabtu" value="0" onblur="updatetotal()"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="">Total</label>
				</div>
			</div>
			<div class="col-md-10">
				<div class="form-group">
					<div class="total" id="total"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<!-- <label for="">Total</label> -->
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<button class="btn btn-success btn-sm">Simpan</button>
					<a class="btn btn-danger btn-sm" href="<?php echo $cancel?>">Kembali</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					
				</div>
			</div>
		</div>
</form>
<script>
	$(document).on('change', '.kar', function(e){
            var dataItem = $(this).find(':selected').data('item');
            $.get( "<?php echo BASEURL.'Gajisablon/cari' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
				$(".gaji").html(obj.gaji);
				$("#gaji").val(obj.gaji);
                
            });
        });


		function updatetotal() {
			var total = 0;
			// Mengambil semua input bertipe number
			var inputs = document.querySelectorAll('input[type="number"]');
			var gaji = parseFloat($("#gaji").val()) || 0; // Mengonversi gaji menjadi angka

			// Menjumlahkan semua nilai input
			inputs.forEach(function(input) {
				total += parseFloat(input.value) || 0; // Menggunakan parseFloat dan fallback ke 0
			});

			// Debug: log nilai total dan gaji
			console.log('Total Input:', total);
			console.log('Gaji:', gaji);

			// Menghitung total akhir dan menampilkan di elemen dengan ID total
			document.getElementById('total').innerText = total * gaji;
		}

</script>