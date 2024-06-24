<style type="text/css">
  body{text-transform:capitalize;font-size: 12px;font-family: 'Roboto';-webkit-print-color-adjust: exact !important;}
  table{
    font-family: 'Roboto';font-size: 13px !important;width: 100% !important;margin-top: 15px !important;
    border: 1px solid black;border-collapse: collapse;
  }
  .clear{
    clear: both;
  }
  .print{ display:none !important}
  .kiri{
    display: block;
    width: 50%;
    /*border: 1px solid black;*/
    margin-bottom: 40px;
    float: left;
  }
  .logo{
    font-size: 65px;
    float: left;
    display:block;
    font-style: italic;
    
  }
  .slogan{
    font-size: 20px;
    font-style: italic;
    position: relative;
    margin-left: 25%;
    margin-top: 2px;
  }
  .kanan{
    padding: 5px;
    width: 35%;
    border: 1px solid black;
    margin-bottom: 30px;
    float: right;
    margin-top: 10px;
  }
  .yth{
    text-align: center;
    font-weight: bold;
    padding: 20px;
  }
  .judul{
    text-align: center;
    width: 100%;
    font-weight: bold;
    font-size: 22px;
  }
  .nofaktur{
    font-size: 15px;
    width: 50%;
    float: left;
  }
  .susulan{
    font-size: 15px;
    width: 50%;
    float: right;
    /*text-align: right;*/
  }
  .susulan input{
    text-align: right;
    font-size: 18px;
    width: 30%;
  }

  .ttd{
    width: 60%;
    text-align: center;
    text-transform:lowercase !important;
  }

</style>
<div class="kiri">
  <div class="logo">FB</div>
  <div class="slogan">TRUE<br>FORBOYS PRODUCTION</div>
  <div class="clear"></div>
  <div class="alamat">Jl.Z1 No.1 Kampung Baru, Sukabumi Selatan,<br>Kebon Jeruk, Jakarta. HP : 081380401330</div>
</div>
<div class="kanan">
  <div class="kota">
    Jakarta, <?php echo date('d/m/Y') //echo date('d/m/Y',strtotime($gudangfb[0]['tanggal_kirim'] ))?>
  </div>
  <div class="yth">
    Kepada Yth : <?php echo $d['pengambil'] ?>
  </div>
</div>
<div class="clear"></div>
<div class="judul">
  SURAT JALAN BARANG KELUAR <br>FORBOYS
</div>
<div class="nofaktur">No. Faktur : <strong><?php echo $d['id'] ?></strong></div>
<table border="1" style="border-collapse: collapse; width: 100%; border-color: 1px solid #dee2e6 !important; font-size: 19.5px !important;">
    <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Nama Barang</th>

                                        <th>Jumlah </th>
                                        <th>Satuan</th>

                                    </tr>
    </thead>
    <tbody>
    <?php $no=1; foreach ($barang as $key => $item): ?>

            <tr>

                <td align="center">
                    <b><?php echo $no; ?></b>
                </td>

                <td>

                    &nbsp;<b><?php echo $item['nama'] ?></b> 

                </td>

               
                <td align="center">
                    <?php echo $item['jumlah'] ?>

                </td>

                <td align="center"><?php echo $item['satuan'] ?></td>


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
						<td align="center" height="100" valign="bottom">(Dewi)</td>
						<td align="center" height="100" valign="bottom">(IFAH)</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		 <footer>
            <i>Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
        </footer>