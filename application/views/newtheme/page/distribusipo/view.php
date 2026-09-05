<div class="row">
  <div class="col-md-12 text-right mb-3">
    <a href="<?php echo $kembali?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
    <a href="<?php echo $cetak?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Surat Jalan</a>
    <a href="<?php echo $excel?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</a>
  </div>
</div>

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Detail Surat Jalan Distribusi PO - <strong><?php echo $kirim['nosj']?></strong></h3>
  </div>
  <div class="card-body">
    <table class="table table-bordered mb-4">
      <tr>
        <th width="20%">No. Surat Jalan</th>
        <td width="30%">: <?php echo $kirim['nosj']?></td>
        <th width="20%">CMT Asal</th>
        <td width="30%">: CMT Kantor Sukabumi</td>
      </tr>
      <tr>
        <th>Tanggal Kirim</th>
        <td>: <?php echo date('d-m-Y', strtotime($kirim['tanggal']))?></td>
        <th>CMT Tujuan</th>
        <td>: <?php echo isset($cmt['cmt_name']) ? strtoupper($cmt['cmt_name']) : '-'?></td>
      </tr>
      <tr>
        <th>Supir</th>
        <td>: <?php echo isset($kirim['supir']) ? $kirim['supir'] : '-'?></td>
        <th>Pendamping</th>
        <td>: <?php echo isset($kirim['pendamping']) ? $kirim['pendamping'] : '-'?></td>
      </tr>
      <tr>
        <th>Keterangan</th>
        <td colspan="3">: <?php echo !empty($kirim['keterangan']) ? $kirim['keterangan'] : '-'?></td>
      </tr>
    </table>

    <h5>Rincian PO yang Didistribusikan</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="50">No</th>
            <th>Kode PO</th>
            <th>Pekerjaan</th>
            <th>Rincian PO</th>
            <th>Jumlah Pcs</th>
            <th>Jumlah Barang</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $no = 1; 
            $total_pcs = 0;
            if(!empty($kirims)){
              foreach($kirims as $k){
                $total_pcs += $k['jumlah_pcs'];
          ?>
            <tr>
              <td><?php echo $no++?></td>
              <td><strong><?php echo $k['kode_po']?></strong></td>
              <td><?php echo $k['job']?></td>
              <td><?php echo $k['rincian_po']?></td>
              <td class="text-right"><?php echo number_format($k['jumlah_pcs'])?></td>
              <td><?php echo $k['jml_barang']?></td>
              <td><?php echo $k['keterangan']?></td>
            </tr>
          <?php 
              }
            } else {
          ?>
            <tr>
              <td colspan="7" class="text-center">Tidak ada rincian data PO</td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-right">Total Quantity (Pcs):</th>
            <th class="text-right"><?php echo number_format($total_pcs)?></th>
            <th colspan="2"></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
