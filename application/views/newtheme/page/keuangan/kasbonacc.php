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
      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Persetujuan Kasbon Karyawan</h3>
        </div>
        <div class="card-body">
          <div class="card-header"></div>
          <div class="table-responsive">
            <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>Periode Tanggal</th>
                  <th>Diajukan Oleh</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p){?>
                  <tr>
                    <td><?php echo $p['tanggal']?></td>
                    <td><?php echo $p['nama']?></td>
                    <td><?php echo $p['status']==0?'Diajukan':'Disetujui';?></td>
                    <td>
                      <?php if($p['status']==0){?>
                        <a href="<?php echo BASEURL.'Dash/kasbonview/'.$p['id'];?>" class="btn btn-info btn-sm">Proses setujui</a>
                      <?php }else{ ?>
                        <a href="<?php echo BASEURL.'Keuangan/kasbondetail/'.$p['id'];?>" class="btn btn-success btn-sm">Sudah disetujui</a>
                      <?php } ?>
                    </td>
                  </tr>
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