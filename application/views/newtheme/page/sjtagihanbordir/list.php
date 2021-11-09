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
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
      <a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>Tgl Kirim</th>
                  <th>PO</th>
                  <th>Keterangan</th>
                  <th>Size</th>
                  <th>Sticth</th>
                  <th>Qty</th>
                  <th>Tot Sticth</th>
                  <th>Harga (Pc)</th>
                  <th>Total</th>
                  <th>Ket</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $d){?>
                      <tr>
                        <td><?php echo $d['tanggal']?></td>
                        <td><?php echo $d['namapo']?></td>
                        <td><?php echo $d['keterangan']?></td>
                        <td><?php echo $d['size']?></td>
                        <td><?php echo $d['sticth']?></td>
                        <td><?php echo $d['qty']?></td>
                        <td><?php echo $d['totalsticth']?></td>
                        <td><?php echo $d['harga']?></td>
                        <td><?php echo $d['total']?></td>
                        <td><?php echo $d['ket']?></td>
                        <td>
                        	<!-- <a href="<?php echo $p['detail']?>" class="btn btn-primary btn-sm text-white">Detail</a> -->
                        	<?php if(akseshapus()==1){?>
                        		<a href="<?php echo $d['hapus']?>" class="btn btn-danger btn-sm text-white">Hapus</a>
                        	<?php } ?>
                        </td>
                      </tr>
                  <?php }?>
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

    var bag = $('select[name=\'bag\']').val();

    if (bag!="*") {
      url += '&bag=' + encodeURIComponent(bag);
    }
    location =url;
  }

  function excel(){
    var bag = $('select[name=\'bag\']').val();
    url='?excel=1';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    

    if (bag!="*") {
      url += '&bag=' + encodeURIComponent(bag);
    }
    location =url;
  }

</script>