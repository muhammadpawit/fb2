<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Aset</a>
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
              <th>Kode</th>
              <th>Nama Aset</th>
              <th>Tgl Perolehan</th>
              <th>Harga Perolehan</th>
              <th>Masa Manfaat</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo $r['kode_aset'] ?></td>
              <td><?php echo $r['nama_aset'] ?></td>
              <td><?php echo date('d/m/Y', strtotime($r['tgl_perolehan'])) ?></td>
              <td align="right"><?php echo number_format($r['harga_perolehan'], 2) ?></td>
              <td><?php echo $r['masa_manfaat'] ?> Bulan</td>
              <td><?php echo $r['status'] ?></td>
              <td>
                <a href="<?php echo BASEURL.'Aset/disposal_add/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin melepas aset ini?')"><i class="fa fa-trash"></i> Lepas</a>
                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
