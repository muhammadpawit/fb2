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
						<?php 
						$pengeluarantotal+=($p['total']);
						$total_tukang_borongan+=($p['upahtukang_harian']+$p['upahtukang_borongan']);?>
					<?php } ?>
				</tbody>
			</table>
			<br>
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
					<td><?php echo ($total-$sewa-$pengeluarantotal)?></td>
				</tbody>
			</table>
			<br>
			<?php if($cm['jenis_pembayaran']==1){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Bagi Hasil</caption>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Forboys (60%)</th>
						<th>CMT (40%)</th>
						
					</tr>
				</thead>
				<tbody>
					<td><?php echo ($saldo*0.6)?></td>
					<td><?php echo ($saldo*0.4)?></td>
				</tbody>
			</table>
			<?php } ?>
			<br>
			<?php if($cm['jenis_pembayaran']==2){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Komisi</caption>
			<?php 
				//print_r(array_count_values($pekerjaan));
				//echo json_encode($pendapatan);

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
					<!-- <?php $b=0;?>
					<?php //foreach(array_unique($pekerjaan) as $p =>$val){?>
					<tr>
						<td>
							<?php
								//$name=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$val));
								//echo !empty($name)?$name['nama_job']:'';
							?>
						</td>
						<td><?php //$b=array_sum($dzs[$val]);echo number_format($b,2) ;?></td>
						<td><?php //echo number_format(3000)?></td>
						<td><?php //echo number_format(3000*array_sum($dzs[$val]))?></td>
						<td><?php //echo count($dzs[$val]);?> PO </td>
					</tr>
					<?php 
						// $tdz+=array_sum($dzs[$val]);
						// $tjml+=3000*array_sum($dzs[$val]);
						// $tpo+=count($dzs[$val]);
					?>
					<?php } ?> -->
					<?php foreach($rekap as $r){?>
						<tr>	
							<td><?php echo $r['jenis']?></td>
							<td><?php echo number_format($r['dz'],2)?></td>
							<td><?php echo $r['harga']?></td>
							<td><?php echo $r['jumlah']?></td>
							<td></td>
						</tr>
						<?php 
							$tdz+=($r['dz']);
							$tjml+=($r['jumlah']);
							//$tpo+=count($dzs[$val]);
						?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
					<td><b>Total Diterima</b></td>
					<td><b><?php echo ($tdz)?></b></td>
					<td></td>
					<td><b><?php echo ($tjml)?></b></td>
					<td><b><?php echo $tpo?></b></td>
					</tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					<tr>
						<td><b>Total Keseluruhan Diterima </b></td>
						<td>Total Upah Tukang Harian & Borongan</td>
						<td></td>
						<td><b><?php echo ($total_tukang_borongan)?></b></td>
						<td><b><?php echo $tpo?></b></td>
						
					</tr>

					<tr>
					<td></td>
						<td>Total Diterima Komisi</td>
						<td></td>
						<td><b><?php echo ($tjml)?></b></td>
						<td><b><?php echo $tpo?></b></td>
					</tr>
					<tr>
					<td></td>
						<td>Total Diterima Keseluruhan</td>
						<td></td>
						<td><b><?php echo ($tjml+$total_tukang_borongan)?></b></td>
						<td><b><?php echo $tpo?></b></td>
					</tr>
				</tfoot>
				
			</table>
			<?php //} ?>
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
                                           

                                        </tr>

                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="7" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
                                    </table>