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
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Akun</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Kode Akun</th>
              <th>Nama Akun</th>
              <th>Tipe</th>
              <th>Saldo Normal</th>
              <th>Header?</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr style="<?php echo $r['is_header'] == 1 ? 'font-weight:bold; background-color:#f4f4f4;' : '' ?>">
              <td><?php echo $r['kode_akun'] ?></td>
              <td><?php echo str_repeat('&nbsp;&nbsp;', $r['id_induk'] > 0 ? 1 : 0) . $r['nama_akun'] ?></td>
              <td><?php echo $r['tipe'] ?></td>
              <td><?php echo $r['saldo_normal'] ?></td>
              <td><?php echo $r['is_header'] == 1 ? 'Yes' : 'No' ?></td>
              <td>
                <a href="<?php echo BASEURL.'Bukubesar/coa_edit/'.$r['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                <a href="<?php echo BASEURL.'Bukubesar/coa_delete/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus akun ini?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
