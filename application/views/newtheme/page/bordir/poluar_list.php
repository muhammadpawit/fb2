<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                       <?php if ($this->session->flashdata('gagal')) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true">×</span>

                            </button>
                               <?php echo $this->session->flashdata('gagal'); ?> 

                        </div>

                           <?php } ?>

                    </p>  
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah PO Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Nama PO</label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Pemilik PO</label>
            <select name="pemilik" class="form-control select2bs4" required="required" style="width: 100%;">
              <option value="">Pilih</option>
              <?php foreach($pemilik as $p){?>
                <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
              <?php } ?>
            </select>
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
      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Master PO Luar</h3>
          <div class="card-tools">
            <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover yessearch">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pemilik</th>
                  <th>Nama PO</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo ucwords($p['pemilik'])?></td>
                      <td><?php echo ucwords($p['nama'])?></td>
                      <td>
                        <a href="<?php echo $p['edit']?>" class="btn btn-warning btn-sm">Edit</a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->