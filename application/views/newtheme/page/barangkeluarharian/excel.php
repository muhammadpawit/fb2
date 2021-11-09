<?php
$namafile=$title.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	table{width: 100% !important;}
</style>
<!-- <table border="1" style="width: 100%;border-collapse: collapse;"> -->

<table style="width: 100%">
	<tr>
		<td colspan="6" align="center"><b>Form Rekap Item Keluar Mingguan</b></td>
	</tr>
	<tr>
		<td colspan="6" align="center"><b>Gudang Pusat</b></td>
	</tr>
	<tr>
		<td width="10px">Bagian</td>
		<td><?php echo $bagi['nama']?></td>
	</tr>
	<tr>
		<td width="10px">Periode</td>
		<td><?php echo date('d F',strtotime($tanggal1))?>-<?php echo date('d F Y',strtotime($tanggal2))?></td>
	</tr>
</table>

<?php $no=1?>
<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="10">
	<tr align="center">
		<td>Tanggal</td>
		<td>Item</td>
		<td>Jumlah</td>
		<td>Satuan</td>
		<td>Keterangan</td>
	</tr>
	<tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                      <tr>
                        <td><?php echo $p['tanggal']?></td>
                        <td><?php echo $p['nama']?></td>
                        <td><?php echo $p['jumlah']?></td>
                        <td><?php echo $p['satuan']?></td>
                        <td><?php echo $p['keterangan']?></td>
                      </tr>
                  <?php }?>
                <?php } ?>
              </tbody>
</table>
<br>

<table>

                                        <tr>
                                            <th colspan="2"></th>
                                            <th>Menyetujui</th>
                                            <td></td>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td colspan="2"></td>
                                            <td><b>SPV</b></td>
                                            <td></td>
                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="2"></td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas Muchtar)

                                            </td>
                                            <td></td>
                                            <td height="100" align="center">
                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( DWI )

                                            </td>

                                        </tr>

                                    </table>