<!-- Modal Structure -->
<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog" aria-labelledby="rekapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekapModalLabel">Rekap Insentif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Rekap Data will be inserted here dynamically -->
                <div id="rekap-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
    </div>
  </div>
  <div class="col-md-3" hidden>
    <div class="form-group">
      <label>Nama</label>
      <select name="sj" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($nosj as $c){?>
          <option value="<?php echo $c['id']?>"  <?php echo $c['id']==$sj?'selected':'';?>><?php echo strtoupper($c['nama'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <!-- <div class="col-md-3">
    <div class="form-group">
      <label>Nama CMT</label>
      <select name="cmt" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($listcmt as $c){?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
        <?php } ?>
      </select>
    </div>
  </div> -->
  <div class="col-md-4">
    <label>Aksi</label><br>
    <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
    <button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>
    <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm">Tambah</a>
    <button class="btn btn-info btn-sm" onclick="rekap()">Rekap</button>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Hari / Tanggal</th>
                          <th>Kedisiplinan</th>
                          <th>Kebersihan</th>
                          <th>Kontrol Video Call</th>
                          <th>Foto Per 2 Jam</th>
                          <th>Ketentuan</th>
                          <th>Potongan</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;$total=0; ?>
                        <?php foreach($karyawan as $p){ ?>
                          <tr>
                            <td><?php echo $no?></td>
                            <td><?php echo $p['nama']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php $tp=0;?>
                            <?php foreach($p['products'] as $p){?>
                              <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo $p['tanggal']?></td>
                                <td><?php echo $p['kedisiplinan']?></td>
                                <td><?php echo $p['kebersihan']?></td>
                                <td><?php echo $p['kontrol_vc']?></td>
                                <td><?php echo $p['foto']?></td>
                                <td><?php echo $p['ketentuan']?></td>
                                <td><?php echo number_format($p['totalpotongan'])?></td>
                                <td>
                                  <?php if(akseshapus()==1){ ?>
                                    <a href="<?php echo $p['hapus']?>" onclick="return confirm('Apakah yakin?')" class="btn btn-xs btn-danger">Hapus</a>
                                  <?php } ?>
                                </td>
                              </tr>
                              <?php 
                                $total+=($p['totalpotongan']);
                                $tp+=($p['totalpotongan']);
                              ?>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td colspan="8" align="right"><b>Total</b></td>
                            <td><?php echo number_format($tp) ?></td>
                            <td></td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="8" align="right"><b>Total Keseluruhan</b></td>
                          <td><?php echo number_format($total) ?></td>
                          <td></td>
                        </tr>
                      </tfoot>
                   </table>
  </div>
</div>
<script>
  function rekap() {
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();

    $.ajax({
        url: '<?php echo BASEURL?>Insentifsecurity/rekap', // Ganti dengan URL yang sesuai
        type: 'POST', // atau POST, tergantung endpoint Anda
        data:{
          tanggal1:tanggal1,
          tanggal2:tanggal2
        },
        // dataType: 'json',
        success: function(response) {
            // Asumsikan response adalah objek JSON yang berisi data rekap.
            
            // Sisipkan data ke dalam modal
            $('#rekap-content').html(response);

            // Tampilkan modal
            $('#rekapModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Tangani jika terjadi error
            alert('Terjadi kesalahan saat mengambil data: ' + error);
        }
    });
}

</script>