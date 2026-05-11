<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('msg')) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('msg'); ?>
        </div>
        <?php } ?>
    </div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
        <table class="table table-bordered yessearch">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">No</th>
                    <th>Periode Pembayaran Gaji</th>
                    <th class="text-center" style="width: 250px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($gajis)){ ?>
                    <?php $n=1; foreach($gajis as $g){ ?>
                    <tr>
                        <td class="text-center"><?php echo $n++ ?></td>
                        <td>
                            <strong><?php echo date('d F Y', strtotime($g['tanggal1'])) ?></strong> 
                            <span class="text-muted mx-2">-</span> 
                            <strong><?php echo date('d F Y', strtotime($g['tanggal2'])) ?></strong>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo BASEURL?>Gaji/finishingdetail/<?php echo $g['id'] ?>" class="btn btn-xs btn-warning" style="color:white;">
                                <i class="fa fa-eye"></i> detail
                            </a>
                            <a href="<?php echo BASEURL?>Gaji/finishingdetail/<?php echo $g['id'] ?>?&excel=1" class="btn btn-xs btn-success">
                                <i class="fa fa-file-excel-o"></i> excel
                            </a>
                            <a href="<?php echo BASEURL?>Gaji/finishingdetail/<?php echo $g['id'] ?>?&pdf=1" class="btn btn-xs btn-danger">
                                <i class="fa fa-file-pdf-o"></i> pdf
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada riwayat gaji yang disimpan.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
