<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $simpan?>">
          <div class="form-group">
            <label>Tahun Produksi</label>
            <input type="text" name="tahun" class="form-control" required="required" maxlength="4">
          </div>
          <div class="form-group">
            <label>Kode PO</label>
            <select name="kode_po" class="form-control autopoid" required="required">
            </select>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" required="required" name="keterangan"></textarea>
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
      <div class="modal-footer">
        
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
  <div class="col-md-4">
    <div class="form-group">
      <label>Kode PO</label>
      <select name="kode_po" class="form-control autopo">
        
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filterwithpo()">Filter</button>
      <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode PO</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($prods as $p){?>
          <tr>
            <td><?php echo $p['no']?></td>
            <td><?php echo $p['kode_po']?></td>
            <td><?php echo $p['keterangan']?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>