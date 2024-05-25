<style type="text/css">
	 body{text-transform:capitalize;font-size: 20px;}
	 .hs { font-size: 22px;font-weight: bold; }
	 .break{ page-break-after: always; }
	 @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
	  .registered {
	    font-family: 'Baskervville', serif;
	  }
	 footer {
	 	font-family: 'Baskervville', serif;
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: blue;*/
                text-align: right;
                line-height: 1.5cm;
            }
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
		<div class="hs">Kepada Yth&nbsp;&nbsp;: <?php echo strtoupper($kirim['kepada'])?></div>
		<!-- <div class="hs">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo ucfirst($cmt['alamat'])?></div>
		<div class="hs">Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $cmt['telephone']?></div> -->
		<div class="hs">Hari / Tgl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo hari($hari).' , '.date('d M Y',strtotime($kirim['tanggal']))?></div>
		<div class="hs">Keterangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $kirim['keterangan']?></div>
	</div>
</div>
<br><br>
<div style="clear: both;"></div>
<table style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;">
	<thead>
		<tr>
			<th width="150" align="left">No.SJ : <?php echo $kirim['nosj'] ?></th>
			<th colspan="4" align="left"><h3 style="margin-left: 200px;text-decoration: underline;">Surat Jalan Kirim PO BORDIR</h3></th>
		</tr>
	</thead>
</table>
<table border="1" style="border-collapse: collapse; width: 100%; border-color: 1px solid #dee2e6 !important; font-size: 19.5px !important;">
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
										<td class="no-print">&nbsp;</td>
									</tr>
								</tfoot>
								
</table>


<?php if(count($kirims) < 3){?>

<?php }else if(count($kirims)>5 && count($kirims)<=13){?>

<?php }else{ ?>
<!-- <div class="break"></div> -->
<?php } ?>

<?php if(count($kirims)==5){?>
	<!-- <div class="break"></div> -->
<?php } ?>	

<?php if(count($kirims)==6){?>
	<!-- <div class="break"></div> -->
<?php } ?>	

<?php if(count($kirims)==8){?>
	<!-- <div class="break"></div> -->
<?php } ?>	

		<table style="width:100%">
			<tr>
				<td style="width:50%">
					<p>Catatan :</p>
								<ol>
									<!-- <li>PO yang sudah diterima harap dicek dahulu potongan dan kelengkapanya</li>
									<li>Apabila ada kekurangan, harap segera konfirmasi <?php if(!empty($alat)){ ?> Kantor Cab. Sukabumi <?php }else{ ?> bagian QC <?php } ?> </li>
									<li>Batas maksimal konfirmasi 3 x 24 jam</li>
									<li>Apabila tidak ada konfirmasi, PO dianggap komplit</li> -->
								</ol>
				</td>
				<td style="width:50%" valign="top">
					<br>
					<table border="1" style="border-collapse: collapse;width: 100%;margin-top: 20px;">
						<tr>
							<td align="center">Penerima</td>
							<!-- <td align="center"><?php if(!empty($alat)){ ?> Kepala Cabang <?php }else{ ?> SPV <?php } ?></td> -->
							<td align="center">Admin Bordir</td>
						</tr>
						<tr>
						<td align="center" height="100" valign="bottom">(..................)</td>
						<!-- <td align="center" height="100" valign="bottom"> <?php if(!empty($alat)){ ?> (TONI) <?php }else{ ?> (MUCHLAS) <?php } ?></td> -->
						<td align="center" height="100" valign="bottom">(MIA)</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		 <footer>
            <i>Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
        </footer>