<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Terima</th>
              <th>Customer</th>
              <th>Total Terima</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
              <td><?php echo $r['no_terima'] ?></td>
              <td><?php echo $r['id_customer'] ?></td>
              <td align="right"><?php echo number_format($r['total_terima'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
