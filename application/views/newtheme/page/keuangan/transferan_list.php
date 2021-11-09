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
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Bagian</label>
            <select name="bagian" class="form-control select2bs4" required="required">
              <option value="">Mohon dipilih</option>
              <option value="1">Konveksi</option>
              <option value="2">Bordir</option>
              <option value="3">Sablon</option>
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
      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">List Transferan</h3>
          <div class="card-tools">
            <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Hari / Tanggal</th>
                  <th>Nama Bagian</th>
                  <th>Nominal</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td>
                        <?php $hari=date('l',strtotime($p['tanggal'])); echo hari($hari); ?>, <?php echo date('d/m/Y',strtotime($p['tanggal']))?>
                      </td>
                      <td>
                        <?php 
                          if($p['bagian']==1){
                            echo "Konveksi";
                          }else if($p['bagian']==2){
                            echo "Bordir";
                          }else{
                            echo "Sablon";
                          }
                        ?>
                      </td>
                      <td><?php echo number_format($p['nominal'])?></td>
                      <td><?php echo ($p['keterangan'])?></td>
                      <td>
                        
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
            <tfoot>
              <?php 
                //echo $this->pagination->create_links();
                ?>
            </tfoot>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->