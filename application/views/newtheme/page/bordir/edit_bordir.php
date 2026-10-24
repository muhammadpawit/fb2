<?php
// Redesigned Modern Form - Edit Harian Mesin Bordir
// Backup file: edit_bordir_original.php
?>
<style type="text/css">
    .fbm-edit-wrapper {
        --fbm-navy: #1e3a5f;
        --fbm-navy-dark: #152b47;
        --fbm-blue: #2563eb;
        --fbm-blue-subtle: #eff6ff;
        --fbm-green: #10b981;
        --fbm-green-subtle: #ecfdf5;
        --fbm-border: #e2e8f0;
        --fbm-label: #475569;
        --fbm-text: #0f172a;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--fbm-text);
        padding: 4px 2px;
    }

    /* Main Table Container */
    .fbm-edit-card {
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .fbm-edit-card-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--fbm-border);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    .fbm-edit-card-title {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        color: var(--fbm-navy);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fbm-edit-card-title i {
        color: var(--fbm-blue);
    }

    .fbm-badge-info {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .fbm-table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Table Styles */
    .fbm-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12px;
    }

    .fbm-table thead th {
        background: #f1f5f9;
        color: #334155;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 10px 10px;
        border-top: none;
        border-bottom: 2px solid #cbd5e1;
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .fbm-table tbody td {
        padding: 8px 8px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
    }

    .fbm-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Table Inputs */
    .fbm-tbl-input {
        height: 34px !important;
        font-size: 12px !important;
        padding: 4px 8px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
        color: #1e293b !important;
    }

    .fbm-tbl-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
        background: #ffffff !important;
    }

    .fbm-table .select2-container {
        width: 100% !important;
        min-width: 130px;
    }

    .fbm-table .select2-container .select2-selection--single {
        height: 34px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 3px 8px !important;
    }

    .fbm-table .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        font-size: 12px !important;
        color: #1e293b !important;
    }

    .fbm-table .select2-container .select2-selection--single .select2-selection__arrow {
        height: 32px !important;
        right: 4px !important;
    }

    /* Computed Badges/Values */
    .fbm-val-badge {
        display: inline-block;
        padding: 5px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
        white-space: nowrap;
        text-align: right;
        min-width: 70px;
    }

    .fbm-badge-stich {
        background: #eff6ff;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .fbm-badge-hasilx {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .fbm-badge-gaji {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .fbm-badge-tarif {
        background: #f5f3ff;
        color: #5b21b6;
        border: 1px solid #ddd6fe;
    }

    /* Grand Total Row */
    .fbm-table tfoot tr.fbm-total-row td {
        background: #f8fafc;
        border-top: 2px solid #cbd5e1;
        border-bottom: 2px solid #cbd5e1;
        padding: 12px 10px;
        font-size: 12.5px;
    }

    .fbm-grand-total-label {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--fbm-navy);
        text-align: right;
    }

    .fbm-total-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 13px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .fbm-pill-green {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .fbm-pill-purple {
        background: #ede9fe;
        color: #5b21b6;
        border: 1px solid #c4b5fd;
    }

    /* Keterangan & Action Bar */
    .fbm-bottom-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-start;
        justify-content: space-between;
    }

    .fbm-ket-card {
        flex: 1 1 500px;
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .fbm-ket-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--fbm-border);
        padding: 10px 16px;
        font-size: 12px;
        font-weight: 700;
        color: var(--fbm-navy);
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .fbm-ket-body {
        padding: 12px 16px;
    }

    .fbm-ket-table {
        width: 100%;
        margin-bottom: 0;
        font-size: 12px;
    }

    .fbm-ket-table td {
        padding: 4px 6px;
        border: none;
        vertical-align: top;
    }

    .fbm-ket-table .ket-term {
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        width: 180px;
    }

    .fbm-ket-table .ket-sep {
        width: 15px;
        color: #94a3b8;
        font-weight: 700;
    }

    .fbm-ket-table .ket-desc {
        color: #64748b;
    }

    /* Action Buttons Area */
    .fbm-actions-card {
        flex: 0 0 auto;
        min-width: 260px;
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .fbm-btn {
        height: 40px;
        padding: 0 20px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        text-decoration: none !important;
        width: 100%;
    }

    .fbm-btn-cancel {
        background: #ffffff;
        border-color: #cbd5e1;
        color: #475569 !important;
    }

    .fbm-btn-cancel:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a !important;
    }

    .fbm-btn-submit {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);
    }

    .fbm-btn-submit:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 100%);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        transform: translateY(-1px);
    }

    .fbm-btn-submit:active {
        transform: translateY(0);
    }
</style>

<div class="fbm-edit-wrapper">
<form method="post" action="<?php echo $action ?>" id="form-edit-bordir">
	<input type="hidden" name="kode_po" value="<?php echo $kode_po?>">
	
	<!-- CARD TABEL EDIT -->
	<div class="fbm-edit-card">
		<div class="fbm-edit-card-header">
			<h4 class="fbm-edit-card-title">
				<i class="fa fa-list-alt"></i>
				Rincian Inputan Mesin Bordir (ID / Kode PO: <?php echo $kode_po ?>)
			</h4>
			<span class="fbm-badge-info">
				<i class="fa fa-database"></i> <?php echo count($d) ?> Baris Data
			</span>
		</div>
		
		<div class="fbm-table-responsive">
			<table class="table fbm-table">
				<thead>
					<tr>
						<th style="min-width: 110px;">Tanggal</th>
						<th style="min-width: 150px;">Operator</th>
						<th style="width: 70px;">Mesin</th>
						<th style="width: 95px;">Jml Naik</th>
						<th style="width: 95px;">Stich</th>
						<th style="min-width: 95px;">Total Stich</th>
						<th style="width: 70px;">X</th>
						<th style="min-width: 85px;">Hasil X</th>
						<th style="width: 70px;">Kepala</th>
						<th style="width: 90px;">Perkalian</th>
						<th style="width: 75px;">% Mesin</th>
						<th style="min-width: 125px;">Pendapatan Operator</th>
						<th style="min-width: 110px;">Total Tagihan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i=0;
						$total_stich = 0;
						$jumlah_naik = 0;
						$jumlah_stich = 0;
						$jumlah_total_stich = 0;
						$jumlah_perkalian = 0;
						$jumlah_total = 0;
						$jumlah_x = 0;
						$jumlah_hasil_x = 0;
						$jumlah_gaji = 0;
					?>
					<?php foreach($d as $e){?>
						<?php 
							$pemilik = $this->GlobalModel->QueryManualRow("SELECT b.* FROM master_po_luar a left join pemilik_poluar b on a.idpemilik = b.id WHERE a.id = '".$e['idpo']."' ");	
							$mesin = $this->GlobalModel->getDataRow('master_mesin', array('jenis'=>$e['jenis'], 'nomer_mesin'=>$e['mesin_bordir']));
							$pemilik_hasil_x = !empty($pemilik) ? $pemilik['hasil_x'] : 0;
							$pemilik_id = !empty($pemilik) ? $pemilik['id'] : '';
							$mesin_persenan = !empty($mesin) ? $mesin['persenan'] : 0;
							if($pemilik_id==1 && ($e['mesin_bordir'] == 3 || $e['mesin_bordir'] == 4 || $e['mesin_bordir'] == 1 || $e['mesin_bordir'] == 7) ){
								$mesin_persenan=0.2;
							}
							$total_stich = ($e['jumlah_naik_mesin'] * $e['stich']);
							$gaji = ($total_stich * $pemilik_hasil_x * $mesin_persenan);
						?>
						<input type="hidden" name="prods[<?php echo $i?>][id]" value="<?php echo $e['id_kelola_mesin_bordir'] ?>">
						<input type="hidden" name="prods[<?php echo $i?>][jenis]" value="<?php echo $e['jenis'] ?>">
						<input type="hidden" name="pemilik" value="<?php echo $pemilik_id ?>">
						<?php if(!empty($idpo)){ ?>
							<input type="hidden" name="idpo" value="<?php echo $idpo ?>">
						<?php } ?>
						<tr>
							<td>
								<input type="text" name="prods[<?php echo $i?>][created_date]" class="form-control fbm-tbl-input datepicker" value="<?php echo $e['created_date']?>" style="width: 100px;">
							</td>
							<td>
								<select class="selectpicker select2bs4" name="prods[<?php echo $i?>][nama_operator]" data-live-search="TRUE" style="width:100%" required>
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>" <?php echo ($op['id_master_karyawan_bordir']==$e['nama_operator'])?'selected':'' ?>><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
							</td>
							<td align="center">
								<input type="text" name="prods[<?php echo $i?>][mesin_bordir]" value="<?php echo $e['mesin_bordir']?>" class="form-control fbm-tbl-input text-center" style="width: 55px;">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][jumlah_naik_mesin]" value="<?php echo $e['jumlah_naik_mesin']?>" class="form-control fbm-tbl-input naik-mesin text-right" style="width: 80px;">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][stich]" value="<?php echo $e['stich']?>" class="form-control fbm-tbl-input stich-val text-right" style="width: 80px;">
							</td>
							<td align="right">
								<input type="hidden" class="total-stich-input" name="prods[<?php echo $i?>][total_stich]" value="<?php echo $total_stich ?>">
								<span class="fbm-val-badge fbm-badge-stich">
									<span class="total-stich-text"><?php echo $total_stich ?></span>
								</span>
							</td>
							<td align="center">
								<input type="text" class="form-control fbm-tbl-input hasil-x-const text-center" value="<?php echo $pemilik_hasil_x?>" style="width: 55px;">
							</td>
							<td align="right">
								<span class="fbm-val-badge fbm-badge-hasilx">
									<span class="hasil-x-text"><?php echo $total_stich * $pemilik_hasil_x?></span>
								</span>
							</td>
							<td align="center">
								<span class="badge badge-light" style="font-size: 12px; font-weight: 700;"><?php echo $e['kepala']?></span>
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][perkalian_tarif]" value="<?php echo $e['perkalian_tarif']?>" class="form-control fbm-tbl-input perkalian-tarif text-right" style="width: 75px;">
							</td>
							<td align="center">
								<input type="text" class="form-control fbm-tbl-input persenan-mesin text-center" value="<?php echo $mesin_persenan ?>" style="width: 60px;">
							</td>
							<td align="right">
								<input type="hidden" class="gaji-input" name="prods[<?php echo $i?>][gaji]" value="<?php echo $gaji ?>">
								<span class="fbm-val-badge fbm-badge-gaji">
									Rp <span class="gaji-text"><?php echo number_format($gaji, 0, ',', '.') ?></span>
								</span>
							</td>
							<td align="right">
								<input type="hidden" class="total-tarif-input" name="prods[<?php echo $i?>][total_tarif]" value="<?php echo $e['total_tarif'] ?>">
								<span class="fbm-val-badge fbm-badge-tarif">
									Rp <span class="total-tarif-text"><?php echo number_format($e['total_tarif'], 0, ',', '.') ?></span>
								</span>
							</td>
						</tr>
						<?php $i++;?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr class="fbm-total-row">
						<td colspan="11" class="fbm-grand-total-label">
							<i class="fa fa-calculator text-primary"></i> GRAND TOTAL
						</td>
						<td align="right">
							<span class="fbm-total-pill fbm-pill-green">
								Rp <span id="grand-total-gaji"><?php echo number_format($jumlah_gaji, 0, ',', '.') ?></span>
							</span>
						</td>
						<td align="right">
							<span class="fbm-total-pill fbm-pill-purple">
								Rp <span id="grand-total-tarif"><?php echo number_format($jumlah_total, 0, ',', '.') ?></span>
							</span>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	<!-- BOTTOM AREA: KETERANGAN FORMULA & TOMBOL AKSI -->
	<div class="fbm-bottom-row">
		<!-- KETERANGAN FORMULA -->
		<div class="fbm-ket-card">
			<div class="fbm-ket-header">
				<i class="fa fa-info-circle text-info"></i>
				Informasi & Rumus Variabel Perhitungan
			</div>
			<div class="fbm-ket-body">
				<table class="fbm-ket-table">
					<tr>
						<td class="ket-term">Variabel X</td>
						<td class="ket-sep">:</td>
						<td class="ket-desc">Variabel perhitungan tarif pendapatan operator</td>
					</tr>
					<tr>
						<td class="ket-term">Hasil X</td>
						<td class="ket-sep">:</td>
						<td class="ket-desc"><code>Total Stich × X</code></td>
					</tr>
					<tr>
						<td class="ket-term">Pendapatan Operator (Rp)</td>
						<td class="ket-sep">:</td>
						<td class="ket-desc"><code>Total Stich × X × Persentase Mesin</code></td>
					</tr>
					<tr>
						<td class="ket-term">Total Tagihan (Rp)</td>
						<td class="ket-sep">:</td>
						<td class="ket-desc"><code>Total Stich × Perkalian Tarif</code></td>
					</tr>
				</table>
			</div>
		</div>

		<!-- TOMBOL AKSI -->
		<div class="fbm-actions-card">
			<button type="submit" class="btn btn-success fbm-btn fbm-btn-submit">
				<i class="fa fa-check"></i> Simpan Perubahan
			</button>
			<a href="<?php echo $batal?>" class="btn btn-danger fbm-btn fbm-btn-cancel" data-dismiss="modal">
				<i class="fa fa-times"></i> Batal
			</a>
		</div>
	</div>

</form>
</div>

<script>
$(document).ready(function() {
    function parseNum(val) {
        if (typeof val === 'string') {
            val = val.replace(',', '.');
        }
        var n = parseFloat(val);
        return isNaN(n) ? 0 : n;
    }

    function formatNumber(n) {
        return Math.round(n).toLocaleString('id-ID');
    }

    function calculateAll() {
        var grandGaji = 0;
        var grandTarif = 0;

        $('.fbm-table tbody tr').each(function() {
            var row = $(this);
            if (row.find('.naik-mesin').length === 0) return;

            var naik = parseNum(row.find('.naik-mesin').val());
            var stich = parseNum(row.find('.stich-val').val());
            var perkalian_tarif = parseNum(row.find('.perkalian-tarif').val());
            var hasil_x_var = parseNum(row.find('.hasil-x-const').val());
            var persenan_mesin = parseNum(row.find('.persenan-mesin').val());

            var total_stich = naik * stich;
            var hasil_x = total_stich * hasil_x_var;
            var gaji = Math.round(total_stich * hasil_x_var * persenan_mesin);
            var total_tarif = Math.round(total_stich * perkalian_tarif);

            row.find('.total-stich-text').text(total_stich.toLocaleString('id-ID'));
            row.find('.total-stich-input').val(total_stich);
            
            row.find('.hasil-x-text').text(hasil_x.toLocaleString('id-ID'));
            
            row.find('.gaji-text').text(formatNumber(gaji));
            row.find('.gaji-input').val(gaji);
            
            row.find('.total-tarif-text').text(formatNumber(total_tarif));
            row.find('.total-tarif-input').val(total_tarif);

            grandGaji += gaji;
            grandTarif += total_tarif;
        });

        $('#grand-total-gaji').text(formatNumber(grandGaji));
        $('#grand-total-tarif').text(formatNumber(grandTarif));
    }

    $(document).on('input keyup change', '.naik-mesin, .stich-val, .perkalian-tarif, .hasil-x-const, .persenan-mesin', function() {
        calculateAll();
    });

    // Inisialisasi plugin jika dimuat dinamis
    if ($.isFunction($.fn.datepicker)) {
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    }

    if ($.isFunction($.fn.select2)) {
        $('.select2bs4').select2({
            width: '100%'
        });
    }

    // Initial calculation
    calculateAll();
});
</script>