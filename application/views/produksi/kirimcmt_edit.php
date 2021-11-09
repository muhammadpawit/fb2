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
						<form method="post" action="<?php echo $action?>">
						<div class="card-body">
							<div class="row mb-4">
								<div class="col-sm-6">
									<h3 class="mb-3">Edit Nota Surat Jalan </h3>
									<div>
									<strong>Forboys Production</strong>
									</div>
									<div>Jl.Z No.1 Kampung Baru, Kec.Sukabumi Selatan </div>
									<div>Jakarta Barat, Indonesia</div>
									<div>Email: info@forboysproduction.com</div>
									<div>Phone: -</div>
								</div>
								<div class="col-sm-6">
									<h6 class="mb-3">Kepada Yth:</h6>
									<div>
									<strong>Bpk/ibu&nbsp;<?php echo $cmt['cmt_name']?></strong>
									<br>
									<input type="hidden" name="kode_nota" value="<?php echo $kirim['id']?>">
									<?php $j=0;?>
									<?php foreach($kirims as $k){?>
										<!--<input type="hidden" name="products[<?php echo $j++?>][kode_po]" value="<?php echo $k['kode_po']?>">-->
									<?php } ?>
									<select name="idcmt" class="form-control select2bs4" data-live-search="true">
										<?php foreach($listcmt as $c){?>
											<option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt['id_cmt']?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
										<?php } ?>
									</select>
									</div>
									<div><?php echo $cmt['alamat']?></div>
									<div>Email: <?php echo $cmt['email']?></div>
									<div>Phone: <?php echo $cmt['telephone']?></div>
								</div>
							</div>

							<div class="table-responsive-sm">
								<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;" cellspacing="3" cellpadding="10">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Nama PO</th>
											<th>Rincian PO</th>
											<th class="no-print">Pekerjaan</th>
											<th align="right">Jumlah PO (pcs)</th>
											<th>Keterangan</th>
											<th>JML Barang</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach($kirims as $k){?>
									<tr>
										<td><?php echo $no?></td>
										<td>
											<?php echo $k['kode_po']?>
											<input type="hidden" name="prods[<?php echo $no?>][kategori_cmt]" value="JAHIT">
											<input type="hidden" name="prods[<?php echo $no?>][kode_po]" value="<?php echo $k['kode_po']?>">
										</td>
										<td><input type="text" name="prods[<?php echo $no?>][rincian_po]" value="<?php echo $k['rincian_po']?>" class=""></td>
										<td class="no-print">
											<select name="prods[<?php echo $no?>][job]" class="form-control select2bs4" data-live-search="true">
											<?php foreach($listjob as $l){?>
												<option value="<?php echo $l['id']?>-<?php echo $l['harga']?>" <?php echo $k['job']==$l['id']?'selected':'';?>><?php echo $l['nama_job']?></option>
											<?php } ?>
											</select>
										</td>
										<td align="right"><input type="text" name="prods[<?php echo $no?>][jumlah_pcs]" value="<?php echo $k['jumlah_pcs']?>" class="form-control"></td>
										<td><input type="text" name="prods[<?php echo $no?>][keterangan]" value="<?php echo $k['keterangan']?>" class=""></td>
										<td><input type="text" name="prods[<?php echo $no?>][jml_barang]" value="<?php echo $k['jml_barang']?>" class=""></td>
									</tr>
								<?php $no++; } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4" align="center"><b>Total</b>&nbsp;</td>
										<td align="right"><b><?php echo $kirim['totalkirim']?></b></td>
										<td>&nbsp;</td>
										<td class="no-print">&nbsp;</td>
									</tr>
								</tfoot>
								</table>
							</div>
							<hr>
							<div class="row">
							<div class="col-12">
								<a href="<?php echo BASEURL.'Kelolapo/pengirimancmt'; ?>" class="btn btn-danger btn-sm">Kembali</a>
								<button class="btn btn-info btn-sm" onclick="simpan()"> simpan</button>
							</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>	
		</div>
	</div>
	
</div>
<script type="text/javascript">
	function simpan(){
		$("form").submit();
	}
</script>