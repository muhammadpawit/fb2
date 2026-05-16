<div class="row">
  <div class="col-md-12 text-right">
    <?php if(isset($tambah)): ?>
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Transaksi</a>
    <?php endif; ?>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Transaksi</th>
              <th>Akun Kas/Bank</th>
              <th>Tipe</th>
              <th>Total</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($results)): ?>
              <?php foreach($results as $r): ?>
              <tr>
                <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                <td><?php echo $r['no_transaksi'] ?></td>
                <td><?php echo $r['nama_kas'] ?></td>
                <td>
                  <span class="badge <?php echo $r['tipe'] == 'MASUK' ? 'bg-green' : 'bg-red' ?>">
                    <?php echo $r['tipe'] ?>
                  </span>
                </td>
                <td align="right"><?php echo number_format($r['total'], 2) ?></td>
                <td><?php echo $r['keterangan'] ?></td>
                <td>
                  <a href="<?php echo BASEURL.'Manajemenkasbank/masuk_keluar_delete/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data transaksi.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
