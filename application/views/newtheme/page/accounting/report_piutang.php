<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Buku Tambahan Piutang</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Total Piutang</th>
              <th>Total Diterima</th>
              <th>Sisa Piutang</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo $r['nama_customer'] ?></td>
              <td align="right"><?php echo number_format($r['total_piutang'], 2) ?></td>
              <td align="right"><?php echo number_format($r['total_terima'], 2) ?></td>
              <td align="right"><?php echo number_format($r['total_piutang'] - $r['total_terima'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
