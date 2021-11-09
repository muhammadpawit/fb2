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
    <label>Tanggal Awal</label>
    <input type="text" value="<?php echo $tanggal1?>" name="tanggal1" class="form-control datepicker">
  </div>
  <div class="col-md-3">
    <label>Tanggal Akhir</label>
    <input type="text" value="<?php echo $tanggal2?>" name="tanggal1" class="form-control datepicker">
  </div>
  <div class="col-md-3">
    <label>Nama CMT</label>
    <select name="cmt" class="form-control select2bs4" data-live-search="true">
      <option value="*">Semua</option>
      <?php foreach($cmt as $c){?>
        <option value="<?php echo $c['id_cmt']?>"><?php echo strtolower($c['cmt_name'])?></option>
      <?php } ?>
    </select>
  </div>
  <div class="col-md-3">
    <label>Action</label><br>
    <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
    <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>No.SJ</th>
                          <th>Tanggal</th>
                          <!--<th>Nama PO</th>-->
                          <th>Nama CMT</th>
                          <th>Quantity (Pcs)</th>
                          <th>Keterangan</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($products as $p){?>
                        <tr>
                          <td><?php echo $p['no']?></td>
                          <td><?php echo $p['nosj']?></td>
                          <td><?php echo $p['tanggal']?></td>
                          <!--<td><?php echo $p['kode_po']?></td>-->
                          <td><?php echo $p['namacmt']?></td>
                          <td><?php echo $p['quantity']?></td>
                          <td><?php echo $p['keterangan']?></td>
                          <td class="right"><?php foreach ($p['action'] as $action) { ?>
                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                          <?php } ?></td>
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

    var filter_status = $('select[name=\'cmt\']').val();

    if (filter_status != '*') {
      url += '&cmt=' + encodeURIComponent(filter_status);
    }

    location =url;
  }
</script>