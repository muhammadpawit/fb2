<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Karyawan Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Nama </label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Tipe Gaji</label>
            <select name="tipe" class="form-control select2bs4" style="width:100%">
              <option value="1">Harian</option>
              <option value="2">Borongan</option>
            </select>
          </div>
          <div class="form-group">
            <label>Dari CMT</label>
            <select name="cmt_id" class="form-control select2bs4" style="width:100%">
              <option value="">Pilih</option>
              <?php foreach($cmt as $c) { ?>
                <option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Gaji Perminggu </label>
            <input type="text" name="perminggu" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Bagian </label>
            <input type="text" name="bagian" class="form-control" required="required">
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
  <div class="col-12">
    <div class="form-group">
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah</button>
    </div>
  </div>
  <div class="col-md-12">
    <div class="table-responsive">
            <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Bagian</th>
                  <th>Tipe</th>
                  <th>Gaji per hari</th>
                  <th>Gaji per minggu</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $p['no']?></td>
                      <td><?php echo strtolower($p['nama'])?></td>
                      <td><?php echo strtolower($p['bagian'])?></td>
                      <td>
                        <?php echo $p['tipe']==1?'Harian':'Borongan';?>
                      </td>
                      <td>
                        <?php echo $p['tipe']==1?number_format($p['gaji']):'';?>
                          <?php
                          if(isset($p['borongan'])){
                            foreach($p['borongan'] as $b){
                              echo "Tress : ".number_format($b['tress']).' Pertitik<br>';
                              echo "Lb Kancing : ".number_format($b['lobangkancing']).' Pertitik<br>';
                              echo "Ps kancing : ".number_format($b['pasangkancing']).' Pertitik<br>';
                              echo "Keterangan : ".($b['keterangan']).'<br>';
                            }
                          }
                        ?>  
                      </td>
                      <td><?php echo $p['perminggu']==0?number_format($p['gaji']*6):number_format($p['perminggu'])?></td>
                      <td>
                        <?php if($edit==1){?>
                           <a href="<?php echo $ubah.$p['id'];?>" class="btn btn-warning btn-sm text-white">Edit</a>
                        <a href="<?php echo $hapus.$p['id'];?>" class="btn btn-danger btn-sm text-white">Delete</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
    </div>
  </div>
</div>