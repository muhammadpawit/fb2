<div class="row">
    <div class="col-md-12">
        <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>
    </div>
</div>
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" value="<?php echo $tanggal1?>" id="tanggal1" class="form-control">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama PO</label>
      <select class="form-control autopo" name="kode_po" data-live-search="true">
        <option value="*">Pilih</option>
        
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Referensi PO</label>
      <select class="form-control autopo" name="refpo" data-live-search="true">
        <option value="*">Pilih</option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Action</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <a href="<?php echo $tambah; ?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover nosearch">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>KODE PO</th>
                            <th>Referensi PO</th>
                            <th>NAMA PO</th>
                            <th>Dz</th>
                            <th>Pcs</th>
                            <th>TIM POTONG</th>
                            <th>STATUS</th>
                            <th>TANGGAL POTONG</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($potongan as $key => $sat): ?>
                                    <?php if (!empty($sat['kode_po'])) { ?>
                                    <tr>
                                        <td><?php echo $sat['no'] ?></td>
                                        <td><?php echo $sat['kode_po'] ?></td>
                                        <td><?php echo $sat['refpo'] ?></td>
                                        <td><?php echo $sat['nama_po'] ?></td>
                                        <td><?php echo $sat['dz'] ?></td>
                                        <td><?php echo $sat['pcs'] ?></td>
                                        <td><?php if (empty($sat['tim_potong_potongan'] )) { echo 'BELUM'; } else { echo $sat['tim_potong_potongan']; } ?></td>
                                        <th><?php echo $sat['status']?></th>
                                        <td><?php echo (isset($sat['created_date']))?$sat['created_date']:$sat['tanggalProd'] ?></td>
                                        <td class="right"><?php foreach ($sat['action'] as $action) { ?>
                                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a>&nbsp;
                                          <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>
<script type="text/javascript">
  function filter(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'kode_po\']').val();

    if (filter_status != '*') {
      url += '&kode_po=' + encodeURIComponent(filter_status);
    }

  var refpo = $('select[name=\'refpo\']').val();
    if (refpo != '*') {
      url += '&refpo=' + encodeURIComponent(refpo);
    }
    location =url;
    
  }
</script>