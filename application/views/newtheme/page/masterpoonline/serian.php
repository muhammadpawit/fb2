<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="<?php echo $action ?>" class="btn btn-sm btn-primary">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered table-hover yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Serian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($prods as $c){ ?>
                        <tr>
                            <td><?php echo $no++?></td>
                            <td><?php echo $c['nama']?></td>
                            <td>
                              <a href="<?php echo $link ?>editserian/<?php echo $c['id']?>" class="btn btn-xs btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>