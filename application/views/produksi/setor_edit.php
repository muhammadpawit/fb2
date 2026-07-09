<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="container">
					<div class="card">
						<div class="card-header">
						  <strong><?php echo $kirim['nosj']?></strong> 
						  <span class="float-right"> <strong>Tanggal:</strong> <?php echo date('d F Y',strtotime($kirim['tanggal']))?></span>
						</div>
						<div class="card-body">
							<div class="row mb-4">
								<div class="col-sm-6">
									<h3 class="mb-3">Nota Terima PO </h3>
									<div>
									<strong>Forboys Production</strong>
									</div>
									<div>Jl.Z No.1 Kampung Baru, Kec.Sukabumi Selatan </div>
									<div>Jakarta Barat, Indonesia</div>
									<div>Email: info@forboysproduction.com</div>
									<div>Phone: -</div>
								</div>
								<div class="col-sm-6">
									<h6 class="mb-3">Dari Yth:</h6>
									<div>
									<strong>Bpk/ibu&nbsp;<?php echo $cmt['cmt_name']?></strong>
									</div>
									<div><?php echo $cmt['alamat']?></div>
									<div>Email: <?php echo $cmt['email']?></div>
									<div>Phone: <?php echo $cmt['telephone']?></div>
								</div>
							</div>

							
							<form method="post" action="<?php echo BASEURL.'Setorancmt/updatePO'; ?>">
								<input type="hidden" name="id_setoran" value="<?php echo $kirim['id']; ?>">
								<input type="hidden" name="id_cmt" value="<?php echo $kirim['idcmt']; ?>">
								<input type="hidden" name="kategori_cmt" value="JAHIT">
								<div class="table-responsive-sm">
									<table class="table table-bordered" id="poTable">
										<thead>
											<tr>
												<th class="center">#</th>
												<th>Nama PO</th>
												<th>Jumlah PO (pcs)</th>
												<th>Keterangan</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($kirims as $k){?>
											<tr>
												<td><?php echo $no?></td>
												<td><?php echo $k['kode_po']?></td>
												<td>
													<input type="hidden" name="prods[<?php echo $no;?>][id]" value="<?php echo $k['id']; ?>">
													<input type="hidden" name="prods[<?php echo $no;?>][idpo]" value="<?php echo $k['idpo']; ?>">
													<input type="number" name="prods[<?php echo $no;?>][totalsetor]" value="<?php echo $k['totalsetor']?>" 
														class="form-control text-right jumlah-po">
												</td>
												<td><?php echo $k['keterangan']?></td>
												<td>
													<a href="<?php echo BASEURL.'Setorancmt/hapusdetail/'.$k['id'].'/'.$kirim['id']; ?>" class="btn btn-danger btn-sm" onclick="return hapusRincian(this);"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
											<?php $no++;?>
										<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2" align="center"><b>Total</b>&nbsp;</td>
												<td align="right">
													<b id="totalDisplay"><?php echo $kirim['totalsetor']?></b>
												</td>
												<td class="no-print">&nbsp;</td>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="row no-print">
									<div class="col-12">
										<button type="submit" class="btn btn-success">Simpan</button>
										<a href="<?php echo isset($setoransablon) ? BASEURL.'Setoransablon' : BASEURL.'Setorancmt'; ?>" class="btn btn-danger">Kembali</a>
										<a onclick="cetak()" class="btn btn-primary text-white" target="_blank">Cetak</a>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<script>
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('jumlah-po')) {
        hitungTotal();
    }
});

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.jumlah-po').forEach(function(input) {
        let val = parseInt(input.value) || 0;
        total += val;
    });
    document.getElementById('totalDisplay').innerText = total;
}

function hapusRincian(element) {
    if(confirm('Apakah Anda yakin ingin menghapus rincian PO ini?')) {
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        element.classList.add('disabled');
        element.style.pointerEvents = 'none';
        return true;
    }
    return false;
}
</script>