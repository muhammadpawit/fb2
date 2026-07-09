<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Buat Rekonsiliasi Baru</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Akun Bank</th>
              <th>Saldo Sistem (A)</th>
              <th>Saldo Rek. Koran (B)</th>
              <th>Selisih (B - A)</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($results)): ?>
              <?php foreach($results as $r): ?>
              <tr>
                <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                <td><?php echo $r['nama_kas'] ?></td>
                <td align="right"><?php echo number_format($r['saldo_sistem'], 2) ?></td>
                <td align="right"><?php echo number_format($r['saldo_bank'], 2) ?></td>
                <td align="right" class="<?php echo $r['selisih'] != 0 ? 'text-danger font-weight-bold' : '' ?>">
                  <?php echo number_format($r['selisih'], 2) ?>
                </td>
                <td><?php echo $r['keterangan'] ?></td>
                <td>
                  <?php if($r['selisih'] == 0): ?>
                    <span class="badge badge-success">Balanced</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Unbalanced</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="<?php echo BASEURL.'Manajemenkasbank/rekonsiliasi_delete/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data rekonsiliasi ini?')"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center">Belum ada histori rekonsiliasi.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
