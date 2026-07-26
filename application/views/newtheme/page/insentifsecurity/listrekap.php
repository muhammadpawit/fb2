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
                            <button type="button" class="btn btn-info btn-sm" onclick="editTglLapKeu('<?php echo $r['tanggal1']; ?>', '<?php echo $r['tanggal2']; ?>', '<?php echo $r['tanggal_lap_keu']; ?>')">Edit Tgl</button>
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
</div>

<!-- Modal Edit Tanggal Laporan Keuangan -->
<div class="modal fade" id="editTglLapKeuModal" tabindex="-1" role="dialog" aria-labelledby="editTglLapKeuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo BASEURL?>Insentifsecurity/edit_tanggal_lap_keu">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTglLapKeuModalLabel">Edit Tanggal Laporan Keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tanggal1" id="edit_tanggal1" style="display:none;">
                    <input type="hidden" name="tanggal2" id="edit_tanggal2" style="display:none;">
                    <div class="form-group">
                        <label>Tanggal Laporan Keuangan</label>
                        <input type="text" name="tanggal_lap_keu" id="edit_tanggal_lap_keu" class="form-control datepicker" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function editTglLapKeu(tgl1, tgl2, tglLapKeu) {
    $('#edit_tanggal1').val(tgl1);
    $('#edit_tanggal2').val(tgl2);
    $('#edit_tanggal_lap_keu').val(tglLapKeu);
    $('#editTglLapKeuModal').modal('show');
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}
</script>
