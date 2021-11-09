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
			<h3>Monitoring Kirim Setor CMT</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
		<table class="table table-bordered">
            <thead>
                    <tr>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
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
                <?php foreach($rekap as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['countkirim'])?></td>
                    <td><?php echo number_format($r['qtykirimdz'])?></td>
                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
                    <td><?php echo number_format($r['countsetor'])?></td>
                    <td><?php echo number_format($r['qtysetordz'])?></td>
                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
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
                    <td><b><?php echo number_format($jmlpo1)?></b></td>
                    <td><b><?php echo number_format($dz1)?></b></td>
                    <td><b><?php echo number_format($pcs1)?></b></td>
                    <td><b><?php echo number_format($jmlpo2)?></b></td>
                    <td><b><?php echo number_format($dz2)?></b></td>
                    <td><b><?php echo number_format($pcs2)?></b></td>
                </tr>
            </tbody>
        </table>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kemeja</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
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
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
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
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
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
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
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
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
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
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
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
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
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
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
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
		</div>
	</div>
</div>