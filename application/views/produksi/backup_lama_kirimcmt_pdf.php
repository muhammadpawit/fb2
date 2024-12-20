<style type="text/css">
	 body{text-transform:capitalize;font-size: 22px;}
	 .hs { font-size: 22px;font-weight: bold; }
	 .break{ page-break-after: always; }
</style>
<div class="kiri" style="width: 500px;border:0px solid red;left:0px;position: absolute;">
	<div class="logo" style="border:0px solid yellow;background-image: url('https://forboysproduction.com/assets/images/0001.jpg');height: 200px;width: 220px;background-position: top;background-size: contain;background-repeat: no-repeat;float: left;display: block;">
		<!-- <img src="" height="170px" style="float:left"> -->
	</div>
	<div style="border:0px solid black;width:100%;margin-top: 50px;float: right">
			<p style="font-size:23px;font-weight: bold;position: absolute;left:200px;display: inline-block;">
				Jl.Z No.1 Kampung Baru,<br>Sukabumi Selatan<br>
				Kebon Jeruk,Jakarta Barat, Indonesia<br>
				HP : 081380401330
			</p>	
	</div>
</div>
<div class="kiri" style="width: 500px;border:0px solid green;right:0px;position: absolute;padding-top: 50px">
	<?php $hari=date('l',strtotime($kirim['tanggal']));?>
	<div style="border:1px solid black; border-collapse: collapse;display: inline-block;width:70%;float:right;padding:5px;">
		<div class="hs">Kepada Yth&nbsp;&nbsp;: <?php echo strtoupper($cmt['cmt_name'])?></div>
		<div class="hs">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo ucfirst($cmt['alamat'])?></div>
		<div class="hs">Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $cmt['telephone']?></div>
		<div class="hs">Hari / Tgl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo hari($hari).' , '.date('d M Y',strtotime($kirim['tanggal']))?></div>
	</div>
</div>
<br><br>
<div style="clear: both;"></div>
<table style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;">
	<thead>
		<tr>
			<th width="150" align="left">No.SJ : <?php echo $kirim['id'] ?>/<?php echo date('m',strtotime($kirim['tanggal']))?>/<?php echo date('Y',strtotime($kirim['tanggal']))?></th>
			<th colspan="4" align="left"><h3 style="margin-left: 200px;text-decoration: underline;">Surat Jalan Kirim PO CMT</h3></th>
		</tr>
	</thead>
</table>
<table border="1" style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;">
									<thead>
										<tr>
											<th class="center">No</th>
											<th>Nama PO</th>
											<th>Rincian PO</th>
											<th>Jumlah PO (pcs)</th>
											<th>JML Barang</th>
											<th>Keterangan</th>
										</tr>
									</thead>
								<tbody>
								<?php foreach($kirims as $k){?>
									<tr>
										<td align="center" width="2%"><?php echo $no++?></td>
										<td align="center" width="6%"><?php echo $k['kode_po']?></td>
										<td align="center" width="10%"><?php echo $k['rincian_po']?></td>
										<td align="center" width="7%"><?php echo $k['jumlah_pcs']?></td>
										<td align="center" width="5%"><?php echo $k['jml_barang']?></td>
										<td align="center" width="10%"><?php echo $k['keterangan']?></td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" align="center"><b>Total</b>&nbsp;</td>
										<td align="center"><b><?php echo number_format($kirim['totalkirim'],0,",",".");?></b></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</tfoot>
								</table>
<p>Catatan :</p>
								<ol>
									<li>PO yang sudah diterima harap dicek dahulu potongan dan kelengkapanya</li>
									<li>Apabila ada kekurangan, harap segera konfirmasi bagian QC</li>
									<li>Batas maksimal konfirmasi 3 x 24 jam</li>
									<li>Apabila tidak ada konfirmasi, PO dianggap komplit</li>
								</ol>
<br>								

<?php if(count($kirims) < 3){?>

<?php }else if(count($kirims)>5 && count($kirims)<=15){?>

<?php }else{ ?>
<div class="break"></div>
<?php } ?>

<?php if(count($kirims)==5){?>
	<div class="break"></div>
<?php } ?>	

<?php if(count($kirims)==6){?>
	<div class="break"></div>
<?php } ?>	

<?php if(count($kirims)==8){?>
	<div class="break"></div>
<?php } ?>	

<div style="width:100%;text-align: center;border:0px solid red;padding-left: 350px;margin-top: 10px">
	<div style="border:0px solid black;height:auto;width: 100%;display: inline-block;margin-right: -5px">
		<table border="1" style="border-collapse: collapse;width: 60%">
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
</div>