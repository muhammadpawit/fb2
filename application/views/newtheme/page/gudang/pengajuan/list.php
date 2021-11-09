      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Pengajuan Barang</h3>

          <div class="card-tools">
            <span class="pull-right"><a href="" class="btn btn-sm btn-primary">Tambah</a></span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Pekerjaan</th>
                  <th>Telephone</th>
                  <th>Alamat</th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtoupper($p['cmt_name'])?></td>
                      <td><?php echo strtoupper($p['cmt_job_desk'])?></td>
                      <td><?php echo strtoupper($p['telephone'])?></td>
                      <td><?php echo strtoupper($p['alamat'])?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
            <tfoot>
              <?php 
                echo $this->pagination->create_links();
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