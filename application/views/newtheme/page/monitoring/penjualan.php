<div class="row no-print">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="text-center">
			<h3><?php echo $title ?></h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
		<table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Total</th>
                    </tr>
                </thead>
            <tbody>
            	<?php $warna='#05fc37'; $nom=1;$adjpo=0;$adjdz=0;$adjpcs=0;$adjtotal=0;?>
            	<?php foreach($adjustment as $r){?>
					
            		<tr>
	                    <td><?php echo $nom++?></td>
	                    <td><?php echo $r['nama']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                </tr>
	                <?php

	                	$adjpo+=($r['po']);
	                	$adjdz+=($r['dz']);
	                	$adjpcs+=($r['pcs']);
	                	$adjtotal+=($r['total']);
	                ?>
                <?php } ?>

                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekap as $r){?>
					<?php if($r['po'] > 0){ ?>
                <tr>
                    <td><?php echo $nom++?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'],2)?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                    <td><?php echo number_format($r['total'])?></td>
                </tr>
				<?php } ?>
                <?php
                    $po+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                    $total+=($r['total']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($adjpo+$po)?></b></td>
                    <td><b><?php echo number_format($adjdz+$dz,2)?></b></td>
                    <td><b><?php echo number_format($adjpcs+$pcs)?></b></td>
                    <td><b><?php echo number_format($adjtotal+$total)?></b></td>
                </tr>
            </tbody>
        </table>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kemeja</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkemeja as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapcelana as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kaos</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkaos as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-12">
		<div class="form-group">
			<button class="btn btn-info btn-sm" onclick="window.print()">Print</button>
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>