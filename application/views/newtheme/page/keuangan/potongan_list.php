<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal Potongan</label>
            <input type="date" name="tanggal" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Nama Karyawan</label>
            <select name="idkaryawan" id="idkaryawan" style="width:100%" class="form-control select2bs4" required="required" data-live-search="true">
                <option value="">Pilih</option>
                <?php foreach($karyawan as $p){?>
                  <option value="<?php echo $p['id']?>"><?php echo strtoupper($p['nama'])?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Pinjaman</label>
            <select name="listpinjaman" id="listpinjaman" class="form-control" required="required">
              
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah Potongan</label>
            <input type="number" name="totalpotongan" class="form-control" required="required">
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

      <span><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>

    </div>

  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Jumlah Potongan</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo ucwords($p['nama'])?></td>
                      <td><?php echo $p['totalpotongan']?></td>
                      <td><?php echo $p['keterangan'];?></td>
                      <td>
                        <!--<a href="<?php echo $p['edit']?>" class="btn btn-warning btn-xs text-white">Edit</a>
                        <a href="<?php echo $p['rincian']?>" class="btn btn-success btn-xs text-white">Rincian</a>-->
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>
<script type="text/javascript">
  $( "#idkaryawan" ).change(function() {
    $('#listpinjaman').empty();
    val = $(this).val();
    //alert(val);
    $.get("https://forboysproduction.com/Keuangan/getpinjaman?&idkaryawan="+val, 
      function(data){   
      console.log(data);
      $('#listpinjaman').append(data);
    });
  });
</script>