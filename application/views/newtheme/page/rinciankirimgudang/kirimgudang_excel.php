<?php
$namafile='Kirim_gudang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>
<h1>Laporan Kirim Gudang Harian</h1>
<p>Periode : <?php echo date('d-m-Y',strtotime($tanggal1))?> s.d <?php echo date('d-m-Y',strtotime($tanggal2))?></p>
<table border="1" style="border-collapse: collapse;width:100%">
					<thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kode Artikel</th>
                            <th>Nama PO</th>
                            <th>Kuantitas Kirim (pcs)</th>
                            <th>Kuantitas Kirim (dz)</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        	<?php $pcs=0;$total=0;?>
                            <?php foreach ($notarincian as $key => $sat): ?>
                            <tr>
                                <td><?php echo date('d-m-Y',strtotime($sat['tanggal_kirim'])); ?></td>
                                <td><?php echo strtoupper($sat['kode_artikel']) ?></td>
                                <td><?php echo strtoupper($sat['kodepo']) ?></td>
                                <td><?php echo $sat['jumlah_piece_diterima']?></td>
                                <td><?php echo ($sat['jumlah_piece_diterima']/12)?></td>
                                <td><?php echo ($sat['harga_satuan']) ?></td>
                                <td><?php echo ($sat['harga_satuan']*$sat['jumlah_piece_diterima']) ?></td>
                            </tr>
                            <?php 
                            	$total+=($sat['harga_satuan']*$sat['jumlah_piece_diterima']);
                            	$pcs+=($sat['jumlah_piece_diterima']);
                            ?>	
                            <?php endforeach ?>
                        </tbody>
						<tfoot>
							<tr>
								<td colspan="3"><b>Total</b></td>
								<td><b><?php echo $pcs?></b></td>
								<td></td>
								<td><b><?php echo $total?></b></td>
							</tr>
						</tfoot>
                    </table>
                    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s')?></i>