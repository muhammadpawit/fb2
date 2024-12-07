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
	<?php $hari=date('l',strtotime($barang[0]['created_date']));?>
	<div style="border:1px solid black; border-collapse: collapse;display: inline-block;width:70%;float:right;padding:5px;">
		<div class="hs">Kepada Yth&nbsp;&nbsp;: <?php echo $barang[0]['nama_penerima']; ?></div>
		<div class="hs">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo ucfirst($barang[0]['tujuan_item'])?></div>
		<div class="hs">Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </div>
		<div class="hs">Hari / Tgl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo hari($hari).' , '.date('d M Y',strtotime($barang[0]['created_date']))?></div>
	</div>
</div>
<br><br>
<div style="clear: both;"></div>
<table style="border-collapse:collapse; width: 100%;border-color:1px solid #dee2e6 !important;">
	<thead>
		<tr>
			<th width="150" align="left">No.SJ : <?php echo $barang[0]['faktur_no'] ?></th>
			<th colspan="4" align="left"><h3 style="margin-left: 200px;text-decoration: underline;">Surat Jalan Alat PO CMT</h3></th>
		</tr>
	</thead>
</table>
<table border="1" style="border-collapse: collapse; width: 100%; border-color: 1px solid #dee2e6 !important; font-size: 19.5px !important;">
    <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Nama Barang</th>

                                        <th>Jumlah </th>
                                        <th>Satuan</th>
										<th>Harga</th>
										<th>Total</th>

                                    </tr>
    </thead>
    <tbody>
    <?php $no=1; foreach ($barang as $key => $item): ?>

            <tr>

                <td align="center">
                    <b><?php echo $no; ?></b>
                </td>

                <td>

                    &nbsp;<b><?php echo $item['nama_item_keluar'] ?></b> 

                </td>

               
                <td align="center">
                    <?php echo $item['jumlah_item_keluar'] ?>
                </td>

                <td align="center"><?php echo $item['satuan_jumlah_keluar'] ?></td>
				

				<td align="center">
                    <?php echo number_format($item['harga_skb']) ?>
                </td>

				<td align="center">
                    <?php echo number_format($item['harga_skb']*$item['jumlah_item_keluar']) ?>
                </td>

            </tr>
            <?php $no++;?>
            <?php endforeach ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>


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
							<td align="center">Security</td>
							<td align="center"><?php if(!empty($alat)){ ?> Kepala Cabang <?php }else{ ?> Mandor Finishing <?php } ?></td>
							<td align="center"><?php if(!empty($alat)){ ?> Admin SKB <?php }else{ ?> Admin Gudang <?php } ?></td>
						</tr>
						<tr>
						<td align="center" height="100" valign="bottom">(..................)</td>
						<td align="center" height="100" valign="bottom">(Kandar)</td>
						<td align="center" height="100" valign="bottom">(Ifah)</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		 <footer>
            <i>Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
        </footer>