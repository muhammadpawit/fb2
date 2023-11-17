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
                        <th>Kode PO</th>
                        <th>CMT</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($prods as $c){ ?>
                        <tr>
                            <td><?php echo $no++?></td>
                            <td><?php echo $c['kode_po']?></td>
                            <td><?php echo $c['namacmt']?></td>
                            <td><?php echo number_format($c['pcs']/12,2)?></td>
                            <td><?php echo number_format($c['pcs'])?></td>
                            <td>
                              <a href="<?php echo $link ?>detail/<?php echo $c['id']?>" class="btn btn-xs btn-info">Terima QTY</a>
                              <a href="<?php echo $link ?>edit/<?php echo $c['id']?>" class="btn btn-xs btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>