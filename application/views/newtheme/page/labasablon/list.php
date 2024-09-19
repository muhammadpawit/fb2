<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<table class="table table-bordered mt-4">
        <thead>
            <tr class="table-active">
                <th>Pendapatan</th>
                <th>Kredit (Rp)</th>
                <th>Debet (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $total=0;?>
            <?php foreach($pendapatan as $p) { ?>
            <tr>
                <td>Pendapatan Sablon <?php echo $p['cmt']?></td>
                <td></td>
                <td>Rp. <?php echo number_format($p['jumlah']) ?></td>
                <?php $total+=($p['jumlah']);?>
            </tr>
            <?php } ?>
            <tr class="table-active">
                <td><strong>Jumlah Pendapatan</strong></td>
                <td></td>
                <td><strong>Rp. <?php echo number_format($total) ?></strong></td>
            </tr>
        </tbody>
    </table>
    
    <table class="table table-bordered mt-4">
        <thead>
            <tr class="table-active">
                <th>Pengeluaran</th>
                <th>Kredit (Rp)</th>
                <th>Debet (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $tpn=0;?>
            <?php foreach($pengeluaran as $pn=>$val){?>
            <tr>
                <td><?php echo $pn ?> </td>
                <td><?php echo $val ?></td>
                <td></td>
            </tr>
            <?php $tpn+=($val);?>
            <?php } ?>
            <!-- <tr>
                <td>1. Sewa Tempat</td>
                <td>1.572.000</td>
                <td></td>
            </tr>
            <tr>
                <td>2. Bahan Baku</td>
                <td>6.363.000</td>
                <td></td>
            </tr>
            <tr>
                <td>3. Upah Borongan Tukang</td>
                <td>75.000</td>
                <td></td>
            </tr>
            <tr>
                <td>4. Gaji Anak Harian</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5. Komisi CMT</td>
                <td>20.000</td>
                <td></td>
            </tr>
            <tr>
                <td>6. Token Listrik</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7. Kendaraan Operasional</td>
                <td></td>
                <td></td>
            </tr>-->
            <tr class="table-active">
                <td><strong>Jumlah Pengeluaran</strong></td>
                <td><strong><?php echo number_format($tpn)?></strong></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="center" colspan="2">
                    <b>Laba Bersih</b>
                </td>
                <td>
                    <b>Rp <?php echo number_format($total-$tpn) ?></b>
                </td>
            </tr>
        </tfoot>
    </table>
    
    <h4 class="text-end mt-4" hidden><strong>Laba Bersih: Rp <?php echo number_format($total-$tpn) ?></strong></h4>
	</div>
</div>