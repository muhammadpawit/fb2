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
        <h4 class="modal-title">Tambah Master Persediaan</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Nama Item</label>
                              <input type="text" name="nama" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                              <label>Warna</label>
                              <input type="text" name="warna_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Ukuran Item</label>
                              <input type="text" name="ukuran_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Satuan Ukuran Item</label>
                              <select name="satuan_ukuran_item" class="form-control">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Satuan</label>
                              <select name="satuan" class="form-control">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Minimal Stok</label>
                              <input type="text" name="minstok" value="10" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Resiko</label>
                              <input type="text" name="resiko" value="0" class="form-control">
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-info">Simpan</button>
                              <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
                            </div>
                          </div>
                        </div>
                      </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>     
     <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Master Persediaan</h3>
          <div class="card-tools">
            <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
          </div>
        </div>
        <div class="card-body">
          <div class="card-header">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Quantity</th>
                  <th>Harga</th>
                  <th></th>
                </tr>
              </thead>          
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                        <tr>
                          <td><?php echo $i++?></td>
                          <td><?php echo $p['kodebarang']?></td>
                          <td><?php echo $p['nama']?></td>
                          <td><?php echo $p['satuan']?></td>
                          <td><?php echo $p['quantity']?></td>
                          <td align="right"><?php echo $p['price']?></td>
                          <td class="right"><?php foreach ($p['action'] as $action) { ?>
                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                          <?php } ?></td>
                        </tr>
                        <?php } ?>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <?php 
            echo $this->pagination->create_links();
          ?>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->