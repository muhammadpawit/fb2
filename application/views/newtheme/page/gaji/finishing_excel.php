<?php
$filename=$title.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h3><?php echo $title ?></h3>
<div class="row">
	<table style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
		<tr>
			<?php $i=1;$total1=0;$total2=0;?>
			<?php foreach($karyawans as $k){?>
				<?php if($i%2==0){?>
				<td>
					<table border="1" style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
						<thead>
							<tr style="background-color:yellow">
								<th>Nama</th>
								<th colspan="4"><?php echo strtoupper($k['nama'])?></th>
							</tr>
							<tr style="background-color:yellow">
								<th>Hari</th>
								<th>Gaji (Rp)</th>
								<th>Lembur</th>
								<th>Intensif</th>
								<th>KET</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Senin</td>
								<td align="right"><?php echo $k['senin']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Selasa</td>
								<td align="right"><?php echo $k['selasa']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Rabu</td>
								<td align="right"><?php echo $k['rabu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Kamis</td>
								<td align="right"><?php echo $k['kamis']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Jumat</td>
								<td align="right"><?php echo $k['jumat']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Sabtu</td>
								<td align="right"><?php echo $k['sabtu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Minggu</td>
								<td align="right"><?php echo $k['minggu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Jumlah (Rp)</b></td>
								<td align="right"><label><?php echo ($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']) ?></label></td>
								<td><?php echo $k['lembur']?></td>
								<td><?php echo $k['insentif']?></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Claim (Rp)</b></td>
								<td colspan="4"><?php echo $k['claim']?></td>
							</tr>
							<tr>
								<td><b>Pinjaman</b></td>
								<td colspan="4"><?php echo $k['pinjaman']?></td>
							</tr>
							<tr>
								<td><b>Total (Rp)</b></td>
								<td align="center" colspan="4"><label><?php echo pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']) ?></label></td>
							</tr>
							<tr>
							<td><b>Saving</b></td>
							<td align="right"><label><?php echo number_format($k['saving']) ?></label></td>
								</tr>
								<tr>
							<td><b>Keluarkan Saving</b></td>
							<td align="right"><label><?php echo number_format($k['keluarkansaving']) ?></label></td>
						</tr>
						</tbody>
					</table><br>
				</td>
				<?php
					//$i++;
					$total1+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['saving']+$k['keluarkansaving']);
				?>

				<?php } ?>
				<?php
					$i++;
				?>
				<?php } ?>
		</tr>
	</table>
	<p><b>Total table 1 : <?php echo $total1?></b></p>
	<table style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
		<tr>
			<?php $j=1;?>
			<?php foreach($karyawans as $k){?>
				<?php if($j%2==1){?>
				<td>
					<table border="1" style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
						<thead>
							<tr style="background-color:yellow">
								<th>Nama</th>
								<th colspan="4"><?php echo strtoupper($k['nama'])?></th>
							</tr>
							<tr style="background-color:yellow">
								<th>Hari</th>
								<th>Gaji (Rp)</th>
								<th>Lembur</th>
								<th>Intensif</th>
								<th>KET</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Senin</td>
								<td align="right"><?php echo $k['senin']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Selasa</td>
								<td align="right"><?php echo $k['selasa']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Rabu</td>
								<td align="right"><?php echo $k['rabu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Kamis</td>
								<td align="right"><?php echo $k['kamis']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Jumat</td>
								<td align="right"><?php echo $k['jumat']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Sabtu</td>
								<td align="right"><?php echo $k['sabtu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Minggu</td>
								<td align="right"><?php echo $k['minggu']?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Jumlah (Rp)</b></td>
								<td align="right"><label><?php echo ($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']) ?></label></td>
								<td><?php echo $k['lembur']?></td>
								<td><?php echo $k['insentif']?></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Claim (Rp)</b></td>
								<td colspan="4"><?php echo $k['claim']?></td>
							</tr>
							<tr>
								<td><b>Pinjaman</b></td>
								<td colspan="4"><?php echo $k['pinjaman']?></td>
							</tr>
							<tr>
								<td><b>Total (Rp)</b></td>
								<td align="center" colspan="4"><label><?php echo pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']) ?></label></td>
							</tr>
							<tr>
								<td><b>Saving</b></td>
								<td align="right"><label><?php echo number_format($k['saving']) ?></label></td>
							</tr>
							<tr>
								<td><b>Keluarkan Saving</b></td>
								<td align="right"><label><?php echo number_format($k['keluarkansaving']) ?></label></td>
							</tr>
						</tbody>
					</table><br>
				</td>
				<?php
					$total2+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']);
				?>
				<?php } ?>
				<?php
					$j++;
					$total+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']);
				?>
				<?php } ?>
		</tr>
	</table>
	<p><b>Total table 2 : <?php echo $total2?></b></p>
	<?php 
		$totals=0;
		foreach($karyawans as $k){
			$totals+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['saving']+$k['keluarkansaving']);
			$totalpembulatan += pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['saving']+$k['keluarkansaving']);
		}
	?>

	<h3>Total Keseluruhan Rp. <?php echo (ceil($totals))?></h3>
	<h3>Total Pembulatan Rp. <?php echo number_format($totalpembulatan)?></h3>
</div>
<br><br>
            <table>
              <thead style="text-align: center;">
                <tr>
                  <th colspan="3">
                    Dicek Oleh
                    <br>
                    Adm Keu
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    Mia
                  </th>
                  <th></th>
                  <th></th>
                  <th colspan="3">
                      Dibuat Oleh
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      Kandar
                  </th>
                </tr>
                <tr>
                  <td colspan="12"></td>
                </tr>
                <tr>
                  <td colspan="12"></td>
                </tr>
                <tr>
                  <td colspan="12"></td>
                </tr>
                <tr>
                  <td colspan="12"></td>
                </tr>
                <tr>
                  <td colspan="12" align="right">                  
                    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
                  </td>
                </tr>
              </thead>
            </table>     