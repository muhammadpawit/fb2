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
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title; ?></h3>
        <div class="card-tools">
          <a href="<?php echo BASEURL.'Kabon/potongan_warteg_add';?>" class="btn btn-info btn-sm">Tambah Data</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="example1">
          <thead>
            <tr>
              <th>No</th>
              <th>Karyawan</th>
              <th>Tanggal</th>
              <th>Nominal</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($potongan as $p){ ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $p['nama_karyawan']; ?></td>
              <td><?php echo date('d-m-Y', strtotime($p['tanggal'])); ?></td>
              <td><?php echo number_format($p['nominal'], 0, ',', '.'); ?></td>
              <td><?php echo $p['keterangan']; ?></td>
              <td>
                <a href="<?php echo BASEURL.'Kabon/potongan_warteg_edit/'.$p['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?php echo BASEURL.'Kabon/potongan_warteg_delete/'.$p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data ini?')">Hapus</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
