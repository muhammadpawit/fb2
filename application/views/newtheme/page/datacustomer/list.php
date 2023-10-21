<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Customer Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="formInput" action="<?php echo $action ?>">
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" name="nama" class="form-control" required="required">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>No WA</label>
                    <input type="text" name="no_hp" class="form-control" required="required">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email Customer</label>
                    <input type="text" name="email" class="form-control" required="required">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Alamat Customer</label>
                    <textarea name="alamat" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
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
    <div class="form-group">
        <span class=""><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Tambah</button></span>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered table-hover yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>No. WA / HP</th>
                        <th>Email</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prods as $c){ ?>
                        <tr>
                            <td><?php echo $c['no']?></td>
                            <td><?php echo $c['nama']?></td>
                            <td><?php echo $c['no_hp']?></td>
                            <td><?php echo $c['email']?></td>
                            <td><?php echo $c['alamat']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>