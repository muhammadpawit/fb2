<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Bulan</label>
            <ul>
            <?php foreach($prods as $b){ ?>
                <li><a href="<?php echo $b['link']?>"><?php echo $b['bulan'] ?></a></li>
            <?php } ?>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group">
            <label></label>
            <ul>
            <?php foreach($mingguan as $b){ ?>
                <li><a href="<?php echo $b['minggu']?>"><?php echo $b['minggu1'] ?> - <?php echo $b['minggu2'] ?></a></li>
            <?php } ?>
            </ul>
        </div>
    </div>

    <?php if(!empty($_GET['tanggal1'])){ ?>
    <div class="col-md-12">
        <div class="table-responsive">
        <table class="" border="1" style="border-collapse: collapse;width:100%;">
			<thead>
				<tr style="background-color: #d1869e;">
					<th rowspan="2">NO</th>
					<th rowspan="2">Hari, Tanggal</th>
					<th rowspan="2">PO Dikirim</th>
					<th rowspan="2">Jenis PO</th>
					<th colspan="2">Jumlah</th>
					<th rowspan="2">Nilai PO (Rp)</th>
					<th rowspan="2">Keterangan</th>
				</tr>
				<tr style="background-color: #d1869e;">
					<th>PO</th>
					<th>DZ</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;$dz=0;$gdz=0;$gnilai=0;?>
				<?php foreach($products as $p){?>
					<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php

									//if(0==$p['no']){
										echo $p['hari'].','.$p['tanggal'];
									//}

								?>
								
							</td>
							<td><?php echo $p['jml'] ?></td>
							<td></td>
							<td></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['dz'],2):''?></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['nilai']):''?></td>
							<td><?php echo $p['dz'] > 0 ? $p['keterangan']: ''?></td>
					</tr>
					<?php foreach($p['dets'] as $d){ ?>
						
						<?php if($d['jml'] > 0){ ?>
							<tr>
								<td></td>
								<td>
									<?php

										//if(0==$p['no']){
											//echo $p['hari'];
										//}

									?>
									
								</td>
								<td></td>
								<td><?php echo $d['nama']?></td>
								<td><?php echo $d['jml']?></td>
								<td><?php echo number_format($d['dz'],2)?></td>
								<td><?php echo number_format($d['nilai'])?></td>
								<td><?php echo $d['keterangan']?></td>
							</tr>
						<?php } ?>

						<?php
							$jml+=($d['jml']);
							$nilai+=($d['nilai']);
							$dz+=($d['dz']);
						?>
					<?php } ?>
					<?php 
						$gdz+=($p['dz']); 
						$gnilai+=($p['nilai']); 
					?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr style="background-color: yellow;font-weight:700">
					<td colspan="2" align="center"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo $jml?></td>
					<td><?php echo number_format($dz+$gdz,2)?></td>
					<td><?php echo number_format($nilai+$gnilai)?></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><b>Di update terakhir</b></td>
					<td colspan="5">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d F Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
        </div>
    </div>
    <?php } ?>
</div>