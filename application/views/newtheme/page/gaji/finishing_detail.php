<div class="row">
    <div class="col-md-12 text-center">
        <h3 class="text-uppercase" style="font-weight: bold;"><?php echo $title ?></h3>
    </div>
	<div class="col-md-12">
		<div class="form-group">
			<label>Periode : </label>
			<span style="font-size: 18px; font-weight: bold;"><?php echo isset($gaji['tanggal1']) ? formatTanggalIndo($gaji['tanggal1']).' s.d '.formatTanggalIndo($gaji['tanggal2']) : '-' ?></span>
		</div>
	</div>
</div>

<div class="row">
	<?php $totalpembulatan=0; $total_seluruh=0;?>
	<?php foreach($karyawans as $k){?>
	<div class="col-md-4">
		<div class="card mb-4 shadow-sm" style="border-top: 3px solid #3498db;">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0" style="font-weight: bold; color: #2c3e50;">
                    <i class="fa fa-user-circle"></i> <?php echo strtoupper($k['nama'])?>
                </h5>
            </div>
			<div class="table-responsive">
				<table class="table table-sm table-bordered mb-0">
					<thead>
						<tr class="bg-light">
							<th width="50%">Item</th>
							<th width="50%" class="text-right">Nominal (Rp)</th>
						</tr>
					</thead>
					<tbody>
						<tr><td>Senin</td><td align="right"><?php echo number_format($k['senin'])?></td></tr>
						<tr><td>Selasa</td><td align="right"><?php echo number_format($k['selasa'])?></td></tr>
						<tr><td>Rabu</td><td align="right"><?php echo number_format($k['rabu'])?></td></tr>
						<tr><td>Kamis</td><td align="right"><?php echo number_format($k['kamis'])?></td></tr>
						<tr><td>Jumat</td><td align="right"><?php echo number_format($k['jumat'])?></td></tr>
						<tr><td>Sabtu</td><td align="right"><?php echo number_format($k['sabtu'])?></td></tr>
						<tr><td>Minggu</td><td align="right"><?php echo number_format($k['minggu'])?></td></tr>
						<tr><td>Lembur</td><td align="right"><?php echo number_format($k['lembur'])?></td></tr>
						<tr><td>Insentif</td><td align="right"><?php echo number_format($k['insentif'])?></td></tr>
						<tr class="text-danger"><td>Pot. Claim</td><td align="right">- <?php echo number_format($k['claim'])?></td></tr>
						<tr class="text-danger"><td>Pot. Pinjaman</td><td align="right">- <?php echo number_format($k['pinjaman'])?></td></tr>
						<tr class="bg-light" style="font-weight: bold;">
							<td>SUB TOTAL</td>
							<td align="right"><?php 
                                $sub = $k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman'];
                                echo number_format($sub);
                            ?></td>
						</tr>
                        <?php if(isset($k['saving'])){ ?>
						<tr><td>Saving</td><td align="right">- <?php echo number_format($k['saving']) ?></td></tr>
						<tr><td>Keluarkan Saving</td><td align="right">+ <?php echo number_format($k['keluarkansaving']) ?></td></tr>
                        <?php } ?>
						<tr style="background-color: #2c3e50; color: white;">
							<td><b>DITERIMA (PEMBULATAN)</b></td>
							<td align="right"><b><?php 
                                $grand = $sub;
                                if(isset($k['saving'])){
                                    $grand = $grand - $k['saving'] + $k['keluarkansaving'];
                                }
                                $pembulatan = pembulatangaji($grand);
                                echo number_format($pembulatan);
                                $totalpembulatan += $pembulatan;
                                $total_seluruh += $grand;
                            ?></b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4 class="mb-0">TOTAL PEMBULATAN : Rp. <?php echo number_format($totalpembulatan)?></h4>
            </div>
        </div>
    </div>
</div>
<?php 
	$segment = $this->uri->segment(2); // Get 'gajiklodetail', 'pressqcdetail', or 'finishingdetail'
	$pdf_url = BASEURL.'Gaji/'.$segment.'/'.$id.'?pdf=true';
?>

<div class="row mt-4 no-print">
	<div class="col-md-12">
		<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
		<button class="btn btn-success btn-sm" onclick="excel()"><i class="fa fa-file-excel"></i> Excel</button>
		<button class="btn btn-info btn-sm" onclick="showPdfModal('<?php echo $pdf_url ?>')"><i class="fa fa-file-pdf"></i> Print PDF</button>
	</div>
</div>

<!-- Modal PDF Preview -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 98%; max-width: 98%; height: 95vh; margin: 1vh auto;">
        <div class="modal-content" style="height: 95vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel"><i class="fa fa-file-pdf"></i> Preview Laporan Gaji Finishing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; height: calc(95vh - 120px);">
                <div id="pdfLoading" style="display:flex; justify-content:center; align-items:center; height:100%;">
                    <div style="text-align:center;">
                        <i class="fa fa-spinner fa-spin fa-3x"></i>
                        <p style="margin-top:10px;">Memuat PDF...</p>
                    </div>
                </div>
                <iframe id="pdfIframe" style="width: 100%; height: 100%; border: none; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                
                <a id="pdfDownloadLink" href="<?php echo $pdf_url ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Download PDF</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function excel(){
		url = window.location.href + (window.location.href.indexOf('?') >= 0 ? '&' : '?') + 'excel=1';
		location = url;
	}

    function showPdfModal(pdfUrl){
                
        $('#pdfLoading').show();
        $('#pdfIframe').hide();
        $('#pdfIframe').attr('src', pdfUrl);
        $('#pdfModal').modal('show');
        $('#pdfIframe').on('load', function(){
            $('#pdfLoading').hide();
            $('#pdfIframe').show();
        });
    }

    // Reset iframe saat modal ditutup
    $('#pdfModal').on('hidden.bs.modal', function () {
        $('#pdfIframe').attr('src', '');
    });
</script>