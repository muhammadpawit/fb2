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
        <h4 class="modal-title">Tambah Harga Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Jenis</label>
            <select name="jenis" id="jenis" class="form-control select2bs4">
              <option value="">Pilih</option>
              <?php foreach($type as $t){?>
                <option value="<?php echo $t['jenis']?>"><?php echo $t['keterangan']?></option>
              <?php } ?>
            </select>
            <input type="hidden" name="keterangan" id="keterangan">
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control">
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
          <h3 class="card-title"><?php echo $title?></h3>

          <div class="card-tools">
            <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Keterangan</th>
                  <th>Nominal (Rp)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <form method="post" action="<?php echo $edit?>">
                      <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $p['id']?>">
                      <tr>
                        <td>#</td>
                        <td><?php echo $p['keterangan']?></td>
                        <td><input type="text" name="products[<?php echo $i?>][nominal]" value="<?php echo $p['nominal'];?>" class="form-control"></td>
                        <td>
                          <input type="submit" class="btn btn-xs btn-warning text-white" value="edit">
                          <a href="<?php echo $hapus.$p['id']?>" class="btn btn-danger btn-xs text-white">Hapus</a>
                        </td>
                      </tr>
                    </form>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
<script type="text/javascript">
  function text(){
    var r=$( "#keterangan option:selected" ).text();
    alert(r);
  }
  $('select').on('change', function() {
     var r=$( "#jenis option:selected" ).text();
      //alert(r);
    $("#keterangan").val(r);
  });
</script>