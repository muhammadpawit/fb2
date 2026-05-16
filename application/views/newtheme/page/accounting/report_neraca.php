<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Laporan Neraca</h3>
      </div>
      <div class="card-body">
        <form method="get" action="<?php echo BASEURL.'Pelaporankeuangan/neraca' ?>">
        <div class="row">
          <div class="col-md-3">
            <input type="date" name="tgl" class="form-control" value="<?php echo $tgl ?>">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-info">Filter</button>
          </div>
        </div>
        </form>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <h4 class="text-center">AKTIVA (ASET)</h4>
            <table class="table table-sm">
              <?php 
                $total_aset = 0;
                foreach($aset as $a): 
                  $total_aset += $a['total'];
              ?>
              <tr>
                <td><?php echo $a['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$a['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold; background-color: #f4f4f4;">
                <td>TOTAL AKTIVA</td>
                <td align="right"><?php echo number_format($total_aset, 2) ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h4 class="text-center">PASIVA (KEWAJIBAN & EKUITAS)</h4>
            <table class="table table-sm">
              <tr style="background-color: #eee;"><th colspan="2">KEWAJIBAN</th></tr>
              <?php 
                $total_kewajiban = 0;
                foreach($kewajiban as $k): 
                  $total_kewajiban += $k['total'];
              ?>
              <tr>
                <td><?php echo $k['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$k['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="background-color: #eee;"><th colspan="2">EKUITAS</th></tr>
              <?php 
                $total_ekuitas = 0;
                foreach($ekuitas as $e): 
                  $total_ekuitas += $e['total'];
              ?>
              <tr>
                <td><?php echo $e['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$e['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold; background-color: #f4f4f4;">
                <td>TOTAL PASIVA</td>
                <td align="right"><?php echo number_format($total_kewajiban + $total_ekuitas, 2) ?></td>
              </tr>
            </table>
          </div>
        </div>
        <?php if(abs($total_aset - ($total_kewajiban + $total_ekuitas)) > 0.01): ?>
          <div class="alert alert-danger mt-3">
            <strong>Warning!</strong> Neraca tidak balance. Selisih: <?php echo number_format($total_aset - ($total_kewajiban + $total_ekuitas), 2) ?>
          </div>
        <?php else: ?>
          <div class="alert alert-success mt-3">
            <strong>Success!</strong> Neraca balance.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
