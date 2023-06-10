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
            <label>Tanggal Masuk</label>
            <input type="text" name="tglmasuk" class="form-control datepicker" required="required">
          </div>
          <div class="form-group">
            <label>Nomor Induk Karyawan</label>
            <input type="text" name="nik" class="form-control" value="<?php echo $nik ?>" required="required">
          </div>
          <div class="form-group">
            <label>Nama Karyawan</label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control select2bs4" style="width:100%" required="required">
              <option value="">Pilih</option>
              <option value="PRIA">Pria</option>
              <option value="WANITA">Wanita</option>
            </select>
          </div>
          <div class="form-group">
            <label>Divisi </label>
            <select name="divisi" class="form-control select2bs4" style="width:100%" required="required">
              <option value="">Pilih</option>
              <?php foreach($divisi as $j){?>
              <option value="<?php echo $j['id']?>"><?php echo $j['nama']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jabatan </label>
            <select name="jabatan" class="form-control select2bs4" style="width:100%" required="required">
              <option value="">Pilih</option>
              <?php foreach($jabatan as $j){?>
              <option value="<?php echo $j['id']?>"><?php $jab=strtolower(ucwords($j['nama'])); echo ucwords($jab)?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Gaji Pokok</label>
            <input type="number" name="gajipokok" class="form-control" required="required">
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
        <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Tambah</button></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nomor Induk Karyawan</th>
                  <th>Nama Karyawan</th>
                  <th>Divisi</th>
                  <th>Jabatan</th>
                  <th>Gaji Pokok</th>
                  <th>Tanggal Masuk</th>
                  <th>Masa Kerja</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo ucwords($p['nik'])?></td>
                      <td><?php echo ucwords($p['nama'])?></td>
                      <td><?php echo ucwords($p['divisi'])?></td>
                      <td><?php echo ucwords($p['jabatan'])?></td>
                      <td><?php echo ($p['gajipokok'])?></td>
                      <td><?php echo ucwords($p['tglmasuk'])?></td>
                      <td>
                        <?php 
                          if($p['masakerja']->y>0){
                            echo $p['masakerja']->y." Tahun ";
                          }

                          if($p['masakerja']->m>0){
                            echo $p['masakerja']->m." Bulan ";
                          }

                          if($p['masakerja']->d>0){
                            echo $p['masakerja']->d." Hari ";
                          }
                        ?>
                          
                      </td>
                      <td>
                        <?php if($p['status_resign']==2){ ?>
                          <span class="badge bg-black">Non-aktif / Resign</span><br>
                          <span class="badge"><?php echo $p['tglkeluar'] ?></span>
                        <?php }else{ ?>
                          <span class="badge bg-success">Aktif</span>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="<?php echo BASEURL.'Masterdata/karyawanedit/'.$p['id'];?>" class="badge bg-info text-white">Edit</a>
                        <a href="<?php echo BASEURL.'Masterdata/karyawanhapus/'.$p['id'];?>" class="badge bg-danger text-white">Hapus</a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="10">
                    <?php 
                      //echo $this->pagination->create_links();
                    ?>
                  </td>
                </tr>
              </tfoot>
            </table>
  </div>
</div>