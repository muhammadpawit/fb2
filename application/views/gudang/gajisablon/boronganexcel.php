<?php
$namafile='GajiBoronganSablon_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h2><?php echo $title?></h2>
<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Kode PO</th>
						<th>Gambar</th>
						<th>Model</th>
						<th>Lusin</th>
						<th>Putaran</th>
						<th>Harga</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$total=0;?>
					<?php foreach($prods as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $k['tanggal'] ?></td>
							<td><?php echo $k['namakar'] ?></td>
							<td><?php echo $k['kode_po'] ?></td>
							<td><?php echo $k['gambar'] ?></td>
							<td><?php echo $k['model'] ?></td>
							<td><?php echo $k['dz'] ?></td>
							<td><?php echo $k['putaran'] ?></td>
							<td><?php echo $k['harga'] ?></td>
							<td><?php echo $k['total'] ?></td>
							<td>
								<a href="<?php echo BASEURL?>Gajisablon/hapusborongan/<?php echo $k['id']?>" onclick="return confirm('Apakah yakin?')" class="btn btn-xs btn-danger btn-xs"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php $total+=($k['total']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9"><b>Total</b></td>
						<td>
							<b><?php echo number_format($total) ?></b>
						</td>
					</tr>
					<tr>
                         <td colspan="9"></td>
                    </tr>
                    <tr>
                    	<td colspan="9" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                    </tr>
				</tfoot>
			</table>	