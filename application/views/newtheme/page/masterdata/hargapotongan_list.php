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
            <select name="jenis" id="jenis" class="form-control select2bs4" style="width:100%">
              <option value="">Pilih</option>
              <?php foreach($jenis as $j){?>
                <option value="<?php echo $j['nama_jenis_po']?>"><?php echo $j['nama_jenis_po']?></option>
              <?php } ?>
            </select>
            <input type="hidden" name="keterangan" id="keterangan">
          </div>
          <div class="form-group">
            <label>Harga Potongan</label>
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
    <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Tambah</button></span>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Kode PO</th>
                  <th>Harga per Pc (Rp)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <form method="post" action="<?php echo $edit?>">
                      <input type="hidden" name="products[<?php echo $i?>][id_master_harga_potongan]" value="<?php echo $p['id_master_harga_potongan']?>">
                      <tr>
                        <td><?php echo $n++?></td>
                        <td><?php echo $p['nama_jenis_po']?></td>
                        <td><input type="text" name="products[<?php echo $i?>][harga_potongan]" value="<?php echo $p['harga_potongan'];?>" class="form-control"></td>
                        <td>
                          <input type="submit" class="btn btn-xs btn-warning text-white" value="Simpan">
                          <a href="<?php echo $hapus.$p['id_master_harga_potongan']?>" class="btn btn-danger btn-xs text-white">Hapus</a>
                        </td>
                      </tr>
                    </form>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
  </div>
</div>
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