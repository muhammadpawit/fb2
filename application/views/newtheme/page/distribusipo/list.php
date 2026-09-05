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
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>No. SJ</label>
      <select name="sj" id="sj" class="form-control select2bs4">
        <option value="*">Semua</option>
        <?php foreach($nosj as $c){?>
          <option value="<?php echo $c['id']?>" <?php echo $c['id']==$sj?'selected':'';?>><?php echo strtoupper($c['nosj'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>CMT Tujuan</label>
      <select name="cmt" id="cmt" class="form-control select2bs4">
        <option value="*">Semua</option>
        <?php foreach($listcmt as $c){?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':'';?>><?php echo strtoupper($c['cmt_name'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <label>Aksi</label><br>
    <button class="btn btn-info btn-sm" onclick="filterDistribusi()">Filter</button>
    <a href="<?php echo $tambah ?>" class="btn btn-primary btn-sm">Tambah</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-bordered table-striped yessearch">
        <thead>
          <tr>
            <th>No</th>
            <th>No. SJ</th>
            <th>Tanggal</th>
            <th>CMT Tujuan</th>
            <th>Quantity (Pcs)</th>
            <th>Supir / Pendamping</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; ?>
          <?php foreach($products as $p){?>
            <tr>
              <td><?php echo $no++?></td>
              <td><?php echo $p['nosj']?></td>
              <td><?php echo $p['tanggal']?></td>
              <td><?php echo $p['namacmt']?></td>
              <td><?php echo number_format($p['quantity'])?></td>
              <td><?php echo $p['supir'] . ($p['pendamping'] ? ' / '.$p['pendamping'] : '')?></td>
              <td><?php echo $p['keterangan']?></td>
              <td>
                <span class="badge badge-<?php echo $p['status']=='Disetor'?'success':'info'?>">
                  <?php echo $p['status']?>
                </span>
              </td>
              <td>
                <div class="btn-group">
                  <?php foreach ($p['action'] as $action) { ?>
                    <?php if (strtolower($action['text']) === 'hapus') { ?>
                      <a href="<?php echo $action['href']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus Surat Jalan Distribusi ini?')"><i class="fa fa-trash"></i> Hapus</a>
                    <?php } else if (strtolower($action['text']) === 'edit') { ?>
                      <a href="<?php echo $action['href']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <?php } else if (strtolower($action['text']) === 'cetak') { ?>
                      <a href="<?php echo $action['href']; ?>" target="_blank" class="btn btn-secondary btn-xs"><i class="fa fa-print"></i> Cetak</a>
                    <?php } else { ?>
                      <a href="<?php echo $action['href']; ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Detail</a>
                    <?php } ?>
                    &nbsp;
                  <?php } ?>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true
    });
    $('.select2bs4').select2();
  });

  function filterDistribusi(){
    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();
    var sj = $('#sj').val();
    var cmt = $('#cmt').val();
    var url = '<?php echo $url ?>';
    location = url + '?tanggal1=' + tanggal1 + '&tanggal2=' + tanggal2 + '&sj=' + sj + '&cmt=' + cmt;
  }
</script>
