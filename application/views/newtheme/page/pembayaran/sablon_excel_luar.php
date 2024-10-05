<?php
$namafile='Laporan_Pembayaran_Sablon_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h1>Laporan Pembayaran Sablon Forboys Production<br>
				<?php foreach($cmt as $c){?>
					<?php echo $c['id_cmt']==$cmtf?$c['cmt_name']:'';?>
				<?php } ?>&nbsp;Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date('d M Y',strtotime($tanggal2)) ?>
</h1>

	<div class="row">
		<div class="col-md-6">
			<label>Pendapatan</label>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>DZ</th>
						<th>PCS</th>
						<th>Harga</th>
						<th>Total</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $dz=0;$pcs=0;$harga=0;$total=0; ?>
					<?php foreach($pendapatan as $p){?>
						<?php 
							$pekerjaan[]=$p['pekerjaan'];
							$dzs[$p['pekerjaan']][]=$p['dz'];
						?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['namapo']?></td>
							<td><?php echo ($p['dz'])?></td>
							<td><?php echo ($p['pcs'])?></td>
							<td><?php echo ($p['harga'])?></td>
							<td><?php echo ($p['total'])?></td>
							<td><?php echo $p['ket']?></td>
						</tr>
					<?php
						$dz+=($p['dz']);
						$pcs+=($p['pcs']);
						$harga+=($p['harga']);
						$total+=($p['total']);
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td><b>Total</b></td>
						<td></td>
						<td><?php echo ($dz)?></td>
						<td><?php echo ($pcs)?></td>
						<td><?php echo ($harga)?></td>
						<td><?php echo ($total)?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="col-md-6">
			<label>Pengeluaran</label>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Pembelanjaan Cat dan Afdruk</th>
						<th>Upah Tukang Harian</th>
						<th>Upah Tukang Borongan</th>
						<th>Biaya Lain-lain</th>
						<th>Token Listrik</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $pengeluarantotal=0;?>
					<?php foreach($pengeluaran as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo ($p['belanjacat'])?></td>
							<td><?php echo ($p['upahtukang_harian'])?></td>
							<td><?php echo ($p['upahtukang_borongan'])?></td>
							<td><?php echo ($p['biayalain'])?></td>
							<td><?php echo ($p['tokenlistrik'])?></td>
							<td><?php echo ($p['total'])?></td>
						</tr>
						<?php $pengeluarantotal+=($p['total']);?>
					<?php } ?>
				</tbody>
			</table>
			<br>
			<?php $komisi=0;$tdzz=0;?>
			<?php foreach(array_unique($pekerjaan) as $p =>$val){?>
								<?php
								$name=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$val));
							?>
						<?php 
							$komisi+=$name['price_group']*array_sum($dzs[$val]);	
						?>
			<?php } ?>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Pendapatan</th>
						<th>Pengeluaran</th>
						<th>Sewa</th>
						<th>Provit</th>
					</tr>
				</thead>
				<tbody>
					<td><?php echo ($total)?></td>
					<td><?php echo ($pengeluarantotal)?></td>
					<td><?php echo ($sewa)?></td>
					<td><?php echo ($total-$sewa-$pengeluarantotal-$komisi)?></td>
				</tbody>
			</table>
			<br>
			
			<?php if(isset($cm['jenis_pembayaran'])==2){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Komisi</caption>
			<?php 
			$tdz=0;
			$tjml=0;
			$tpo=0;
			?>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Jenis Sablon</th>
						<th>Jumlah PO (Dz)</th>
						<th>Harga/dz (Rp)</th>
						<th>Jumlah (Rp)</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php //echo json_encode($pekerjaan) ?>
					<?php $b=0;?>
					<?php foreach(array_unique($pekerjaan) as $p =>$val){?>
					<tr>
						<td>
							<?php
								$name=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$val));
								echo !empty($name)?$name['nama_job']:'';
							?>
						</td>
						<td><?php $b=array_sum($dzs[$val]); echo ($b) ;?></td>
						<td><?php echo ($name['price_group'])?></td>
						<td><?php echo ($name['price_group']*array_sum($dzs[$val]))?></td>
						<td><?php echo count($dzs[$val]);?> PO </td>
					</tr>
					<?php 
						$tdz+=array_sum($dzs[$val]);
						$tjml+=$name['price_group']*array_sum($dzs[$val]);
						$tpo+=count($dzs[$val]);
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td><b>Potongan <?php echo $pot_ket ?></b></td>
						<td><b></b></td>
						<td></td>
						<td><b><?php echo ($pot)?></b></td>
						<td><b><?php echo $pot_ket?></b></td>
					</tr>
					<tr>
						<td><b>Total Diterima</b></td>
						<td><b><?php echo ($tdz)?></b></td>
						<td></td>
						<td><b><?php echo ($tjml-$pot)?></b></td>
						<td><b><?php echo $tpo?> PO</b></td>
					</tr>
				</tfoot>
			</table>
			<?php } ?>
		</div>
	</div>
	<br>
	<table>

                                        <tr>
                                            <th colspan="5"></th>
                                            <th>Menyetujui</th>
                                            
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td colspan="5"></td>
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="5"></td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                (  )

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                (  )

                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="7" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
                                    </table>