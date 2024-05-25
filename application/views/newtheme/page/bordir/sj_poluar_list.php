<div class="row">
  <div class="col-md-4">
    <label for="">Aksi</label><br>
    <a href="<?php echo $tambah ?>" class="btn btn-sm btn-info">Tambah</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
            <table class="table table-bordered table-hover yessearch">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Kepada</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p) { ?>
                  <tr>
                    <td><?php echo date('d-m-Y',strtotime($p['tanggal'])) ?></td>
                    <td><?php echo strtolower($p['kepada']) ?></td>
                    <td><?php echo strtolower($p['keterangan']) ?></td>
                    <td>
                      <a class="btn btn-xs btn-warning" href="<?php echo BASEURL?>Bordir/suratjalanpoluar_detail/<?php echo $p['id']?>">Detail</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
  </div>
</div>