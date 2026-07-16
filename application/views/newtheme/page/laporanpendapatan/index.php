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
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis PO</th>
          <th>Total Dz</th>
          <th>Total Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; $total=0; foreach($pendapatan as $p){ ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $p['jenis_po'] ?></td>
            <td><?php echo number_format($p['total_dz'], 2) ?></td>
            <td>Rp. <?php echo number_format($p['total_pendapatan']) ?></td>
          </tr>
        <?php $total += $p['total_pendapatan']; } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="text-right"><b>Total</b></td>
          <td><b>Rp. <?php echo number_format($total) ?></b></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script type="text/javascript">
  function filtertglonly(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }
</script>
