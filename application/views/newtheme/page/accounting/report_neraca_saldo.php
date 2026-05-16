<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Neraca Saldo</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>Kode Akun</th>
              <th>Nama Akun</th>
              <th>Debit</th>
              <th>Kredit</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $total_debit = 0;
              $total_kredit = 0;
              foreach($results as $r): 
                $total_debit += $r['debit'];
                $total_kredit += $r['kredit'];
            ?>
            <tr>
              <td><?php echo $r['kode_akun'] ?></td>
              <td><?php echo $r['nama_akun'] ?></td>
              <td align="right"><?php echo number_format((float)$r['debit'], 2) ?></td>
              <td align="right"><?php echo number_format((float)$r['kredit'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr style="font-weight: bold; background-color: #f4f4f4;">
              <td colspan="2" align="center">TOTAL</td>
              <td align="right"><?php echo number_format($total_debit, 2) ?></td>
              <td align="right"><?php echo number_format($total_kredit, 2) ?></td>
            </tr>
          </tfoot>
        </table>
        
        <?php if(abs($total_debit - $total_kredit) > 0.01): ?>
          <div class="alert alert-danger mt-3">
            <strong>Warning!</strong> Neraca Saldo tidak balance. Selisih: <?php echo number_format($total_debit - $total_kredit, 2) ?>
          </div>
        <?php else: ?>
          <div class="alert alert-success mt-3">
            <strong>Success!</strong> Neraca Saldo balance.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
