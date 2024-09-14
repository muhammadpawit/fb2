<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row table-responsive">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>NO</th>
					<th>TANGGAL AJUAN</th>
					<th>NAMA BARANG</th>
					<th>SATUAN</th>
					<th>KEBUTUHAN</th>
					<th>STOK</th>
					<th>AJUAN</th>
					<th>KETERANGAN</th>
					<th>ACC SPV</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($prods as $p){ ?>
					
					<?php //if(!empty($spv)) { ?>
					<tr>
						<td><?php echo $p['no'] ?></td>
						<td><?php echo $p['tgl'] ?></td>
						<td><?php echo $p['nama'] ?></td>
						<td><?php echo $p['satuan'] ?></td>
						<td><?php echo $p['kebutuhan'] ?></td>
						<td><?php echo $p['stok'] ?></td>
						<td><?php echo $p['ajuan'] ?></td>
						<td><?php echo $p['keterangan'] ?></td>
						<td>
						<form method="POST" action="<?php echo $acc ?>">
							<input type="hidden" name="bagian" value="<?php echo $type ?>">
							<input type="hidden" hidden name="tanggal" value="<?php echo date('Y-m-d',strtotime($p['tanggal'])) ?>">
						<?php if(!empty($spv)) { ?>
							<input type="hidden" name="prods[<?php echo $p['no'] ?>][id]" value="<?php echo $p['id'] ?>">
							<input type="hidden" name="prods[<?php echo $p['no'] ?>][product_id]" value="<?php echo $p['product_id'] ?>">
							<input type="hidden" name="prods[<?php echo $p['no'] ?>][satuan]" value="<?php echo $p['satuan'] ?>">
							<input type="hidden" name="prods[<?php echo $p['no'] ?>][supplier]" value="<?php echo $p['supplier_id'] ?>">
							<input type="hidden" name="prods[<?php echo $p['no'] ?>][keterangan]" value="<?php echo $p['keterangan'] ?>">
							<input type="number" name="prods[<?php echo $p['no']?>][acc_ajuan]" value="<?php echo $p['acc_ajuan'] ?>">
							<input type="hidden" name="prods[<?php echo $p['no']?>][pembayaran]" value="<?php echo $p['pembayaran'] ?>">
						<?php }else{ ?>
							<?php echo $p['acc_ajuan'] ?>
						<?php } ?>
						</td>
						
						<td>
							<?php if(!empty($spv)) { ?>
								<?php if($p['acc_ajuan']==0){ ?>
									<!-- <button type="submit" class="btn btn-success">Disetujui</button> -->
								<?php } ?>
								<!-- </form>
								<br><br>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_hapus/'.$p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin akan menghapus data ini ? ') ">Dibatalkan</a>
								<br><br> -->
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_edit/'.$p['id'] ?>?&spv=true" class="btn btn-sm btn-warning">Detail</a>
							<?php }else{ ?>
							<?php //if(aksesedit()==1){ ?>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_edit/'.$p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
							<?php  //}?>
							<?php //if(akseshapus()==1){ ?>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_hapus/'.$p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin akan menghapus data ini ? ') ">Hapus</a>
							<?php  //}?>
							<?php } ?>
						</td>
					</tr>
					
					<?php //} ?>
					<?php $no++; ?>
				<?php } ?>
				<tr>
                  <td colspan="8" align="right"></td>
                  <td>
                    <!-- <form method="POST" action="<?php echo BASEURL?>Gudang/acc_ajuan_mingguan"> -->
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                    <!-- <button type="submit" class="btn btn-success btn-sm full">Disetujui</button> -->
					<a href="#" class="btn btn-primary btn-xs text-white ttdDigital" data-toggle="modal" data-target="#detailModalTtd">Setujui</a>
                    </form>
                  </td>
                  <td>
                  <form method="POST" action="<?php echo BASEURL?>Gudang/acc_ajuan_mingguan_batal" hidden>
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                    <button type="submit" class="btn btn-danger btn-sm full">Dibatalkan</button>
                    </form>
                  </td>
                </tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="detailModalTtd" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Persetujuan Digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signatureModal">
            <div id="signatures" style="width: 100%; height: 300px; border: 1px solid #000;margin-top:25px"></div>
            </div>
            <div class="modal-footer">
            
                <button id="clear_signature">Clear</button>
                <button id="save_signature">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
	 $(document).ready(function() {
		// $("#signatures").jSignature();
		$('#detailModalTtd').on('shown.bs.modal', function () {
			$("#signature").jSignature(); // Inisialisasi jSignature setelah modal ditampilkan
			$("#signatures").jSignature();
		});
	 });
</script>