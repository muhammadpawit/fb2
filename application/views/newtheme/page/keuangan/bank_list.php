<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Pilih Bank / Kas</label>
            <select name="bank_id" class="form-control select2bs4" required="required">
                <?php foreach($products as $p){?>
                  <option value="<?php echo $p['id']?>"><?php echo strtoupper($p['nama'])?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Jenis Transaksi</label>
            <select name="jenis" class="form-control select2bs4" required="required">
              <option value="">Mohon dipilih</option>
              <option value="1">Uang Masuk</option>
              <option value="2">Uang Keluar</option>
            </select>
          </div>
          <div class="form-group">
            <label>Bagian</label>
            <select name="bagian" class="form-control select2bs4" required="required">
              <option value="">Mohon dipilih</option>
              <option value="1">Konveksi</option>
              <option value="2">Bordir</option>
              <option value="3">Sablon</option>
              <option value="4">Lain-lain</option>
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
  <div class="col-md-12">
    <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></span>
  </div> 
</div>
<div class="row">
  <div class="col-md-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Bank</th>
                  <th>Saldo</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtoupper($p['nama'])?></td>
                      <td><span style="float: left">Rp.</span><span style="float: right;"><?php echo number_format($p['saldo'])?></span></td>
                      <td>
                        <a href="<?php echo $mutasi?><?php echo $p['id']?>" class="btn btn-success btn-xs text-white">Lihat Mutasi</a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div> 
</div>