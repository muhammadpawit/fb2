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
    <?php if ($this->session->flashdata('msgt')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    <?php echo $this->session->flashdata('msgt'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="date" name="tanggal1" value="<?php echo $tanggal1?>" id="tanggal1" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <!--
  <div class="col-md-3">
    <div class="form-group">
      <label>Bagian</label>
      <select name="bagian" class="form-control select2bs4" id="bagian" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($divisi as $c){?>
          <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
        <?php } ?>
      </select>
    </div>
  </div>-->
  <div class="col-md-4">
    <div class="form-group">
      <label>Action</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <!--<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>-->
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatabless">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>No Faktur</th>
                          <th>Tujuan</th>
                          <th>Keterangan</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($products)){?>
                          <?php foreach($products as $p){?>
                        <tr>
                          <td><?php echo $p['tanggal']?></td>
                          <td><?php echo $p['nofaktur']?></td>
                          <td><?php echo $p['nama_penerima']?></td>
                          <td><?php echo $p['keterangan']?></td>
                          <td><a href="<?php echo $p['detail']?>" class="badge bg-success">Cetak</a></td>
                        </tr>
                        <?php } ?>
                        <?php }else{ ?>
                          <tr>
                            <td colspan="6">Belum ada data</td>
                          </tr>
                        <?php } ?>
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

    /*
    var filter_status = $('select[name=\'namaPo\']').val();

    if (filter_status != '*') {
      url += '&namaPo=' + encodeURIComponent(filter_status);
    }*/
    location =url;
    
  }
</script>