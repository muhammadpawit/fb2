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
    <div class="card-tools text-right">
      <div class="form-group">
        <a href="<?php echo BASEURL.'User/tambah'?>" class="btn btn-info btn-sm text-white">Tambah</a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-hover yessearch">
              <thead>
                <tr>
                  <th>Nama User</th>
                  <th>Status</th>
                  <th width="100"></th>
                  <th width="100"></th>
                  <th width="100"></th>
                  <th width="100"></th>
                  <th width="100"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($user as $us): ?>
                            <tr>
                                <td><?php echo $us['nama_user'] ?></td>
                                <td><?php echo $us['status_user']==1?'Aktif':'Non-aktif'; ?></td>
                                <?php foreach ($us['action'] as $action) { ?>
                                  <td width="100">
                                   
                                    <a href="<?php echo $action['href']; ?>" class="btn btn-<?php echo $action['class']; ?> btn-xs text-white waves-light waves-effect" <?php if($us['status_user']!=1){?> onclick="return confirm('Apakah yakin akan menghapus data ini ?')" <?php } ?>><?php echo $action['text']; ?></a>
                                
                                  </td>
                          <?php } ?>
                            </tr>
                                <?php endforeach ?>
              </tbody>
            </table>
  </div>
</div>