<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Surat_Jalan_".$cmt['cmt_name'].".xls");
?>
<br>
<br>
<br>
<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;" cellspacing="3" cellpadding="10">
	<tr>
    <th class="tg-0pky" rowspan="2"><h2>FB</h2></th>
    <th align="left"><b>TRUE</b></th>
    <th align="left" class="tg-0pky"></th>
    <th align="left" class="tg-0pky"></th>
    <th align="left" class="tg-0pky">Hari / Tanggal</th>
    <th align="left" class="tg-0pky"><?php $hari=hari(date('l',strtotime($kirim['tanggal']))); echo $hari.' , ' .date('d F Y',strtotime($kirim['tanggal']))?></th>
  </tr>
  <tr>
    <th align="left" class="tg-0pky"><b>FORBOYS</b></th>
    <th align="left" class="tg-0pky"></th>
    <th align="left" class="tg-0pky"></th>
    <th align="left" class="tg-0pky">Nama CMT</th>
    <th align="left" class="tg-0pky">Bpk/ibu&nbsp;<?php echo $cmt['cmt_name']?></th>
  </tr>
  <tr>
  	<th align="left" colspan="2">Jl.Z No.1 Kampung Baru, Kec.Sukabumi Selatan     Kebon Jeruk, Jakarta HP : 081380401330</th>
  	<th align="left"></th>
  	<th align="left"></th>
  	<th align="left" align="left">Cabang</th>
  	<th align="left"></th>
  </tr>
</table>
<br>
<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;" cellspacing="3" cellpadding="10">
<tr>
	<td align="center" colspan="6"><b>Nota Kirim PO CMT</b></td>
</tr>
</table>
<br>
<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;" cellspacing="3" cellpadding="10">
									<thead>
										<tr>
											<th class="center">No</th>
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
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
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
										<td align="center" height="100" valign="bottom">(ULPAH)</td>
									</tr>
								</table>
							</div>