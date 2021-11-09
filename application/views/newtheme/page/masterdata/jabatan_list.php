<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Jabatan Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Nama Jabatan</label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <br>
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
    <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Jabatan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtoupper($p['nama'])?></td>
                      <th><a href="<?php echo $hapus.$p['id']?>" class="btn btn-danger btn-xs text-white">Hapus</a></th>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3">
                    <?php 
                      echo $this->pagination->create_links();
                    ?>
                  </td>
                </tr>
              </tfoot>
            </table>
  </div>
</div>