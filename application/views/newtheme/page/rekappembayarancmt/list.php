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
            <button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>
		</div>
	</div>
</div>
<div class="row table-responsive">
	<div class="col-md-12">
		<table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2"><center>No</center></th>
                    <th rowspan="2"><center>Nama CMT</center></th>
                    <th colspan="<?php echo count($periode) ?>"><center>Pembayaran</center></th>
                    <th rowspan="2"><center>Jumlah</center></th>
                </tr>
                <tr>
                    <?php foreach($periode as $p){ ?>
                    <th><center><?php echo $p['tanggal']?></center></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php $jumlah=0;?>
                <?php foreach($prods as $p){ ?>
                    <tr>
                        <td align="center"><?php echo $p['no']?></td>
                        <td><?php echo $p['nama']?></td>
                        <?php foreach($p['tgl'] as $t){ ?>
                            <td align="center"><?php echo number_format($t['total'])?></td>
                        <?php } ?>
                        <td align="center"><?php echo number_format($p['jumlah'])?></td>
                    </tr>
                    <?php $jumlah+=($p['jumlah']);?>
                <?php } ?>
                <tr>
                    <td align="center" colspan="2"><b>Total</b></td>
                    <?php foreach($total as $p){ ?>
                    <th><center><?php echo number_format($p['total'])?></center></th>
                    <?php } ?>
                    <th><center><?php echo number_format($jumlah)?></center></th>
                </tr>
            </tbody>
        </table>
	</div>
</div>