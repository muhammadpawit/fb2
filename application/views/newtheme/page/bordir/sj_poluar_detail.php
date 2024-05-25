<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="container">
					<div class="card">
						<div class="card-header">
						  <strong><?php //echo $kirim['nosj']?></strong> 
						  <span class="float-right"> <strong>Tanggal:</strong> <?php echo date('d F Y',strtotime($kirim['tanggal']))?></span>
						</div>
						<div class="card-body">
							<div class="row mb-4">
								<div class="col-sm-6">
									<h3 class="mb-3">Nota Surat Jalan </h3>
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
									<strong>Bpk/ibu&nbsp;<?php echo strtolower($kirim['kepada'])?></strong>
									</div>
									<div><?php //echo $cmt['alamat']?></div>
									<div>Email: <?php //echo $cmt['email']?></div>
									<div>Phone: <?php //echo $cmt['telephone']?></div>
								</div>
							</div>

							<div class="table-responsive-sm">
								<table class="table">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>NAMA PO</th>
											<th>GAMBAR</th>
											<th class="no-print">POSISI</th>
											<th align="right">STICH (pcs)</th>
											<th>JML Barang</th>
											<th>Keterangan</th>
										</tr>
									</thead>
								<tbody>
                                    <?php $totalkirim=0;$no=1;?>
								<?php if(isset($kirims)){?>
									<?php foreach($kirims as $k){?>
                                        <?php $po = $this->GlobalModel->GetDataRow('master_po_luar',array('id'=>$k['idpo']));?>
										<tr>
											<td><?php echo $no++?></td>
											<td><?php echo $po['nama']?></td>
											<td><?php echo $k['gambar']?></td>
											<td class="no-print"><?php echo $k['posisi']?></td>
											<td align="right"><?php echo $k['stich']?></td>
											<td align="right"><?php echo $k['qty']?></td>
											<td><?php echo $k['keterangan']?></td>
										</tr>
                                        <?php $totalkirim+=($k['qty']);?>
									<?php } ?>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" align="center"><b>Total</b>&nbsp;</td>
										<td align="right"><b><?php echo $totalkirim?></b></td>
										<td>&nbsp;</td>
										<td class="no-print">&nbsp;</td>
									</tr>
								</tfoot>
								</table>
							</div>
							<hr>
							<div class="row">
							<div class="col-12">
								<a href="<?php echo $cancel; ?>" class="btn btn-danger">Kembali</a>
								<!-- <a href="<?php echo $cetak; ?>" class="btn btn-primary" target="_blank">Cetak</a>
								<a href="<?php echo $excel; ?>" class="btn btn-info" target="_blank">Excel</a> -->
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	
</div>