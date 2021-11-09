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
          <h3 class="card-title">Edit Data Karyawan Harian dan Borongan</h3>
          <div class="card-tools">
            <span class="pull-right"></span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <form method="post" action="<?php echo $update?>">
            <table class="table table-bordered">
              <tbody>
                 <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td>Nama</td>
                      <td>:</td>
                      <td><input type="text" name="nama" value="<?php echo $p['nama']?>" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Bagian</td>
                      <td>:</td>
                      <td><input type="text" name="bagian" value="<?php echo $p['bagian']?>" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Gaji Per Minggu</td>
                      <td>:</td>
                      <td><input type="hidden" name="id" value="<?php echo $p['id']?>"><input type="text" name="perminggu" value="<?php echo $p['perminggu']==0?$p['gaji']*6:$p['perminggu']?>" class="form-control" onblur="perhari()"></td>
                    </tr>
                    
                    <tr>
                      <td>Bagian</td>
                      <td>:</td>
                      <td>
                        <select name="tipe" class="form-control select2bs4">
                          <option value="1" <?php echo $p['tipe']==1?'selected':'';?>>Harian</option>
                          <option value="2" <?php echo $p['tipe']==2?'selected':'';?>>Borongan</option>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
            <?php if($products[0]['tipe']==2){?>
            <table class="table table-bordered" id="gajiborongan">
              <thead>
                <tr>
                  <th>Harga Per Titik Tress</th>
                  <th>Harga Per Titik Lobang Kancing</th>
                  <th>Harga Per Titik Pasang Kancing</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" name="gajiborongan[tress]" value="<?php echo $borongan['tress']?>" class="form-control"></td>
                  <td><input type="text" name="gajiborongan[lobangkancing]" value="<?php echo $borongan['lobangkancing']?>" class="form-control"></td>
                  <td><input type="text" name="gajiborongan[pasangkancing]" value="<?php echo $borongan['pasangkancing']?>" class="form-control"></td>
                  <td><input type="text" name="gajiborongan[keterangan]" value="<?php echo $borongan['keterangan']?>" class="form-control"></td>
                </tr>
              </tbody>
            </table>
            <?php } ?>
            </form>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-right">
          <button onclick="simpan()" class="btn btn-success text-white">Save</button>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
<script type="text/javascript">
  function perhari(){

  }
  simpan(){
    $("form").submit();
  }
</script>      