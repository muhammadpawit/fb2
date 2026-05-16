<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Laporan Laba Rugi</h3>
      </div>
      <div class="card-body">
        <form method="get" action="<?php echo BASEURL.'Pelaporankeuangan/laba_rugi' ?>">
        <div class="row">
          <div class="col-md-3">
            <input type="date" name="tgl1" class="form-control" value="<?php echo $tgl1 ?>">
          </div>
          <div class="col-md-3">
            <input type="date" name="tgl2" class="form-control" value="<?php echo $tgl2 ?>">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-info">Filter</button>
          </div>
        </div>
        </form>
        <hr>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <h4 class="text-center">Laporan Laba Rugi</h4>
            <p class="text-center"><?php echo date('d M Y', strtotime($tgl1)) ?> - <?php echo date('d M Y', strtotime($tgl2)) ?></p>
            <br>
            <table class="table table-borderless">
              <tr style="background-color: #f4f4f4; font-weight: bold;">
                <th colspan="2">PENDAPATAN</th>
              </tr>
              <?php 
                $total_pendapatan = 0;
                foreach($pendapatan as $p): 
                  $total_pendapatan += $p['total'];
              ?>
              <tr>
                <td><?php echo $p['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$p['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold; border-top: 2px solid #000;">
                <td>TOTAL PENDAPATAN</td>
                <td align="right"><?php echo number_format($total_pendapatan, 2) ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr style="background-color: #f4f4f4; font-weight: bold;">
                <th colspan="2">BEBAN</th>
              </tr>
              <?php 
                $total_beban = 0;
                foreach($beban as $b): 
                  $total_beban += $b['total'];
              ?>
              <tr>
                <td><?php echo $b['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$b['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold; border-top: 2px solid #000;">
                <td>TOTAL BEBAN</td>
                <td align="right"><?php echo number_format($total_beban, 2) ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr style="background-color: #007bff; color: #fff; font-weight: bold;">
                <th>LABA / RUGI BERSIH</th>
                <th style="text-align: right;"><?php echo number_format($total_pendapatan - $total_beban, 2) ?></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
