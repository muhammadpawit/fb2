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

     <?php if ($this->session->flashdata('gagal')) { ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span>

        </button>

    <?php echo $this->session->flashdata('gagal'); ?> 

    </div>

    <?php } ?>

  </div>

</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Request Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Nama</label>
            <input type="hidden" name="userid" class="form-control" value="<?php echo callSessUser('id_user') ?>" readonly>
            <input type="text" name="nama" class="form-control" value="<?php echo callSessUser('nama_user') ?>" readonly>
          </div>
          <div class="form-group">
          	<label>Permintaan Untuk</label>
          	<select name="aksestable" class="form-control select2bs4" data-live-search="true" style="width:100%">
          		<option value="Masterdata/userakses/">Otorisasi Edit dan Hapus</option>
          		<option value="user/menu">Minta bukain menu</option>
          	</select>
          </div>
          <div class="form-group">
          	<label>Keterangan ( contoh: minta tolong bukakan menu sablonan</label>
          	<textarea name="keterangan" class="form-control" rows="5" required="required"></textarea>
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
    <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Tambah</button></span>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $p['n']?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo strtoupper($p['nama'])?></td>
                      <td><?php echo strtoupper($p['keterangan'])?></td>
                      <td><?php echo $p['status']?></td>
                      <td>
                        <?php if($p['stat']==0){?>
                            <a href="<?php echo $p['setujui'] ;?>" class="btn btn-info btn-sm text-white">Proses</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>