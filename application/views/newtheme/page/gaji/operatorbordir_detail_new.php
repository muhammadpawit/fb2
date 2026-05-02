<div class="row">
	<div class="col-md-12 text-center">
		<h3>Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></h3>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label>Periode</label>
			<h4><?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
		</div>
	</div>
</div>
<div class="row">
	<?php $allgaji=0; ?>
	<?php foreach($karyawans as $k){?>
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr style="background-color:#3498db; color:white">
						<th>Nama</th>
						<th colspan="4"><?php echo $k['nama']?></th>
					</tr>
					<tr style="background-color:#3498db; color:white">
						<th>Shift</th>
						<th colspan="4"><?php echo isset($k['shift']) ? $k['shift'] : '-' ?></th>
					</tr>
					<tr style="background-color:#f2f2f2">
						<th>Hari</th>
						<th>Gaji</th>
						<th>Bonus</th>
						<th>Um</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgaji=0;$totalbonus=0;$totalum=0;$absensi=0;$pinjaman=0;$potongan=0;$claim=0;?>
					<?php foreach($k['details'] as $kd){?>
					<?php
						$sql="SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ";
						$potongan=$this->GlobalModel->QueryManualRow($sql);

						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");

						if(!empty($sabsensi)){
							$absensi=$sabsensi['total'];
						}
						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total,keterangan FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)){
							$claim=$sclaim['total'];
						}
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)){
							$pinjaman=$spinjaman['total'];
						}


					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo number_format($kd['gaji'])?></td>
						<td align="right"><?php echo number_format($kd['bonus'])?></td>
						<td align="right"><?php echo number_format($kd['um'])?></td>
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgaji+=($kd['gaji']);
						$totalbonus+=($kd['bonus']);
						$totalum+=($kd['um']);
					?>
					<?php }?>
					
					<tr>
						<td><b>Pot.Absensi</b></td>
						<td align="right"><b><?php echo number_format((float)$absensi)?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td><b>Pot.Claim</b></td>
						<td align="right"><b><?php echo number_format((float)$claim)?></b></td>
						<td></td>
						<td></td>
						<td align="right"><?php echo !empty($claim)?$sclaim['keterangan']:'';?></td>
					</tr>

					<tr>
						<td><b>Pot.Pinjaman</b></td>
						<td align="right"><b><?php echo number_format((float)$pinjaman)?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>


					<tr style="background-color:#f2f2f2">
						<td><b>Total</b></td>
						<td align="right"><b><?php echo number_format((float)($totalgaji-$potongan['total']))?></b></td>
						<td align="right"><b><?php echo number_format((float)$totalbonus)?></b></td>
						<td align="right"><b><?php echo number_format((float)$totalum)?></b></td>
						<td></td>
					</tr>
					
					<tr style="background-color:#3498db; color:white">
						<td><b>Gaji Diterima</b></td>
						<td colspan="4" align="center"><b><?php echo number_format((float)($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php $allgaji+=(($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<table class="table table-bordered">
				<tr style="background-color:#3498db; color:white">
					<th colspan="4">Uang Makan Mandor <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?> (Rp)</th>
				</tr>
				<tr style="background-color:#f2f2f2">
					<td>Nama</td>
					<td>Uang Makan (Rp)</td>
					<td>Keterangan</td>
				</tr>
				<tr>
					<td>Mandor Pagi</td>
					<td><?php echo number_format($umsiang)?></td>
					<td></td>
				</tr>
				<tr>
					<td>Mandor Malam</td>
					<td><?php echo number_format($ummalam)?></td>
					<td></td>
				</tr>
				<tr style="background-color:#f2f2f2">
					<td>Jumlah</td>
					<td><?php echo number_format($umsiang+$ummalam)?></td>
					<td></td>
				</tr>
				<tr style="background-color:#3498db; color:white">
					<td>Total Diterima (Rp)</td>
					<td align="center"><b><?php echo number_format($umsiang+$ummalam)?></b></td>
					<td>UM Mandor</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<table class="table table-bordered">
				<tr style="background-color:#f2f2f2">
					<td>Jumlah Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></td>
					<td><b><?php echo number_format((float)$allgaji)?></b></td>
				</tr>
				<tr>
					<td>Uang Makan Mandor (Rp)</td>
					<td><?php echo number_format((float)($umsiang+$ummalam))?></td>
				</tr>
				<tr style="background-color:#3498db; color:white">
					<td><b>Total Gaji Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu';?></b></td>
					<td><b><?php echo number_format((float)($allgaji+ ($umsiang+$ummalam)))?></b></td>
				</tr>
			</table>
			<table class="table table-bordered">
				<tr>
					<td colspan="2">Catatan:</td>
				</tr>
				<tr>
					<td>Mandor Pagi</td>
					<td><?php echo json_encode($this->ReportModel->getMandor($gaji['id'],1))?></td>
				</tr>
				<tr>
					<td>Mandor Malam</td>
					<td><?php echo ($this->ReportModel->getMandor($gaji['id'],2))?></td>
				</tr>
				<tr>
					<td colspan="2">
						<b class="besar">
							1.Operator sudah sistem borongan<br>
							2.Gaji dihitung dari Sabtu ke Jum'at<br>
							3.Rumus perhitungan gaji borongan operator bordir<br>
							<b>Rumus : Jumlah yang di bordir X Stich X Tarif X Jumlah persentase (%)</b>
						</b>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-3">
		<div class="form-group">
			<a href="<?php echo BASEURL?>Bordir/gajioperator" class="btn btn-danger btn-sm" style="width: 100%">Kembali</a>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<a href="<?php echo $excel?>" class="btn btn-success btn-sm" style="width: 100%">Excel</a>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<button type="button" class="btn btn-info btn-sm" style="width: 100%" onclick="showGajiBordirPdfModal()">
				Print PDF
			</button>
		</div>
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