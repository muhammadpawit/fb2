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

							<div class="table-responsive-sm">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Nama PO</th>
											<th align="right">Jumlah PO (pcs)</th>
											<th>Keterangan</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach($kirims as $k){?>
									<tr>
										<td><?php echo $no++?></td>
										<td><?php echo $k['kode_po']?></td>
										<td align="right"><?php echo $k['totalsetor']?></td>
										<td><?php echo $k['keterangan']?></td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" align="center"><b>Total</b>&nbsp;</td>
										<td align="right"><b><?php echo $kirim['totalsetor']?></b></td>
										<td class="no-print">&nbsp;</td>
									</tr>
								</tfoot>
								</table>
							</div>
							<hr>
							<div class="row no-print">
							<div class="col-12">
								<a href="<?php echo BASEURL.'Setorancmt'; ?>" class="btn btn-danger">Kembali</a>
								<a onclick="cetak()" class="btn btn-primary text-white" target="_blank">Cetak</a>
								<!--<a href="<?php echo $cetak; ?>" class="btn btn-primary" target="_blank">Cetak</a>
								<a href="<?php echo $excel; ?>" class="btn btn-info" target="_blank">Excel</a>-->
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<script type="text/javascript">
	function cetak(){
		window.print();
	}
</script>