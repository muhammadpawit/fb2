<style>
    .bordir-box {
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-top: 3px solid #3c8dbc;
        background: #fff;
        margin-bottom: 30px;
    }
    .bordir-header {
        padding: 12px 15px;
        border-bottom: 1px solid #f4f4f4;
        background: #fafafa;
    }
    .bordir-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #333;
    }
    .table-gaji {
        width: 100%;
        margin-bottom: 0;
    }
    .table-gaji th {
        background: #f9f9f9;
        font-size: 12px;
        font-weight: 700;
        color: #777;
        text-transform: uppercase;
        padding: 10px 15px !important;
        border-bottom: 1px solid #eee !important;
    }
    .table-gaji td {
        padding: 8px 15px !important;
        font-size: 13px;
        border-top: 1px solid #f4f4f4 !important;
    }
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
    .row-total { background: #f4f4f4; font-weight: 700; }
    .row-grand-total { background: #3c8dbc !important; color: white !important; font-weight: 800; }
    .row-grand-total td { border: none !important; }
    .text-muted-small { font-size: 11px; color: #999; font-weight: normal; }
    .badge-shift { font-size: 10px; background: #e1ecf4; color: #39739d; padding: 2px 6px; border-radius: 3px; }
</style>

<div class="row">
	<div class="col-md-12 text-center" style="margin-bottom: 20px;">
		<h3 style="font-weight: 800; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px;">
            Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?>
        </h3>
        <div style="background: #3c8dbc; height: 3px; width: 60px; margin: 10px auto;"></div>
		<p class="text-muted">Periode: <b><?php echo formatTanggalIndo($gaji['tanggal1']).' s.d '.formatTanggalIndo($gaji['tanggal2']) ?></b></p>
	</div>
</div>

<div class="row">
	<?php $allgaji=0; ?>
	<?php foreach($karyawans as $k){?>
	<div class="col-md-6">
		<div class="bordir-box">
            <div class="bordir-header">
                <div class="row">
                    <div class="col-xs-8">
                        <span class="bordir-title"><?php echo strtoupper($k['nama'])?></span>
                    </div>
                    <div class="col-xs-4 text-right">
                        <span class="badge-shift"><?php echo isset($k['shift']) ? strtoupper($k['shift']) : '-' ?></span>
                    </div>
                </div>
            </div>
			<div class="table-responsive">
				<table class="table table-gaji">
					<thead>
						<tr>
							<th>Hari</th>
							<th class="text-right">Gaji</th>
							<th class="text-right">Bonus</th>
							<th class="text-right">U.M</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $totalgaji=0;$totalbonus=0;$totalum=0;$absensi=0;$pinjaman=0;$potongan=0;$claim=0;?>
						<?php foreach($k['details'] as $kd){?>
						<?php
							$tgl2 = date('Y-m-d', strtotime($k['tgl2'] . ' +1 day'));
							$sql="SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$tgl2."' ";
							$potongan=$this->GlobalModel->QueryManualRow($sql);

							$my_potongan = $this->GlobalModel->QueryManual("
								SELECT jp.nama, IFNULL(SUM(po.nominal), 0) as total, IFNULL(GROUP_CONCAT(po.keterangan SEPARATOR ', '), '') as keterangan 
								FROM jenis_potongan jp
                                LEFT JOIN potongan_operator po ON jp.id = po.jenis_potongan 
                                    AND po.hapus=0 
                                    AND po.idkaryawan='".$k['idkaryawan']."' 
                                    AND DATE(po.tanggal) BETWEEN '".$k['tgl1']."' AND '".$tgl2."'
								WHERE jp.hapus=0
								GROUP BY jp.id
                                ORDER BY jp.id ASC
							");
						?>						
						<tr>
							<td><?php echo $kd['hari']?></td>
							<td class="text-right"><?php echo number_format((float)$kd['gaji'])?></td>
							<td class="text-right"><?php echo number_format((float)$kd['bonus'])?></td>
							<td class="text-right"><?php echo number_format((float)$kd['um'])?></td>
							<td><span class="text-muted-small"><?php echo $kd['keterangan']?></span></td>
						</tr>
						<?php 
							$totalgaji+=($kd['gaji']);
							$totalbonus+=($kd['bonus']);
							$totalum+=($kd['um']);
						?>
						<?php }?>
						
                        <!-- Potongan Section (Always Visible) -->
						<?php foreach($my_potongan as $mp){ ?>
						<tr>
							<td class="text-danger"><b>Pot. <?php echo $mp['nama'] ?></b></td>
							<td class="text-right text-danger"><b><?php echo number_format((float)$mp['total']) ?></b></td>
							<td></td>
							<td></td>
							<td><span class="text-muted-small"><?php echo $mp['keterangan'] ?></span></td>
						</tr>
						<?php } ?>

						<tr class="row-total">
							<td>Total Sub</td>
							<td class="text-right"><?php echo number_format((float)($totalgaji-$potongan['total']))?></td>
							<td class="text-right"><?php echo number_format((float)$totalbonus)?></td>
							<td class="text-right"><?php echo number_format((float)$totalum)?></td>
							<td></td>
						</tr>
						
						<tr class="row-grand-total">
							<td>GAJI DITERIMA</td>
							<td colspan="4" class="text-center" style="font-size: 16px;">
                                Rp <?php echo number_format((float)($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?>
                            </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php $allgaji+=(($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="bordir-box" style="border-top-color: #00a65a;">
            <div class="bordir-header">
                <span class="bordir-title">Uang Makan Mandor <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></span>
            </div>
			<table class="table table-gaji">
				<thead>
					<tr>
						<th>Nama</th>
						<th class="text-right">Uang Makan (Rp)</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
                    <tr>
                        <td>Mandor Pagi</td>
                        <td class="text-right"><?php echo number_format((float)$umsiang)?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Mandor Malam</td>
                        <td class="text-right"><?php echo number_format((float)$ummalam)?></td>
                        <td></td>
                    </tr>
                    <tr class="row-total">
                        <td>Jumlah</td>
                        <td class="text-right"><?php echo number_format((float)($umsiang+$ummalam))?></td>
                        <td></td>
                    </tr>
                    <tr class="row-grand-total" style="background-color: #00a65a !important;">
                        <td>TOTAL DITERIMA</td>
                        <td class="text-center" colspan="2" style="font-size: 16px;">
                            <b>Rp <?php echo number_format((float)($umsiang+$ummalam))?></b>
                        </td>
                    </tr>
                </tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="bordir-box" style="border-top-color: #f39c12;">
            <div class="bordir-header">
                <span class="bordir-title">Ringkasan Total Gaji Bordir</span>
            </div>
			<table class="table table-gaji">
                <tbody>
                    <tr>
                        <td>Jumlah Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></td>
                        <td class="text-right"><b><?php echo number_format((float)$allgaji)?></b></td>
                    </tr>
                    <tr>
                        <td>Uang Makan Mandor (Rp)</td>
                        <td class="text-right"><?php echo number_format((float)($umsiang+$ummalam))?></td>
                    </tr>
                    <tr class="row-grand-total" style="background-color: #f39c12 !important;">
                        <td style="font-size: 16px;"><b>TOTAL GAJI BORDIR</b></td>
                        <td class="text-right" style="font-size: 18px;">
                            <b>Rp <?php echo number_format((float)($allgaji+ ($umsiang+$ummalam)))?></b>
                        </td>
                    </tr>
                </tbody>
			</table>
            
			<table class="table table-gaji" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th colspan="2">Catatan Perhitungan:</th>
                    </tr>
                </thead>
				<tbody>
                    <tr>
                        <td style="width: 30%;">Mandor Pagi</td>
                        <td><?php echo $this->ReportModel->getMandor($gaji['id'],1)?></td>
                    </tr>
                    <tr>
                        <td>Mandor Malam</td>
                        <td><?php echo ($this->ReportModel->getMandor($gaji['id'],2))?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="background: #fff9c4; padding: 10px; border-radius: 4px; border: 1px solid #ffe082; font-size: 12px; color: #856404;">
                                1. Operator sudah menggunakan sistem borongan<br>
                                2. Gaji dihitung dari periode Sabtu s.d Jum'at<br>
                                3. Rumus : <b>Jumlah Bordir X Stich X Tarif X % Persentase</b>
                            </div>
                        </td>
                    </tr>
                </tbody>
			</table>
		</div>
	</div>
</div>

<div class="row no-print" style="margin-bottom: 50px;">
	<div class="col-md-12 text-center">
        <a href="<?php echo BASEURL?>Bordir/gajioperator" class="btn btn-default btn-lg" style="min-width: 150px; border-radius: 4px;">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <a href="<?php echo $excel?>" class="btn btn-success btn-lg" style="min-width: 150px; border-radius: 4px; margin-left: 10px;">
            <i class="fa fa-file-excel"></i> Export Excel
        </a>
        <button class="btn btn-primary btn-lg" onclick="window.print()" style="min-width: 150px; border-radius: 4px; margin-left: 10px;">
            <i class="fa fa-print"></i> Cetak Halaman
        </button>
        <button type="button" class="btn btn-info btn-lg" style="min-width: 150px; border-radius: 4px; margin-left: 10px;" onclick="showGajiBordirPdfModal()">
            <i class="fa fa-file-pdf"></i> Print PDF
        </button>
	</div>
</div>

<!-- Modal PDF Preview -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 98%; max-width: 98%; height: 95vh; margin: 1vh auto;">
        <div class="modal-content" style="height: 95vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel"><i class="fa fa-file-pdf"></i> Preview Laporan Gaji Operator Bordir</h5>
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
                <a id="pdfDownloadLink" href="<?php echo BASEURL.'Bordir/operatorbordirdetail/'.$id.'?pdf=true' ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Download PDF</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showGajiBordirPdfModal(){
        var pdfUrl = '<?php echo BASEURL.'Bordir/operatorbordirdetail/'.$id.'?pdf=true' ?>';
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