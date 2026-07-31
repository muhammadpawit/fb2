<form method="post" action="<?php echo $action?>">
	<div class="row mb-3">
		<div class="col-md-3">
			<label>Bulan</label>
			<select name="bulan" id="filter_bulan" class="form-control select2bs4" onchange="reloadPage()">
				<?php foreach(bulan() as $val=>$key) { ?>
					<option value="<?php echo sprintf('%02d', $val); ?>" <?php echo ($val == $bulan_ini) ? 'selected' : ''; ?>><?php echo $key ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<label>Tahun</label>
			<select name="tahun" id="filter_tahun" class="form-control select2bs4" onchange="reloadPage()">
				<?php for($i = date('Y')-2; $i <= date('Y')+1; $i++){ ?>
					<option value="<?php echo $i ?>" <?php echo ($i == $tahun_ini) ? 'selected' : ''; ?>><?php echo $i ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-6 text-right mt-4">
			<button class="btn btn-info text-white">Simpan Semua</button>
			<a href="<?php echo $batal?>" class="btn btn-danger text-white">Batal</a>
		</div>
	</div>
	
	<script>
		function reloadPage() {
			var b = document.getElementById("filter_bulan").value;
			var t = document.getElementById("filter_tahun").value;
			window.location.href = "<?php echo BASEURL.'Gaji/bulananadd'; ?>?bulan=" + b + "&tahun=" + t;
		}
	</script>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th><input type="checkbox" id="checkAll" checked></th>
							<th>Nama Karyawan</th>
							<th>Gaji Pokok</th>
							<th>Gantungan Gaji</th>
							<th>Potongan Kasbon</th>
							<th>Potongan Pinjaman</th>
							<th>Potongan Claim</th>
							<th>Potongan Absensi</th>
							<th>Pot. Terlambat</th>
							<th>Bonus</th>
							<th>THR</th>
							<th>Subtotal</th>
							<th>Total Bersih</th>
							<th>Metode</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($karyawans as $k){ 
							$idk = $k['id'];
						?>
						<tr id="row_<?php echo $idk; ?>">
							<td>
								<input type="checkbox" class="checkKaryawan" name="karyawan[<?php echo $idk; ?>][checked]" value="1" checked>
								<input type="hidden" name="karyawan[<?php echo $idk; ?>][idpinjaman]" value="<?php echo $k['idpinjaman']; ?>">
							</td>
							<td><?php echo strtolower($k['nama'])?></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][gajipokok]" id="gajipokok_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="<?php echo $k['gajipokok']; ?>" style="width: 100px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][gantungan_gaji]" id="gantungan_gaji_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td>
								<input type="number" name="karyawan[<?php echo $idk; ?>][potongan_kasbon]" id="potongan_kasbon_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="<?php echo $k['potongan_kasbon']; ?>" style="width: 100px;" readonly>
							</td>
							<td>
								<input type="number" name="karyawan[<?php echo $idk; ?>][potongan_pinjaman]" id="potongan_pinjaman_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 100px;">
								<?php if($k['sisa_pinjaman'] > 0){ ?>
									<small class="text-danger">Sisa: Rp. <?php echo number_format($k['sisa_pinjaman']); ?></small>
								<?php } ?>
							</td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][potongan_claim]" id="potongan_claim_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][potongan_absensi]" id="potongan_absensi_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][potongan_terlambat]" id="potongan_terlambat_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][bonus]" id="bonus_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][thr]" id="thr_<?php echo $idk; ?>" class="form-control calc_<?php echo $idk; ?>" value="0" style="width: 80px;"></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][subtotal]" id="subtotal_<?php echo $idk; ?>" class="form-control" value="0" style="width: 100px;" readonly></td>
							<td><input type="number" name="karyawan[<?php echo $idk; ?>][total]" id="total_<?php echo $idk; ?>" class="form-control" value="0" style="width: 100px;" readonly></td>
							<td>
								<select name="karyawan[<?php echo $idk; ?>][metode]" class="form-control">
									<option value="1">Cash</option>
									<option value="2">Transfer</option>
								</select>
							</td>
							<td>
								<button type="button" class="btn btn-sm btn-info btn-detail text-white" data-id="<?php echo $idk; ?>" data-nama="<?php echo $k['nama']; ?>">Detail</button>
							</td>
						</tr>
						<script>
							$(document).ready(function(){
								function calc_<?php echo $idk; ?>(){
									var gp = Number($("#gajipokok_<?php echo $idk; ?>").val());
									var gg = Number($("#gantungan_gaji_<?php echo $idk; ?>").val());
									var pkb = Number($("#potongan_kasbon_<?php echo $idk; ?>").val());
									var ppj = Number($("#potongan_pinjaman_<?php echo $idk; ?>").val());
									var pcl = Number($("#potongan_claim_<?php echo $idk; ?>").val());
									var pab = Number($("#potongan_absensi_<?php echo $idk; ?>").val());
									var ptl = Number($("#potongan_terlambat_<?php echo $idk; ?>").val());
									var bns = Number($("#bonus_<?php echo $idk; ?>").val());
									var thr = Number($("#thr_<?php echo $idk; ?>").val());
									
									var subtotal = gp + bns + thr;
									var total = subtotal - pkb - ppj - pcl - pab - ptl - gg;
									
									$("#subtotal_<?php echo $idk; ?>").val(subtotal);
									$("#total_<?php echo $idk; ?>").val(total);
								}
								// Hitung saat load
								calc_<?php echo $idk; ?>();
								
								// Hitung saat ada perubahan
								$(".calc_<?php echo $idk; ?>").on("input change blur", function(){
									calc_<?php echo $idk; ?>();
									if (typeof updateGrandTotal === "function") { updateGrandTotal(); }
								});
							});
						</script>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr style="font-weight: bold; background-color: #f8f9fa;">
							<td colspan="2" class="text-right">Grand Total:</td>
							<td><span id="gt_gajipokok">0</span></td>
							<td><span id="gt_gantungan">0</span></td>
							<td><span id="gt_kasbon">0</span></td>
							<td><span id="gt_pinjaman">0</span></td>
							<td><span id="gt_claim">0</span></td>
							<td><span id="gt_absensi">0</span></td>
							<td><span id="gt_terlambat">0</span></td>
							<td><span id="gt_bonus">0</span></td>
							<td><span id="gt_thr">0</span></td>
							<td><span id="gt_subtotal">0</span></td>
							<td><span id="gt_total">0</span></td>
							<td colspan="2"></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</form>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Potongan: <span id="detailNamaKaryawan"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Rincian Kasbon (Bulan ini)</h6>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal Kasbon</th>
					<th>Nominal Kasbon</th>
				</tr>
			</thead>
			<tbody id="detailKasbon">
				
			</tbody>
		</table>
		
		<hr>
		
		<h6>Rincian Pinjaman</h6>
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
			<tbody id="detailPinjaman">
				
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Toggle all checkboxes
		$("#checkAll").click(function(){
			$(".checkKaryawan").prop('checked', $(this).prop('checked'));
			updateGrandTotal();
		});
		
		$(".checkKaryawan").click(function(){
			updateGrandTotal();
		});

		window.updateGrandTotal = function() {
			var gt_gajipokok = 0;
			var gt_gantungan = 0;
			var gt_kasbon = 0;
			var gt_pinjaman = 0;
			var gt_claim = 0;
			var gt_absensi = 0;
			var gt_terlambat = 0;
			var gt_bonus = 0;
			var gt_thr = 0;
			var gt_subtotal = 0;
			var gt_total = 0;

			$(".checkKaryawan:checked").each(function(){
				var row = $(this).closest('tr');
				gt_gajipokok += Number(row.find('input[name$="[gajipokok]"]').val()) || 0;
				gt_gantungan += Number(row.find('input[name$="[gantungan_gaji]"]').val()) || 0;
				gt_kasbon += Number(row.find('input[name$="[potongan_kasbon]"]').val()) || 0;
				gt_pinjaman += Number(row.find('input[name$="[potongan_pinjaman]"]').val()) || 0;
				gt_claim += Number(row.find('input[name$="[potongan_claim]"]').val()) || 0;
				gt_absensi += Number(row.find('input[name$="[potongan_absensi]"]').val()) || 0;
				gt_terlambat += Number(row.find('input[name$="[potongan_terlambat]"]').val()) || 0;
				gt_bonus += Number(row.find('input[name$="[bonus]"]').val()) || 0;
				gt_thr += Number(row.find('input[name$="[thr]"]').val()) || 0;
				gt_subtotal += Number(row.find('input[name$="[subtotal]"]').val()) || 0;
				gt_total += Number(row.find('input[name$="[total]"]').val()) || 0;
			});

			$("#gt_gajipokok").text(gt_gajipokok.toLocaleString('id-ID'));
			$("#gt_gantungan").text(gt_gantungan.toLocaleString('id-ID'));
			$("#gt_kasbon").text(gt_kasbon.toLocaleString('id-ID'));
			$("#gt_pinjaman").text(gt_pinjaman.toLocaleString('id-ID'));
			$("#gt_claim").text(gt_claim.toLocaleString('id-ID'));
			$("#gt_absensi").text(gt_absensi.toLocaleString('id-ID'));
			$("#gt_terlambat").text(gt_terlambat.toLocaleString('id-ID'));
			$("#gt_bonus").text(gt_bonus.toLocaleString('id-ID'));
			$("#gt_thr").text(gt_thr.toLocaleString('id-ID'));
			$("#gt_subtotal").text(gt_subtotal.toLocaleString('id-ID'));
			$("#gt_total").text(gt_total.toLocaleString('id-ID'));
		};
		
		setTimeout(function(){
			updateGrandTotal();
		}, 500);

		// Modal Detail Handler
		$(".btn-detail").click(function(){
			var idkaryawan = $(this).data("id");
			var nama = $(this).data("nama");
			var bulan = "<?php echo $bulan_ini; ?>";
			var tahun = "<?php echo $tahun_ini; ?>";
			
			$("#detailNamaKaryawan").text(nama);
			$('#detailKasbon').empty();
			$('#detailPinjaman').empty();
			$('#modalDetail').modal('show');
			
			// Load kasbon
			$.get("<?php echo BASEURL.'Gaji/getkasbon' ?>?&idkaryawan="+idkaryawan+"&bulan="+bulan+"&tahun="+tahun, 
				function(data){   
				$('#detailKasbon').html(data);
			});

			// Load pinjaman
			$.get("<?php echo BASEURL.'Gaji/getpinjaman' ?>?&idkaryawan="+idkaryawan, 
				function(data){   
				$('#detailPinjaman').html(data);
			});
		});
	});
</script>
