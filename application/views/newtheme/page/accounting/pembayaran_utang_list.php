<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Bayar</th>
              <th>Supplier</th>
              <th>Total Bayar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
              <td><?php echo $r['no_bayar'] ?></td>
              <td><?php echo $r['id_supplier'] ?></td>
              <td align="right"><?php echo number_format($r['total_bayar'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
