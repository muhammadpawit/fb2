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
            <tr>
                <td>1. PO Dalam</td>
                <td></td>
                <td>7.583.769</td>
            </tr>
            <tr>
                <td>2. PO Homie</td>
                <td></td>
                <td>3.961.290</td>
            </tr>
            <tr>
                <td>3. PO Yaldi</td>
                <td></td>
                <td>7.137.385</td>
            </tr>
            <tr>
                <td>4. PO Jajang</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5. PO Dedi</td>
                <td></td>
                <td>2.610.646</td>
            </tr>
            <tr class="table-active">
                <td><strong>Jumlah Pendapatan</strong></td>
                <td></td>
                <td><strong>21.293.090</strong></td>
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
            <tr>
                <td>1. Belanja Bordir</td>
                <td>1.572.000</td>
                <td></td>
            </tr>
            <tr>
                <td>2. Gaji Karyawan Bordir (Bulanan & Borongan)</td>
                <td>6.363.000</td>
                <td></td>
            </tr>
            <tr>
                <td>3. BBM Kendaraan Ops</td>
                <td>75.000</td>
                <td></td>
            </tr>
            <tr>
                <td>4. Service Kendaraan Ops</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5. Fotokopi ATK</td>
                <td>20.000</td>
                <td></td>
            </tr>
            <tr>
                <td>6. Service Mesin Bordir</td>
                <td></td>
                <td></td>
            </tr>
            <tr class="table-active">
                <td><strong>Jumlah Pengeluaran</strong></td>
                <td><strong>8.030.000</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
    <h4 class="text-end mt-4"><strong>Laba Bersih: Rp 13.263.090</strong></h4>
	</div>
</div>