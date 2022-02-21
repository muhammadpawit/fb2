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
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
      <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>No</th>
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
  </div>
</div>