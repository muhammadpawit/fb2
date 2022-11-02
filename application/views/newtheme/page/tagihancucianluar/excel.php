<?php
$namafile=$title.'_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }

  .besar {font-size: 18px;}
</style>
<h2><?php echo $title?> Forboys  Production</h2>					
					<table border="1" style="width: 100%;border-collapse: collapse;">
						<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Nama</th>
								<th>Nama PO</th>
								<th>Jml pcs</th>
								<th>Harga Per PCS</th>
								<th>Total</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php $total=0;?>
							<?php foreach($products as $p){?>
							<tr>
								<td><?php echo $p['no']?></td>
								<td><?php echo ($p['tanggal']) ?></td>
								<td><?php echo strtolower($p['idkaryawan']) ?></td>
								<td><?php echo ($p['nama_po']) ?></td>
								<td><?php echo $p['jumlah_pcs']?></td>
								<td><?php echo $p['harga'] ?></td>
								<td><?php echo ($p['total']) ?></td>
								<td><?php echo $p['keterangan'] ?></td>
							</tr>
							<?php $total+=($p['total']);?>
							<?php }?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6"><b>Total</b></td>
								<td><b><?php echo $total?></b></td>
								<td></td>
							</tr>
						</tfoot>
					</table>

					<table>

                                        <tr>
                                            <th colspan="5"></th>
                                            <th>Disetujui</th>
                                            <th>Di Periksa oleh:</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td colspan="5"></td>
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="5"></td>
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

                                                ( Dewi )

                                            </td>

                                        </tr>

                                        <tr>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="8" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
                                    </table>