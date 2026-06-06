<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<div class="col-6">
						<form method="post" action="<?php echo $update?>" enctype="multipart/form-data">
							<div class="form-group">
								<label>Nama</label>
								<input type="hidden" name="id" class="form-control" value="<?php echo $k['id_master_karyawan_bordir']?>">
								<input type="text" name="nama" class="form-control" value="<?php echo $k['nama_karyawan_bordir']?>">
							</div>
							<div class="form-group">
								<label>Tanggal Masuk</label>
								<input type="text" name="tgl_masuk" class="form-control datepicker" value="<?php echo $k['tgl_masuk']?>" autocomplete="off" required="required">
							</div>
							<div class="form-group">
								<label>No.Telp</label>
								<input type="text" name="no_telp" class="form-control" value="<?php echo $k['no_telp']?>" required="required">
							</div>
							<div class="form-group">
								<label>Gaji Harian</label>
								<input type="number" onkeyup="update()"  name="karyawan_gaji_weekday" class="form-control" required="required" value="<?php echo $k['karyawan_gaji_weekday']?>">
							</div>
							<div class="form-group">
								<label>Gaji Mingguan</label>
								<input type="number" name="karyawan_gaji_weekend" class="form-control" required="required" value="<?php echo $k['karyawan_gaji_weekend']?>">
							</div>
							<div class="form-group">
								<label>Nomor KTP</label>
								<input type="text" name="no_ktp" value="<?php echo $k['no_ktp']?>" class="form-control" required="required">
							</div>
							<div class="form-group" id="preview_container" <?php if(empty($k['file_ktp'])){ echo 'style="display: none;"'; } ?>>
								<img id="preview_ktp" src="<?php if(!empty($k['file_ktp'])){ echo BASEURL.'/'.$k['file_ktp']; } ?>" class="img img-thumbnail" style="width:500px;">
							</div>
							<div class="form-group">
								<label><?php if(!empty($k['file_ktp'])){?> Ubah <?php } ?>File KTP</label>
								<input type="file" name="ktp" accept=".jpg,.png,.jpeg" class="form-control" <?php if(empty($k['file_ktp'])){ echo 'required="required"'; } ?> onchange="processKTP(this)">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-sm">Update</button>
								<a class="btn btn-sm btn-danger text-white" href="<?php echo $cancel?>">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Tesseract.js untuk OCR -->
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script type="text/javascript">
	function update() {
		let harian= $('input[name=\'karyawan_gaji_weekday\']').val();
		 $('input[name=\'karyawan_gaji_weekend\']').val(Number(harian*7));
	}

	async function processKTP(input) {
		if (input.files && input.files[0]) {
			// Tampilkan preview gambar
			const file = input.files[0];
			document.getElementById('preview_ktp').src = window.URL.createObjectURL(file);
			document.getElementById('preview_container').style.display = 'block';

			// Ambil elemen input NIK
			const nikInput = document.querySelector('input[name="no_ktp"]');
			const originalNik = nikInput.value;
			
			// Set status sedang memproses
			nikInput.value = 'Membaca NIK...';
			nikInput.setAttribute('readonly', 'readonly');

			try {
				// Proses OCR menggunakan Tesseract
				const worker = await Tesseract.createWorker('eng');
				const ret = await worker.recognize(file);
				
				// Cari pola 16 digit angka (format NIK KTP Indonesia)
				// Menghapus spasi dan karakter non-digit di sekitarnya jika ada yg terbaca salah
				const text = ret.data.text.replace(/\s+/g, ''); 
				const match = text.match(/\d{16}/);
				
				if (match) {
					nikInput.value = match[0]; // Setel NIK yang berhasil ditemukan
				} else {
					alert('NIK tidak terbaca jelas dari gambar KTP. Silakan input manual.');
					nikInput.value = (originalNik !== 'Membaca NIK...') ? originalNik : '';
				}
				await worker.terminate();
			} catch (err) {
				console.error(err);
				alert('Terjadi kesalahan saat membaca gambar KTP.');
				nikInput.value = (originalNik !== 'Membaca NIK...') ? originalNik : '';
			} finally {
				nikInput.removeAttribute('readonly'); // Buka kembali inputan agar bisa diedit
			}
		}
	}
</script>