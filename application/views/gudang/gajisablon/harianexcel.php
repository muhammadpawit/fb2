<?php
$namafile='GajiHarianSablon_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Periode</th>
						<th>Nama</th>
						<th>Senin</th>
						<th>Selasa</th>
						<th>Rabu</th>
						<th>Kamis</th>
						<th>Jumát</th>
						<th>Sabtu</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$total=0;?>
					<?php foreach($prods as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $k['periode'] ?></td>
							<td><?php echo $k['nama'] ?></td>
							<td><?php echo ($k['senin']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['selasa']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['rabu']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['kamis']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['jumat']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['sabtu']*$k['gajiperhari']) ?></td>
							<td><?php echo (($k['senin']*$k['gajiperhari']) + ($k['selasa']*$k['gajiperhari']) + ($k['rabu']*$k['gajiperhari']) + ($k['kamis']*$k['gajiperhari']) + ($k['jumat']*$k['gajiperhari']) + ($k['sabtu']*$k['gajiperhari']))?></td>
							<td>
								<!-- <a href="<?php echo BASEURL?>Gajisablon/hariandetail/<?php echo $k['id']?>" class="btn btn-xs btn-warning">Detail</a> -->
							</td>
						</tr>
						<?php 
							$total+=(($k['senin']*$k['gajiperhari']) + ($k['selasa']*$k['gajiperhari']) + ($k['rabu']*$k['gajiperhari']) + ($k['kamis']*$k['gajiperhari']) + ($k['jumat']*$k['gajiperhari']) + ($k['sabtu']*$k['gajiperhari']));
						?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9"><b>Total</b></td>
						<td>
							<b><?php echo ($total) ?></b>
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