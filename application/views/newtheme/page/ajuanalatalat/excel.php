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

                                                    ( Dinda )

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