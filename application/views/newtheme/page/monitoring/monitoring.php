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
			<h3>Monitoring PO Terpotong</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
		<table class="table table-bordered">
            <thead align="center">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama PO</th>
                        <th colspan="3">Jumlah</th>
                    </tr>
                    <tr>
                    	<th>Jml PO</th>
                        <th>Dz</th>
                        <th>PCS</th>
                    </tr>
                </thead>
            <tbody>
                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
                <?php foreach($rekappotongan as $rp){?>
                    <tr>
                        <td><?php echo $rp['no']?></td>
                        <td><?php echo $rp['type']?></td>
                        <td><?php echo $rp['jmlpo']?></td>
                        <td><?php echo number_format($rp['pdz'],2)?></td>
                        <td><?php echo number_format($rp['ppcs'])?></td>
                    </tr>
                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($jmlpo)?></b></td>
                    <td><b><?php echo number_format($pdz,2)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
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
	            <thead align="center">
	                    <tr>
	                        <th rowspan="2">No</th>
	                        <th rowspan="2">Nama PO</th>
	                        <th colspan="3">Jumlah</th>
	                    </tr>
	                    <tr>
	                    	<th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>PCS</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
	                <?php foreach($kemeja as $rp){?>
	                    <tr>
	                        <td><?php echo $rp['no']?></td>
	                        <td><?php echo $rp['nama']?></td>
	                        <td><?php echo $rp['jmlpo']?></td>
	                        <td><?php echo number_format($rp['pdz'],2)?></td>
	                        <td><?php echo $rp['ppcs']?></td>
	                    </tr>
	                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo)?></b></td>
	                    <td><b><?php echo number_format($pdz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table class="table table-bordered">
	            <thead align="center">
	                    <tr>
	                        <th rowspan="2">No</th>
	                        <th rowspan="2">Nama PO</th>
	                        <th colspan="3">Jumlah</th>
	                    </tr>
	                    <tr>
	                    	<th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>PCS</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
	                <?php foreach($celana as $rp){?>
	                    <tr>
	                        <td><?php echo $rp['no']?></td>
	                        <td><?php echo $rp['nama']?></td>
	                        <td><?php echo $rp['jmlpo']?></td>
	                        <td><?php echo number_format($rp['pdz'],2)?></td>
	                        <td><?php echo $rp['ppcs']?></td>
	                    </tr>
	                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo)?></b></td>
	                    <td><b><?php echo number_format($pdz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kaos</div>
			<table class="table table-bordered">
	            <thead align="center">
	                    <tr>
	                        <th rowspan="2">No</th>
	                        <th rowspan="2">Nama PO</th>
	                        <th colspan="3">Jumlah</th>
	                    </tr>
	                    <tr>
	                    	<th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>PCS</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
	                <?php foreach($kaos as $rp){?>
	                    <tr>
	                        <td><?php echo $rp['no']?></td>
	                        <td><?php echo $rp['nama']?></td>
	                        <td><?php echo $rp['jmlpo']?></td>
	                        <td><?php echo number_format($rp['pdz'],2)?></td>
	                        <td><?php echo $rp['ppcs']?></td>
	                    </tr>
	                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo)?></b></td>
	                    <td><b><?php echo number_format($pdz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
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