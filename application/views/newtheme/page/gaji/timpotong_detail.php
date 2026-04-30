<div class="row">
	<div class="col-md-12 text-center">
		<h4>Laporan Pembayaran Hasil Kerja Tim Potong <?php echo $timnya['nama']?></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama PO</th>
					<th>Jenis</th>
					<th>Size</th>
					<th>JML PO (Dz)</th>
					<th>JML PO (Pcs)</th>
					<th>Harga/Pcs</th>
					<th>Total Pendapatan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($products as $p){?>
					<?php if($p['total'] > 0){ ?>
					<tr>
						<td><?php echo $no++?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['jenis']?></td>
						<td><?php echo $p['size']?></td>
						<td><?php echo number_format($p['lusin'],2)?></td>
						<td><?php echo number_format($p['pcs'])?></td>
						<td><?php echo number_format($p['harga'])?></td>
						<td><?php echo number_format($p['total'])?></td>
						<td></td>
					</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8" align="right"><b>Total Pendapatan</b></td>
					<td><b><?php echo $total?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="8" align="right"><b>Tabungan (5%)</b></td>
					<td><b><?php echo $saving?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="8" align="right"><b>Potongan Claim</b></td>
					<td><b><?php echo number_format($claim)?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="8" align="right"><b>Total diterima</b></td>
					<td><b><?php echo $bersih?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Kembali</a>
		<button type="button" class="btn btn-primary btn-sm" onclick="previewPDF('?pdf=1')"><i class="fa fa-file-pdf"></i> Preview PDF</button>
		<a href="?pdf=1&download=1" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download PDF</a>
		<a href="?excel=1" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</a>
	</div>
</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modal-pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Preview Laporan Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="iframe-pdf" src="" style="width: 100%; height: 75vh; border: none;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <a id="btn-download-pdf" href="" class="btn btn-primary"><i class="fa fa-download"></i> Download PDF</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function previewPDF(url) {
		$("#iframe-pdf").attr("src", url);
		$("#btn-download-pdf").attr("href", url + "&download=1");
		$("#modal-pdf").modal("show");
	}

	// Reset iframe src when modal is closed to save resources
	$('#modal-pdf').on('hidden.bs.modal', function () {
		$("#iframe-pdf").attr("src", "");
	});
</script>