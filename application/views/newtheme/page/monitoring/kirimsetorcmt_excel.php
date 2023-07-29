<?php
 $namafile='Laporan_Kirim_Setor_'.time();
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
		<th colspan="4" align="center"><h3>Laporan Monitoring Kirim Setor CMT</h3></th>
	</tr>
</table>
<br>
        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
            <table border="1" style="width: 100%;border-collapse: collapse;">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama PO</th>
                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
                    </tr>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
                <tbody>
                <?php $adjkirim=0;$adjdz=0;$adjpcs=0;$spo=0;$sdz=0;$spcs=0; ?>
                <?php $nom=1;$jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($adjustment as $r){?>
            		<tr>
	                    <td><?php echo $nom++?></td>
	                    <td><?php echo $r['nama']?></td>
	                    <td><?php echo ($r['kirim_po'])?></td>
	                    <td><?php echo ($r['kirim_dz'])?></td>
	                    <td><?php echo ($r['kirim_pcs'])?></td>
	                    <td><?php echo ($r['setor_po'])?></td>
	                    <td><?php echo ($r['setor_dz'])?></td>
	                    <td><?php echo ($r['setor_pcs'])?></td>
	                </tr>
	                <?php

	                	$adjkirim+=($r['kirim_po']);
	                	$adjdz+=($r['kirim_dz']);
	                	$adjpcs+=($r['kirim_pcs']);
	                	$spo+=($r['setor_po']);
	                	$sdz+=($r['setor_dz']);
	                	$spcs+=($r['setor_pcs']);
	                ?>
                <?php } ?>

                <?php foreach($rekap as $r){?>
                <tr>
                    <td><?php echo $nom++?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo ($r['countkirim'])?></td>
                    <td><?php echo ($r['qtykirimdz'])?></td>
                    <td><?php echo ($r['qtykirimpcs'])?></td>
                    <td><?php echo ($r['countsetor'])?></td>
                    <td><?php echo ($r['qtysetordz'])?></td>
                    <td><?php echo ($r['qtysetorpcs'])?></td>
                </tr>
                <?php
                    $jmlpo1+=($r['countkirim']);
                    $jmlpo2+=($r['countsetor']);
                    $dz1+=($r['qtykirimdz']);
                    $dz2+=($r['qtysetordz']);
                    $pcs1+=($r['qtykirimpcs']);
                    $pcs2+=($r['qtysetorpcs']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo ($jmlpo1+$adjkirim)?></b></td>
                    <td><b><?php echo ($dz1+$adjdz)?></b></td>
                    <td><b><?php echo ($pcs1+$adjpcs)?></b></td>
                    <td><b><?php echo ($jmlpo2+$spo)?></b></td>
                    <td><b><?php echo ($dz2+$sdz)?></b></td>
                    <td><b><?php echo ($pcs2+$spcs)?></b></td>
                </tr>
            </tbody>
            </table>
            <br
            <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kemeja</div>
			<table border="1" style="width: 100%;border-collapse: collapse;">
	            <thead>
	                    <tr>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkemeja as $r){?>
	                <tr>
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo ($r['countkirim'])?></td>
	                    <td><?php echo ($r['qtykirimdz'])?></td>
	                    <td><?php echo ($r['qtykirimpcs'])?></td>
	                    <td><?php echo ($r['countsetor'])?></td>
	                    <td><?php echo ($r['qtysetordz'])?></td>
	                    <td><?php echo ($r['qtysetorpcs'])?></td>
	                    <td align="center"></td>
	                </tr>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo ($jmlpo1)?></b></td>
	                    <td><b><?php echo ($dz1)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($jmlpo2)?></b></td>
	                    <td><b><?php echo ($dz2)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                    <td align="center"></td>
	                </tr>
	            </tbody>
	        </table>
            <br>
            <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table border="1" style="width: 100%;border-collapse: collapse;">
	            <thead>
	                    <tr>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapcelana as $r){?>
	                <tr>
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo ($r['countkirim'])?></td>
	                    <td><?php echo ($r['qtykirimdz'])?></td>
	                    <td><?php echo ($r['qtykirimpcs'])?></td>
	                    <td><?php echo ($r['countsetor'])?></td>
	                    <td><?php echo ($r['qtysetordz'])?></td>
	                    <td><?php echo ($r['qtysetorpcs'])?></td>
	                </tr>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo ($jmlpo1)?></b></td>
	                    <td><b><?php echo ($dz1)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($jmlpo2)?></b></td>
	                    <td><b><?php echo ($dz2)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
            <br>
            <div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kaos</div>
			<table border="1" style="width: 100%;border-collapse: collapse;">
	            <thead>
	                    <tr>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkaos as $r){?>
	                <tr>
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo ($r['countkirim'])?></td>
	                    <td><?php echo ($r['qtykirimdz'])?></td>
	                    <td><?php echo ($r['qtykirimpcs'])?></td>
	                    <td><?php echo ($r['countsetor'])?></td>
	                    <td><?php echo ($r['qtysetordz'])?></td>
	                    <td><?php echo ($r['qtysetorpcs'])?></td>
	                </tr>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo ($jmlpo1)?></b></td>
	                    <td><b><?php echo ($dz1)?></b></td>
	                    <td><b><?php echo ($pcs1)?></b></td>
	                    <td><b><?php echo ($jmlpo2)?></b></td>
	                    <td><b><?php echo ($dz2)?></b></td>
	                    <td><b><?php echo ($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>