<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Bulan Tahun</label>
				<!-- <input type="text" name="tanggal" class="form-control" value="<?php echo $tanggal2?>" readonly> -->
				 <select name="bulan" class="form-control select2bs4" id="bulan">
					<option value="">Pilih</option>
					<?php foreach(bulan() as $val=>$key) {  ?>
						<option value="<?php echo $val ?>"><?php echo $key ?></option>
					<?php } ?>
				 </select>
			</div>
			<div class="form-group">
				<label>Nama Karyawan</label>
				<select name="idkaryawan" id="idkaryawan" class="form-control select2bs4" required data-live-search="true">
					<option value="">Pilih</option>
					<?php foreach($karyawans as $k){?>
						<option value="<?php echo $k['id']?>"><?php echo strtolower($k['nama'])?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Rincian Kasbon</label>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal Kasbon</th>
							<th>Nominal Kasbon</th>
						</tr>
					</thead>
					<tbody id="kasbon">
						
					</tbody>
				</table>
			</div>
			<div class="form-group">
				<label>Rincian Pinjaman</label>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal Pinjaman</th>
							<th>Nominal Pinjaman</th>
							<th>Sisa Pinjaman</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody id="potpinjaman">
						
					</tbody>
				</table>
			</div>
			<div class="form-group">
				<label>Bonus</label>
				<input type="number" id="bonus" name="bonus" class="form-control" value="0" readonly="readonly">
			</div>
			<div class="form-group">
				<label>THR</label>
				<input type="number" id="thr" name="thr" class="form-control" value="0" readonly="readonly">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Gaji Pokok</label>
				<input type="number" name="gajipokok" id="gajipokok" class="form-control" value="0" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Gantungan Gaji</label>
				<input type="number" onblur="updatetotal()" id="gantungan_gaji" name="gantungan_gaji" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Potongan Kasbon</label>
				<input type="number" onblur="updatetotal()" id="potongan_kasbon" name="potongan_kasbon" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Potongan Pinjaman</label>
				<input type="number" id="potongan_pinjaman" onblur="updatetotal()" name="potongan_pinjaman" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Potongan Claim</label>
				<input type="number" id="potongan_claim" onblur="updatetotal()" name="potongan_claim" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Potongan Absensi</label>
				<input type="number" id="potongan_absensi" onblur="updatetotal()" name="potongan_absensi" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Potongan Keterlambatan</label>
				<input type="number" id="potongan_terlambat" onblur="updatetotal()" name="potongan_terlambat" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Subtotal (Gaji Kotor)</label>
				<input type="number" name="subtotal" id="subtotal" class="form-control" value="0" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Total (Gaji Bersih)</label>
				<input type="number" name="total" id="total" class="form-control" value="0" readonly="readonly">
			</div>
			<div class="form-group">
				<label>Metode Pembayaran</label><br>
				<input type="radio" name="metode" value="1" required checked> Cash&nbsp;
				<input type="radio" name="metode" value="2" required> Transfer
			</div>
			<div class="form-group">
				<button class="btn btn-info btn-sm text-white">Simpan</button>
				<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	function reset(){
		var e = document.getElementById("Bulan");
		console.log(e);
	}
	$("#yk").change(function() {
	    var yksbn =$("#yksbn").val();
	    if(this.checked) {
	        $("#potongan_kasbon").val(yksbn);
	    }
	    updatetotal();
	});
	$( "#idkaryawan" ).change(function() {
		var total=$("#total").val(0);
		var bonus=$("#bonus").val(0);
		var thr=$("#thr").val(0);
		var gajipokok=$("#gajipokok").val(0);
		var potongan_kasbon=$("#potongan_kasbon").val(0);
		var potongan_pinjaman=$("#potongan_pinjaman").val(0);
		var potongan_claim=$("#potongan_claim").val(0);
		var bulan = $("#bulan").val();
  	  $('#kasbon').empty();
  	  $('#potpinjaman').empty();
	  val = $(this).val();
	  // kasbon
	  $.get("<?php echo BASEURL.'Gaji/getkasbon' ?>?&idkaryawan="+val+"&bulan="+bulan, 
	    function(data){   
	    //console.log(data);
	    $('#kasbon').append(data);
	  });

	  $.get("<?php echo BASEURL.'Gaji/getsumkasbon' ?>?&idkaryawan="+val, 
	    function(data){   
	    //console.log(data);
	    //$('#ksbn').html(data);
	    //$('#yksbn').val(data);
		$("#potongan_kasbon").val(data);
		$("#potongan_kasbon").attr('readonly',true);
		updatetotal();
	  });

	  // potongan pinjaman jika ada
	  $.get("<?php echo BASEURL.'Gaji/getpinjaman' ?>?&idkaryawan="+val, 
	    function(data){   
	    //console.log(data);
	    $('#potpinjaman').append(data);
	  });

	  $('#gajipokok').empty();
	  $.get("<?php echo BASEURL.'Gaji/getkaryawan' ?>?&idkaryawan="+val, 
	    function(data){   
	    //console.log(data);
	    $('#gajipokok').val(data);
		updatetotal();
	  });

	  updatetotal();
	});

	function updatetotal(){
		var sub=0;
		var grand=0;
		var total=$("#total").val();
		var bonus=$("#bonus").val();
		var thr=$("#thr").val();
		var gajipokok=$("#gajipokok").val();
		var potongan_kasbon=$("#potongan_kasbon").val();
		var potongan_pinjaman=$("#potongan_pinjaman").val();
		var potongan_claim=$("#potongan_claim").val();
		var potongan_abensi=$("#potongan_absensi").val();
		var potongan_terlambat=$("#potongan_terlambat").val();
		var gantungan_gaji=$("#gantungan_gaji").val();
		grand = Number(gajipokok-potongan_kasbon-potongan_pinjaman-potongan_claim-potongan_abensi-potongan_terlambat-gantungan_gaji);
		sub = Number(gajipokok)+Number(bonus)+Number(thr);
		$("#total").val(grand);
		$("#subtotal").val(sub);
	}
</script>