<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>  
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="col-md-12">
            <div class="form-group">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama PO</label><br>
            <select name="idpoluar" class="form-control select2bs4" data-live-search="true" required="required" style="width: 100% !important;">
              <option value="">Pilih</option>
              <?php foreach($po as $p){?>
                <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Bagian Bordir</label>
            <textarea class="form-control" name="keterangan" required="required"></textarea>
          </div>
          <div class="form-group">
            <label>Size</label>
            <input type="text" name="size" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Sticth</label>
            <input type="text" name="sticth" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Qty</label>
            <input type="number" name="qty" class="form-control" required="required">
          </div>
          </div>
          <div class="col-md-6">
            <a class="btn btn-danger text-white full" data-dismiss="modal">Batal</a>
          </div>
          <div class="col-md-6">
            <button type="submit" class="btn btn-info full">Simpan</button>            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div> 
<div class="row no-print">
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
      <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></span>
      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
      <button class="btn btn-info btn-sm" onclick="cetak()">Print</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
            <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pemilik</th>
                  <th>Tanggal Kirim</th>
                  <th>Nama PO</th>
                  <th>Keterangan</th>
                  <th>Size</th>
                  <th>Sticth</th>
                  <th>Qty</th>
                  <th>Tot Sticth</th>
                  <th>Harga (pc)</th>
                  <th>Total</th>
                  <th>Ket</th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo ucwords($p['pemilik'])?></td>
                      <td><?php echo ucwords($p['tanggal'])?></td>
                      <td><?php echo ucwords($p['po'])?></td>
                      <td><?php echo ucwords($p['keterangan'])?></td>
                      <td><?php echo ucwords($p['size'])?></td>
                      <td><?php echo ucwords($p['sticth'])?></td>
                      <td><?php echo ucwords($p['qty'])?></td>
                      <td><?php echo ucwords($p['totalsticth'])?></td>
                      <td><?php echo ucwords($p['harga'])?></td>
                      <td><?php echo ucwords($p['total'])?></td>
                      <td><?php echo ucwords($p['ket'])?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
          </div>
  </div>
</div>