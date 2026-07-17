<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Supplier</label>
              <input type="text" class="form-control" value="<?php echo $tagihan['nama_supplier'] ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>No. Invoice Vendor</label>
              <input type="text" class="form-control" value="<?php echo $tagihan['no_invoice'] ?>" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tanggal Tagihan</label>
              <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($tagihan['tanggal'])) ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Jatuh Tempo</label>
              <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($tagihan['jatuh_tempo'])) ?>" readonly>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <h4>Daftar Item</h4>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Sumber</th>
                    <th>Nama Item</th>
                    <th>Qty</th>
                    <th>Nominal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($details as $d): ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $d['tanggal_item'] ? date('d/m/Y', strtotime($d['tanggal_item'])) : '-' ?></td>
                    <td><?php echo $d['sumber'] ?></td>
                    <td><?php echo $d['nama_item'] ?></td>
                    <td><?php echo $d['jumlah'] . ' ' . $d['satuan'] ?></td>
                    <td align="right">Rp. <?php echo number_format($d['nominal']) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5" align="center"><b>Total</b></td>
                    <td align="right"><b>Rp. <?php echo number_format($tagihan['total']) ?></b></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="form-group mt-3">
          <label>Keterangan</label>
          <textarea class="form-control" rows="3" readonly><?php echo $tagihan['keterangan'] ?></textarea>
        </div>
        <div class="form-group">
          <label>Status</label><br>
          <?php if($tagihan['status'] == 1): ?>
            <span class="badge badge-success" style="font-size: 14px;">Paid (Lunas)</span>
          <?php else: ?>
            <span class="badge badge-warning" style="font-size: 14px;">Open (Belum Lunas)</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-footer text-right">
        <a href="<?php echo $batal ?>" class="btn btn-secondary">Kembali</a>
      </div>
    </div>
  </div>
</div>
