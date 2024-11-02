<?php
$namafile='Ajuan_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table>
	<tr>
		<td colspan="9" align="center"><h1>AJUAN ALAT - ALAT <?php echo $type==1 ? 'BORDIR':'KONVEKSI' ?></h1></td>
	</tr>
</table>
        <table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA BARANG</th>
					<th>KEBUTUHAN</th>
					<th>STOK</th>
					<th>AJUAN</th>
					<th>SATUAN</th>
					<th>TANGGAL AJUAN</th>
					<th>ACC SPV</th>
					<th>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
                <?php $kebutuhan=0;$stok=0;$ajuan=0;?>
				<?php foreach($prods as $p){ ?>
					<tr>
						<td><?php echo $p['no'] ?></td>
						<td><?php echo $p['nama'] ?></td>
						<td><?php echo $p['kebutuhan'] ?></td>
						<td><?php echo $p['stok'] ?></td>
						<td><?php echo $p['ajuan'] ?></td>
						<td><?php echo $p['satuan'] ?></td>
						<td><?php echo $p['tanggal'] ?></td>
						<td></td>
						<td><?php echo $p['keterangan'] ?></td>
					</tr>
                    <?php 
                        $kebutuhan+=($p['kebutuhan']);
                        $stok+=$p['stok'];
                        $ajuan+=($p['ajuan']);?>
				<?php } ?>
                <tr>
                    <td colspan="2" align="center"><b>Total</b></td>
                    <td><b><?php echo $kebutuhan ?></b></td>
                    <td><b><?php echo $stok ?></b></td>
                    <td><b><?php echo $ajuan ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    
                </tr>
			</tbody>
		</table>
        <br><br>
        <h2>Laporan Mingguan Alat-alat Forboys Production</h2>
			<table border="1" cellpadding="3" style="border-collapse: collapse;width: 100%" >
				<thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="1">Stok Awal </th>
		            <th colspan="1">Masuk</th>
		            <th colspan="1">Keluar</th>
		            <th colspan="1">Stok Akhir</th>
		            <th rowspan="2">Satuan</th>
		            <th rowspan="2">Harga</th>
		            <th rowspan="2">Total</th>
		            <th rowspan="2">Ket</th>
		            <th rowspan="2">Barang Masuk Terakhir</th>
		          </tr>
		          <tr>
		            <th>Pcs</th>
		            <!-- <th>Harga</th> -->
		            <th>Pcs</th>
		            <!-- <th>Harga</th> -->
		            <th>Pcs</th>
		            <!-- <th>Harga</th> -->
		            <th>Pcs</th>
		            <!-- <th>Harga</th> -->
		          </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		$stokawalroll=0;
		        		$stokawalyard=0;
		        		$stokmasukroll=0;
		        		$stokmasukyard=0;
		        		$stokkeluarroll=0;
		        		$stokkeluaryard=0;
		        		$stokakhirroll=0;
		        		$stokakhiryard=0;
		        		$total=0;
		        	?>
		        	<?php foreach($prods_rincian as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo strtoupper($p['nama'])?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo ($p['stokawal'])?></td>
		        			<!-- <td><?php echo ($p['stokawalharga'])?></td> -->
		        			<td><?php echo ($p['stokmasuk'])?></td>
		        			<!-- <td><?php echo ($p['stokmasukharga'])?></td> -->
		        			<td><?php echo ($p['stokkeluarroll'])?></td>
		        			<!-- <td><?php echo ($p['stokkeluarharga'])?></td> -->
		        			<td><?php echo ($p['stokakhirroll'])?></td>
		        			<!-- <td><?php echo ($p['stokakhirharga'])?></td> -->
		        			<td><?php echo $p['satuan']?></td>
		        			<td><?php echo ($p['stokakhirharga'])?></td>
		        			<td><?php echo (($p['stokakhirroll']*$p['stokakhirharga']))?></td>
		        			<td><?php echo $p['ket']?></td>
		        			<td><?php echo $p['masukterakhir']?></td>
		        		</tr>
		        		<?php
			        		$total+=(($p['stokakhirroll']*$p['stokakhirharga']));
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="10" align="center"><b>Jumlah</b></td>
		        		<!-- <td><?php echo ($stokawalroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokmasukroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokkeluarroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokakhirroll)?></td>
		        		<td></td> -->
		        		<td><?php echo ($total)?></td>
		        		<td></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
<table>
        <tr>
          <td colspan="14" align="right"><i>Registered by Forboys Production System</i></td>
        </tr>
        <tr>
          <td colspan="14"></td>
        </tr>
        <tr>
          <td colspan="13"></td>
          <td>
            <b>Jakarta, <?php echo date('d F Y',strtotime($tanggal2))?></b>
          <table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Disetujui</th>
                                            <th>Disusun</th>
                                        </tr>

                                        <tr align="center">
                                            <td><b>SPV</b></td>
                                            <td><b>Adm Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas)

                                            </td>
                                            
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>                                            
                                                ( Ifah )
                                            </td>
                                        </tr>

                                    </table>
          </td>
        </tr>
      </table>			
        <br><br>
                                    <table>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="3">
                                        <table border="1" style="width: 100%;border-collapse: collapse;">

                                            <tr>
                                                <th>Menyetujui</th>
                                                <th>Dicek oleh:</th>
                                                <th>Dibuat oleh :</th>
                                            </tr>

                                            <tr align="center">
                                                <td><b>SPV</b></td>
                                                <td><b>ADM Keuangan</b></td>
                                                <td><b>ADM Gudang</b></td>

                                            </tr>

                                            <tr>
                                                <td height="100" align="center">

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    ( Muchlas )

                                                </td>
                                                <td height="100" align="center">

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    ( Mia )

                                                </td>

                                                <td height="100" align="center">

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    <br>

                                                    ( Ifah )

                                                </td>

                                            </tr>

                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                    </tr>
                                    </table>