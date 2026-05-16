<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Laporan Arus Kas</h3>
      </div>
      <div class="card-body">
        <form method="get" action="<?php echo BASEURL.'Pelaporankeuangan/aruskas' ?>">
        <div class="row">
          <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="tgl1" class="form-control" value="<?php echo $tgl1 ?>">
          </div>
          <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="tgl2" class="form-control" value="<?php echo $tgl2 ?>">
          </div>
          <div class="col-md-2">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">Filter</button>
          </div>
        </div>
        </form>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered">
              <tr style="background-color: #eee;">
                <th colspan="2">ARUS KAS DARI AKTIVITAS OPERASIONAL</th>
              </tr>
              <?php 
                $total_operating = 0;
                foreach($operating as $o): 
                  $total_operating += $o['total'];
              ?>
              <tr>
                <td><?php echo $o['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$o['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold;">
                <td>Total Arus Kas Aktivitas Operasional</td>
                <td align="right"><?php echo number_format($total_operating, 2) ?></td>
              </tr>

              <tr><td colspan="2">&nbsp;</td></tr>

              <tr style="background-color: #eee;">
                <th colspan="2">ARUS KAS DARI AKTIVITAS INVESTASI</th>
              </tr>
              <?php 
                $total_investing = 0;
                foreach($investing as $i): 
                  $total_investing += $i['total'];
              ?>
              <tr>
                <td><?php echo $i['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$i['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold;">
                <td>Total Arus Kas Aktivitas Investasi</td>
                <td align="right"><?php echo number_format($total_investing, 2) ?></td>
              </tr>

              <tr><td colspan="2">&nbsp;</td></tr>

              <tr style="background-color: #eee;">
                <th colspan="2">ARUS KAS DARI AKTIVITAS PENDANAAN</th>
              </tr>
              <?php 
                $total_financing = 0;
                foreach($financing as $f): 
                  $total_financing += $f['total'];
              ?>
              <tr>
                <td><?php echo $f['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$f['total'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold;">
                <td>Total Arus Kas Aktivitas Pendanaan</td>
                <td align="right"><?php echo number_format($total_financing, 2) ?></td>
              </tr>

              <tr><td colspan="2">&nbsp;</td></tr>

              <tr style="font-weight: bold; background-color: #f4f4f4; font-size: 1.2em;">
                <td>KENAIKAN / (PENURUNAN) KAS BERSIH</td>
                <td align="right"><?php echo number_format($total_operating + $total_investing + $total_financing, 2) ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
