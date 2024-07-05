<style>
  body{
    font-family:Arial, Helvetica, sans-serif;
  }
  h1 {
    font-size: 14px;
    text-align: center;
  }
  table{
    width: 100%;
    border-collapse: collapse;
  }

  .registered {
	    font-family: 'Baskervville', serif;
	  }
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
	 footer {
	 	font-family: 'Baskervville', serif;
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 1.1cm;
                height: 2cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: blue;*/
                text-align: right;
                line-height: 1.5cm;
            }
</style>
<h1>
  FORM PENGAMBILAN ALAT-ALAT <?php echo $d['bagian']==1 ? 'BORDIR':'KONVEKSI';?><br>
  GUDANG PUSAT<br>
  PERIODE TANGGAL : <?php echo date('d F Y',strtotime($d['tanggal']))?>
</h1>
<div class="">
  <p>
    Tanggal : <?php echo $d['tanggal'] ?>
  </p>
  <p>
    Mandor : <?php echo $d['mandor'] ?>
  </p>
  <p>
    Shift : <?php echo $d['shift'] ?>
  </p>
</div>
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th colspan="6">Ajuan</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Alat</th>
            <th>Kebutuhan</th>
            <th>Stok</th>
            <th>Ajuan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $rowCount = count($dt);
        $totalRows = 10;

        // Tambahkan baris data yang sudah ada
        foreach ($dt as $b) { 
            $barang = $this->GlobalModel->getDataRow('gudang_persediaan_item', array('id_persediaan' => $b['id_persediaan'], 'hapus' => 0)); 
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $barang['nama_item']; ?></td>
                <td align="center"><?php echo $b['ajuan']; ?></td>
                <td align="center"><?php echo $b['stock']; ?></td>                            
                <td align="center"><?php echo $b['kebutuhan']; ?></td>
                <td><?php echo $b['keterangan']; ?></td>
            </tr>
        <?php } ?>

        <?php 
        // Hitung berapa baris kosong yang perlu ditambahkan
        $emptyRows = $totalRows - $rowCount;

        // Tambahkan baris kosong sesuai kebutuhan
        for ($i = 1; $i <= $emptyRows; $i++) { 
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
 


<table style="width:100%;">
			<tbody>
      <tr>
				<td style="width:50%">
					<p></p>
				</td>
				<td style="width:50%" valign="top">
					<br>
					<table border="1" style="border-collapse: collapse;width: 100%;margin-top: 20px;">
						<tr>
							<td align="center">Admin Gudang</td>
							<td align="center">Pengawas</td>
							<td align="center">Mandor</td>
							<td align="center">Admin</td>
						</tr>
						<tr>
						<td align="center" height="100" valign="bottom">(..................)</td>
						<td align="center" height="100" valign="bottom">(..................)</td>
						<td align="center" height="100" valign="bottom">(..................)</td>
						<td align="center" height="100" valign="bottom">(..................)</td>
						</tr>
					</table>
				</td>
			</tr>
      </tbody>
      <footer>
            <i>Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
        </footer>
		</table>


		 