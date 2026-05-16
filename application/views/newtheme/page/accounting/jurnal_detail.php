<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail Jurnal: <?php echo $header['no_jurnal'] ?></h3>
        <div class="card-tools no-print">
          <button type="button" class="btn btn-default btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
          <a href="<?php echo BASEURL.'Bukubesar/jurnalumum' ?>" class="btn btn-danger btn-sm">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <th width="30%">No. Jurnal</th>
                <td>: <?php echo $header['no_jurnal'] ?></td>
              </tr>
              <tr>
                <th>Tanggal</th>
                <td>: <?php echo date('d/m/Y', strtotime($header['tanggal'])) ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <th width="30%">Keterangan</th>
                <td>: <?php echo $header['keterangan'] ?></td>
              </tr>
            </table>
          </div>
        </div>
        <br>
        <table class="table table-bordered">
          <thead>
            <tr style="background-color: #f4f4f4;">
              <th>Kode Akun</th>
              <th>Nama Akun</th>
              <th>Keterangan</th>
              <th class="text-right">Debit</th>
              <th class="text-right">Kredit</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($details as $d): ?>
            <tr>
              <td><?php echo $d['kode_akun'] ?></td>
              <td><?php echo $d['nama_akun'] ?></td>
              <td><?php echo $d['keterangan'] ?></td>
              <td align="right"><?php echo number_format($d['debit'], 2) ?></td>
              <td align="right"><?php echo number_format($d['kredit'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr style="font-weight: bold; background-color: #f4f4f4;">
              <td colspan="3" align="center">TOTAL</td>
              <td align="right"><?php echo number_format($header['total_debit'], 2) ?></td>
              <td align="right"><?php echo number_format($header['total_kredit'], 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
