<!DOCTYPE html>
<html lang="en">
<head>
  <title>Print Nota Surat Jalan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
</head>
<body onload="window.print()">
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="container">
					<div class="card">
						<div class="card-header">
						 
						</div>
						<div class="card-body">
							<div class="row mb-4">
								<div class="col-sm-6" style="float: left;">
									<h2 class="mb-3">Nota Surat Jalan Bordir</h2>
									<div>
										<b>Forboys Production</b>
									</div>
									<div>Jl.Z No.1 Kampung Baru,Sukabumi Selatan </div>
									<div>Kebon Jeruk,Jakarta Barat, Indonesia</div>
									<div>Email: info@forboysproduction.com</div>
									<div>Phone: 081380401330</div>
									
									<br>
								</div>
								<?php $hari=date('l',strtotime($kirim['tanggal']));?>
								<div class="col-sm-6" style="float: right;width: 350px">
									<h2 class="mb-3"><?php echo $kirim['nosj']?></h2>
									<!-- <div>Kepada Yth:<?php echo $cmt['cmt_name']?></div>
									<div>Alamat:<?php echo $cmt['alamat']?></div>
									<div>Phone: <?php echo $cmt['telephone']?></div>
									<div>Hari / Tanggal : <?php echo hari($hari).' , '.date('d F Y',strtotime($kirim['tanggal']))?></div> -->
								</div>
							</div>

							<div class="table-responsive-sm">
								<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;" cellspacing="3" cellpadding="10">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Nama PO</th>
											<th>Rincian PO</th>
											<th align="right">Jumlah PO (pcs)</th>
											<th>JML Barang</th>
											<th>Keterangan</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach($kirims as $k){?>
									<tr>
										<td><?php echo $no++?></td>
										<td><?php echo $k['kode_po']?></td>
										<td><?php echo $k['rincian_po']?></td>
										<td align="right"><?php echo $k['jumlah_pcs']?></td>
										<td><?php echo $k['jml_barang']?></td>
										<td><?php echo $k['keterangan']?></td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" align="right"><b>Total</b>&nbsp;</td>
										<td align="right"><b><?php echo $kirim['totalkirim']?></b></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</tfoot>
								</table>
							</div>
							<br>
							<div>
								<p>Catatan :</p>
								<ol>
									<li>PO yang sudah diterima harap dicek dahulu potongan dan kelengkapanya</li>
									<li>Apabila ada kekurangan, harap segera konfirmasi bagian QC</li>
									<li>Batas maksimal konfirmasi 3 x 24 jam</li>
									<li>Apabila tidak ada konfirmasi, PO dianggap komplit</li>
								</ol>
							</div>
							<br>
							<br>
							<div>
								<table border="1" style="border-collapse: collapse;width: 100%;">
									<tr>
										<td align="center">CMT</td>
										<td align="center">SPV</td>
										<td align="center">Admin KLO</td>
									</tr>
									<tr>
										<td align="center" height="100" valign="bottom">(..................)</td>
										<td align="center" height="100" valign="bottom">(MUCHLAS)</td>
										<td align="center" height="100" valign="bottom">(DINDA)</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	
</div>


</body>
<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript"></script>