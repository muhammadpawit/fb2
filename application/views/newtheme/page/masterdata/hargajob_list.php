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
            <label>Nama Pekerjaan</label>
            <input type="text" name="nama_job" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Jenis</label>
            <select name="jenis" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">Pilih</option>
              <?php //if($title=='jahit'){?>
                <option value="1">Jahit</option>
              <?php //}else{?>
                <option value="2">Sablon</option>
              <?php //} ?>
            </select>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
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
                  <th>Nama Pekerjaan</th>
                  <th>Harga Lama</th>
                  <th>Harga Baru</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtoupper($p['nama_job'])?></td>
                      <td><?php echo number_format($p['harga_lama'])?></td>
                      <td><?php echo number_format($p['harga'])?></td>
                      <td><?php echo $p['keterangan']?></td>
                      <td>
                        <?php if($edit==1){?>
                          <a href="<?php echo BASEURL.'Masterdata/edithargacmt/'.$p['id'];?>" class="btn btn-warning btn-xs text-white">Edit</a>
                        <?php } ?>
                        <?php if($hapus==1){?>
                          <a href="<?php echo BASEURL.'Masterdata/hapushargacmt/'.$p['id'];?>" class="btn btn-danger btn-xs text-white">Hapus</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>