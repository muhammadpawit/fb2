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
      <input type="text" name="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>No.SJ</label>
      <select name="sj" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($nosj as $c){?>
          <option value="<?php echo $c['id']?>"  <?php echo $c['id']==$sj?'selected':'';?>><?php echo strtoupper($c['nosj'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama CMT</label>
      <select name="cmt" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($listcmt as $c){?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <label>Aksi</label><br>
    <button class="btn btn-info btn-sm" onclick="filterwithcmt()">Filter</button>
    <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm">Tambah</a>
    <button class="btn btn-danger btn-sm" onclick="cetak_pdf()">Cetak PDF</button>
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
                          <tr>
                            <td><?php echo $no++?></td>
                            <td><?php echo $p['nosj']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['namacmt']?></td>
                            <td><?php echo $d['jumlah_pcs']?></td>
                            <td><?php echo isset($po['kode_po'])?$po['kode_po']:''?></td>
                            <td><?php echo $p['status']?></td>
                         <td class="right"><?php foreach ($p['action'] as $action) { ?>
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
    var url = '<?php echo $url ?>';
    
    // Check if we are in sablon or cmt
    var is_sablon = '<?php echo isset($sablon) ? 1 : 0 ?>';
    var cetak_url = '';
    
    if(is_sablon == 1){
        cetak_url = '<?php echo BASEURL ?>Kelolapo/pengirimansablon_pdf';
    } else {
        cetak_url = '<?php echo BASEURL ?>Kelolapo/pengirimancmt_pdf';
    }

    var final_url = cetak_url + '?tanggal1=' + tanggal1 + '&tanggal2=' + tanggal2 + '&sj=' + sj + '&cmt=' + cmt;
    showPdfModal(final_url, 'Laporan Pengiriman');
  }

  function filterwithcmt(){
    var tanggal1 = $('input[name="tanggal1"]').val();
    var tanggal2 = $('input[name="tanggal2"]').val();
    var sj = $('select[name="sj"]').val();
    var cmt = $('select[name="cmt"]').val();
    var url = '<?php echo $url ?>';
    
    location = url + '?tanggal1=' + tanggal1 + '&tanggal2=' + tanggal2 + '&sj=' + sj + '&cmt=' + cmt;
  }
</script>