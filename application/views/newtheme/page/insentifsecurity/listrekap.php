<div class="row">
  <div class="col-md-12">
      <?php if ($this->session->flashdata('msg')) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <?php echo $this->session->flashdata('msg'); ?> 
        </div>
      <?php } ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">List Rekap Insentif Security</h3>
        </div>
        <div class="box-body">
            <a href="<?php echo BASEURL?>Insentifsecurity" class="btn btn-warning mb-3">Kembali</a>
            <br><br>
            <table class="table table-bordered table-striped yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Tanggal Lap. Keuangan</th>
                        <th>Total Insentif Dibagikan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($rekap as $r): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($r['tanggal1'])) . ' s/d ' . date('d-m-Y', strtotime($r['tanggal2'])); ?></td>
                        <td><?php echo !empty($r['tanggal_lap_keu']) ? date('d-m-Y', strtotime($r['tanggal_lap_keu'])) : '-'; ?></td>
                        <td>Rp <?php echo number_format($r['grand_total']); ?></td>
                        <td>
                            <a href="<?php echo BASEURL?>Insentifsecurity/pdf/<?php echo $r['tanggal1']?>/<?php echo $r['tanggal2']?>" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                            <a href="<?php echo BASEURL?>Insentifsecurity/hapusrekap/<?php echo $r['tanggal1']?>/<?php echo $r['tanggal2']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data rekap ini?');" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
