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
<form method="get" action="<?php echo BASEURL.'Bukubesar/jurnalumum' ?>">
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="date" name="tgl1" class="form-control" value="<?php echo $tgl1 ?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="date" name="tgl2" class="form-control" value="<?php echo $tgl2 ?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group text-right">
			<br>
			<button type="submit" class="btn btn-info">Filter</button>
			<a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Jurnal</a>
		</div>
	</div>
</div>
</form>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Jurnal</th>
              <th>Keterangan</th>
              <th>Total Debit</th>
              <th>Total Kredit</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
              <td><?php echo $r['no_jurnal'] ?></td>
              <td><?php echo $r['keterangan'] ?></td>
              <td align="right"><?php echo number_format((float)$r['total_debit'], 2) ?></td>
              <td align="right"><?php echo number_format((float)$r['total_kredit'], 2) ?></td>
              <td>
                <a href="<?php echo BASEURL.'Bukubesar/jurnalumum_detail/'.$r['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</a>
                <?php if(empty($r['ref'])): ?>
                  <a href="<?php echo BASEURL.'Bukubesar/jurnalumum_delete/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jurnal ini?')"><i class="fa fa-trash"></i></a>
                <?php else: ?>
                  <span class="badge badge-warning" title="Jurnal Otomatis (Tidak bisa dihapus manual)">Auto</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
