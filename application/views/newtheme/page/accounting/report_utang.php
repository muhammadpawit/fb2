<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Buku Tambahan Utang</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Vendor</th>
              <th>Total Hutang</th>
              <th>Total Terbayar</th>
              <th>Sisa Hutang</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo $r['nama_supplier'] ?></td>
              <td align="right"><?php echo number_format($r['total_hutang'], 2) ?></td>
              <td align="right"><?php echo number_format($r['total_bayar'], 2) ?></td>
              <td align="right"><?php echo number_format($r['total_hutang'] - $r['total_bayar'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
