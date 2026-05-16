<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Vendor</a>
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
              <th>No</th>
              <th>Nama Vendor</th>
              <th>Alamat</th>
              <th>Telepon</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($results as $r): ?>
            <tr>
              <td><?php echo $no++ ?></td>
              <td><?php echo $r['nama'] ?></td>
              <td><?php echo $r['alamat'] ?></td>
              <td><?php echo $r['telephone'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
