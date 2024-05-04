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
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Kode PO</label>
      <select name="kode_po" class="form-control autopoid">
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
      <thead>
        <tr>
          <th>TANGGAL</th>
          <th>NAMA ITEM</th>
          <th>BAHAN U/</th>
          <th>KODE PO</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($item as $sat): ?>
        <tr>
          <td><?php echo date('d F Y',strtotime($sat['created_date'])) ?></td>
          <td><?php echo $sat['nama_item_keluar'] ?></td>
          <td><?php echo $sat['bahan_kategori'] ?></td>
          <td><?php echo $sat['kode_po'] ?></td>
          <td class="right">
            <?php foreach ($sat['action'] as $action) { ?>
               <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
            <?php } ?>
          </td>
        </tr>
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
    
    if (filter_status !=null) {
      url += '&kode_po=' + encodeURIComponent(filter_status);
    }
    
    location =url;
  }
</script>