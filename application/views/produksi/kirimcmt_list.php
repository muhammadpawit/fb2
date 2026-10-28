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
      <?php if ($this->session->flashdata('gagal')) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <?php echo $this->session->flashdata('gagal'); ?> 
        </div>
      <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>No.SJ</label>
      <select name="sj" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($nosj as $c){?>
          <option value="<?php echo $c['id']?>"  <?php echo $c['id']==$sj?'selected':'';?>><?php echo strtoupper($c['nosj'] ?? '')?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Nama CMT</label>
      <select name="cmt" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($listcmt as $c){?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':'';?>><?php echo strtolower($c['cmt_name'] ?? '')?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Kode PO</label>
      <select name="kodepo" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php if(isset($listpo)) { foreach($listpo as $p){ ?>
          <option value="<?php echo $p['id_produksi_po']?>" <?php echo (isset($kodepo) && ($kodepo==$p['id_produksi_po'] || $kodepo==$p['kode_po']))?'selected':'';?>><?php echo $p['kode_po']?></option>
        <?php } } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <label>Aksi</label><br>
    <button type="button" class="btn btn-info btn-sm" onclick="filterKirimCmt()">Filter</button>
    <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm">Tambah</a>
    <button type="button" class="btn btn-danger btn-sm" onclick="cetak_pdf()">Cetak PDF</button>
    <?php if (!isset($sablon)) { ?>
      <a href="<?php echo BASEURL . 'Kelolapo/sync_kirimcmt_all'; ?>" class="btn btn-warning btn-sm mt-1" title="Sinkronkan semua data pengiriman yang belum masuk ke Monitoring" onclick="return confirm('Apakah Anda yakin ingin menyinkronkan semua data pengiriman jahit yang belum masuk ke tabel kelolapo_kirim_setor?')"><i class="fa fa-refresh"></i> Sync All</a>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>No.SJ</th>
                          <th>Tanggal</th>
                          <th>Nama CMT</th>
                          <th>Quantity</th>
                          <th>PO</th>
                          <th>Status</th>
                          <?php if(!isset($sablon)){ ?>
                            <th class="text-center">Monitoring</th>
                          <?php } ?>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; ?>
                        <?php foreach($products as $p){?>
                          <?php foreach($p['dets'] as $d){?>
                            <?php 
                              if(isset($sablon)){
                                $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['idpo']));
                              } else if(isset($sablonluar)){
                                $po = $this->GlobalModel->QueryManualRow("SELECT nama as kode_po FROM master_po_luar WHERE id='".$d['kode_po']."' ");
                              } else {
                                $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['kode_po']));
                              } 
                            ?>
                          <tr <?php if(!isset($sablon) && isset($d['is_synced']) && !$d['is_synced']){ echo 'style="background-color: #fff9e6;"'; } ?>>
                            <td><?php echo $no++?></td>
                            <td><?php echo $p['nosj']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['namacmt']?></td>
                            <td><?php echo $d['jumlah_pcs']?></td>
                            <td><?php echo isset($po['kode_po'])?$po['kode_po']:''?></td>
                            <td>
                              <?php echo $p['status']?>
                              <?php 
                                $cek_dis = $this->GlobalModel->queryManualRow("SELECT k2.nosj FROM kirimcmt_detail kd2 JOIN kirimcmt k2 ON k2.id=kd2.idkirim WHERE k2.nosj LIKE 'SJDIS%' AND kd2.kode_po='".$d['kode_po']."' AND kd2.hapus=0 AND k2.hapus=0 LIMIT 1");
                                if(!empty($cek_dis)){
                              ?>
                                <br><span class="badge badge-success" title="Sudah didistribusikan via <?php echo $cek_dis['nosj']?>"><i class="fa fa-check-circle"></i> Didistribusikan</span>
                              <?php } ?>
                            </td>
                            <?php if(!isset($sablon)){ ?>
                              <td class="text-center" style="white-space: nowrap;">
                                <?php if(!empty($d['is_synced'])){ ?>
                                  <span class="badge badge-success"><i class="fa fa-check-circle"></i> Tersinkron</span>
                                <?php } else { ?>
                                  <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> Belum Masuk</span>
                                  <br>
                                  <a href="<?php echo BASEURL.'Kelolapo/sync_kirimcmt_detail/'.$d['id']; ?>" class="btn btn-xs btn-warning mt-1" title="Sinkronkan PO ini ke kelolapo_kirim_setor" onclick="return confirm('Sinkronkan item PO ini ke tabel kelolapo_kirim_setor?')"><i class="fa fa-refresh"></i> Sync</a>
                                <?php } ?>
                              </td>
                            <?php } ?>
                         <td class="right">
                            <?php if (!isset($sablon) && !empty($p['has_unsynced'])) { ?>
                                <a href="<?php echo BASEURL.'Kelolapo/sync_kirimcmt/'.$p['id']; ?>" style="background-color: #17a2b8;" class="badge waves-light waves-effect" title="Sinkronkan seluruh Surat Jalan ini ke Monitoring" onclick="return confirm('Sinkronkan semua item pada Surat Jalan ini ke kelolapo_kirim_setor?')"><i class="fa fa-refresh"></i> Sync SJ</a>&nbsp;&nbsp;
                            <?php } ?>
                            <?php foreach ($p['action'] as $action) { ?>
                            <?php if (strtolower($action['text']) === 'hapus') { ?>
                                <a href="<?php echo BASEURL.'Kelolapo/kirimcmtdetailhapus/'.$d['id']; ?>" style="background-color: <?php echo $action['bg']; ?>" class="badge waves-light waves-effect" onclick="return confirm('Apakah Anda yakin ingin menghapus rincian ini?')">Hapus Item</a>&nbsp;&nbsp;
                                <a href="<?php echo $action['href']; ?>" style="background-color: <?php echo $action['bg']; ?>" class="badge waves-light waves-effect" onclick="return confirm('Apakah Anda yakin ingin menghapus satu surat jalan secara bersamaan? ')">Hapus SJ</a>&nbsp;&nbsp;
                            <?php } else if (strtolower($action['text']) === 'cetak') { ?>
                                <a href="javascript:void(0)" onclick="showPdfModal('<?php echo $action['href']; ?>', 'Cetak Surat Jalan')" style="background-color: <?php echo $action['bg']; ?>" class="badge waves-light waves-effect"><?php echo $action['text']; ?></a>&nbsp;&nbsp;
                            <?php } else { ?>
                                <a href="<?php echo $action['href']; ?>" style="background-color: <?php echo $action['bg']; ?>" class="badge waves-light waves-effect"><?php echo $action['text']; ?></a>&nbsp;&nbsp;
                            <?php } ?>
                        <?php } ?></td>

                        </tr>
                        <?php } ?>
                      <?php } ?>
                    </tbody>
                 </table>
  </div>
</div>
<script type="text/javascript">
  function cetak_pdf(){
    var tanggal1 = $('input[name="tanggal1"]').val();
    var tanggal2 = $('input[name="tanggal2"]').val();
    var sj = $('select[name="sj"]').val();
    var cmt = $('select[name="cmt"]').val();
    var kodepo = $('select[name="kodepo"]').val();
    var url = '<?php echo $url ?>';
    
    // Check if we are in sablon or cmt
    var is_sablon = '<?php echo isset($sablon) ? 1 : 0 ?>';
    var cetak_url = '';
    
    if(is_sablon == 1){
        cetak_url = '<?php echo BASEURL ?>Kelolapo/pengirimansablon_pdf';
    } else {
        cetak_url = '<?php echo BASEURL ?>Kelolapo/pengirimancmt_pdf';
    }

    var params = [];
    if (tanggal1) params.push('tanggal1=' + encodeURIComponent(tanggal1));
    if (tanggal2) params.push('tanggal2=' + encodeURIComponent(tanggal2));
    if (sj && sj !== '*') params.push('sj=' + encodeURIComponent(sj));
    if (cmt && cmt !== '*') params.push('cmt=' + encodeURIComponent(cmt));
    if (kodepo && kodepo !== '*') params.push('kodepo=' + encodeURIComponent(kodepo));

    var separator = cetak_url.indexOf('?') !== -1 ? '&' : '?';
    var final_url = cetak_url + (params.length ? separator + params.join('&') : '');
    showPdfModal(final_url, 'Laporan Pengiriman');
  }

  function filterKirimCmt(){
    var tanggal1 = $('input[name="tanggal1"]').val();
    var tanggal2 = $('input[name="tanggal2"]').val();
    var sj = $('select[name="sj"]').val();
    var cmt = $('select[name="cmt"]').val();
    var kodepo = $('select[name="kodepo"]').val();
    var url = '<?php echo $url ?>';
    
    var params = [];
    if (tanggal1) params.push('tanggal1=' + encodeURIComponent(tanggal1));
    if (tanggal2) params.push('tanggal2=' + encodeURIComponent(tanggal2));
    if (sj && sj !== '*') params.push('sj=' + encodeURIComponent(sj));
    if (cmt && cmt !== '*') params.push('cmt=' + encodeURIComponent(cmt));
    if (kodepo && kodepo !== '*') params.push('kodepo=' + encodeURIComponent(kodepo));

    var separator = url.indexOf('?') !== -1 ? '&' : '?';
    window.location.href = url + (params.length ? separator + params.join('&') : '');
  }
</script>