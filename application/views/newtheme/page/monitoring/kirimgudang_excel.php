<?php
 $namafile='Laporan_Kirim_Gudang_'.time();
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table style="width: 100%;">
	<tr>
		<th colspan="4" align="center"><h3>Laporan Monitoring Kirim Gudang</h3></th>
	</tr>
</table>
<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
        <table border="1" style="width: 100%;border-collapse: collapse;">
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
	                    <td><?php echo ($r['po'])?></td>
	                    <td><?php echo ($r['dz'])?></td>
	                    <td><?php echo ($r['pcs'])?></td>
	                    <td><?php echo ($r['total'])?></td>
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
                    <td><?php echo ($r['po'])?></td>
                    <td><?php echo ($r['dz'])?></td>
                    <td><?php echo ($r['pcs'])?></td>
                    <td><?php echo ($r['total'])?></td>
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
                    <td><b><?php echo ($adjpo+$po)?></b></td>
                    <td><b><?php echo ($adjdz+$dz)?></b></td>
                    <td><b><?php echo ($adjpcs+$pcs)?></b></td>
                    <td><b><?php echo ($adjtotal+$total)?></b></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kemeja</div>
            <table border="1" style="width: 100%;border-collapse: collapse;">
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
	                    <td><?php echo ($r['po'])?></td>
	                    <td><?php echo ($r['dz'])?></td>
	                    <td><?php echo ($r['pcs'])?></td>
	                    <td><?php echo ($r['total'])?></td>
	                    <td><?php echo ($r['hppdz'])?></td>
	                    <td><?php echo ($r['hpppcs'])?></td>
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
	                    <td><b><?php echo ($po)?></b></td>
	                    <td><b><?php echo ($dz)?></b></td>
	                    <td><b><?php echo ($pcs)?></b></td>
	                    <td><b><?php echo ($total)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
            <br>
            <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table border="1" style="width: 100%;border-collapse: collapse;">
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
	                    <td><?php echo ($r['po'])?></td>
	                    <td><?php echo ($r['dz'])?></td>
	                    <td><?php echo ($r['pcs'])?></td>
	                    <td><?php echo ($r['total'])?></td>
	                    <td><?php echo ($r['hppdz'])?></td>
	                    <td><?php echo ($r['hpppcs'])?></td>
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
	                    <td><b><?php echo ($po)?></b></td>
	                    <td><b><?php echo ($dz)?></b></td>
	                    <td><b><?php echo ($pcs)?></b></td>
	                    <td><b><?php echo ($total)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
            <br>
            <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kaos</div>
			<table border="1" style="width: 100%;border-collapse: collapse;">
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
	                    <td><?php echo ($r['po'])?></td>
	                    <td><?php echo ($r['dz'])?></td>
	                    <td><?php echo ($r['pcs'])?></td>
	                    <td><?php echo ($r['total'])?></td>
	                    <td><?php echo ($r['hppdz'])?></td>
	                    <td><?php echo ($r['hpppcs'])?></td>
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
	                    <td><b><?php echo ($po)?></b></td>
	                    <td><b><?php echo ($dz)?></b></td>
	                    <td><b><?php echo ($pcs)?></b></td>
	                    <td><b><?php echo ($total)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>