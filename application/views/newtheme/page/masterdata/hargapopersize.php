<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Harga Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Nama PO</label>
            <select name="nama_po" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">Pilih</option>
              <?php foreach(table('master_jenis_po') as $p){?>
                <option value="<?php echo $p['nama_jenis_po']?>"><?php echo $p['nama_jenis_po'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Size</label>
            <select name="size" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">Pilih</option>
              <?php foreach(table('mastersize_potongan') as $p){?>
                <option value="<?php echo $p['size']?>"><?php echo $p['size'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="hargahpp" class="form-control" required="required">
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
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama PO</th>
                  <th>Size</th>
                  <th>Harga</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $p['no']?></td>
                      <td><?php echo $p['nama_po']?></td>
                      <td><?php echo $p['size_potongan']?></td>
                      <td><?php echo number_format($p['hargahpp'])?></td>
                      <td>
                        <?php if(aksesedit()==1){?>
                          <a href="<?php echo $p['edit'];?>" class="btn btn-warning btn-xs text-white">Edit</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>