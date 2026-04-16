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
            <input type="text" name="tanggal" class="form-control datepicker" required>
          </div>
          <div class="form-group">
            <label>Nama Karyawan</label>
            <select name="idkaryawan" class="form-control select2bs4" required="required" data-live-search="true" style="width: 100%;">
                <option value="">Pilih</option>
                <?php foreach($karyawan as $p){?>
                  <option value="<?php echo $p['id']?>"><?php echo strtoupper($p['nama'])?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="totalpinjaman" class="form-control" required="required">
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

  <div class="col-md-3">

  <div class="form-group">

    <label>Nama Karyawan</label>

    <select id="karyawan" class="form-control select2bs4" required="required" data-live-search="true" style="width: 100%;">
                <option value="">Pilih</option>
                <?php foreach($karyawan as $p){?>
                  <option value="<?php echo $p['id']?>" <?php echo $p['id']==$kar ? 'selected':''?>><?php echo strtoupper($p['nama'])?></option>
                <?php } ?>
    </select>

  </div>

  </div>

  <div class="col-md-3">

    <div class="form-group">

      <label>Tanggal Awal</label>

      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">

    </div>

  </div>

  <div class="col-md-3">

    <div class="form-group">

      <label>Tanggal Akhir</label>

      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">

    </div>

  </div>

  <div class="col-md-3">

    <div class="form-group">

      <label>Aksi</label><br>

      <button class="btn btn-info btn-sm" onclick="filters()">Filter</button>

      <span><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah</button></span>

      <a href="<?php echo $print ?>" class="btn btn-sm btn-info">Print</a>
      <a href="<?php echo $excel ?>" class="btn btn-sm btn-info">Excel</a>

    </div>

  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Jumlah Pinjaman</th>
                  <th>Jumlah Potongan</th>
                  <th>Sisa Pinjaman</th>
                  <th>Keterangan</th>
                  <th>Status</th>
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
                      <td><?php echo $p['totalpinjaman']?></td>
                      <td><?php echo $p['totalpotongan']?></td>
                      <td><?php echo $p['sisa'];?></td>
                      <td><?php echo $p['keterangan'];?></td>
                      <td>
                        <?php
                          if($p['status']==1 OR $p['status']==2){
                            echo "<span class='badge bg-red'>Belum Lunas</span>";
                          }else{
                            echo "<span class='badge bg-green'>Lunas</span>";
                          }

                        ?>
                      </td>
                      <td>
                        <?php if($p['can_edit']){ ?>
                        <a href="<?php echo $p['edit']?>" class="btn btn-warning btn-xs text-white">Edit</a>
                        <a href="<?php echo $p['hapus']?>" class="btn btn-danger btn-xs text-white" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        <?php } ?>
                        <a href="<?php echo $p['rincian']?>" class="btn btn-success btn-xs text-white">History Potongan</a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>

<script>
  function filters(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    var karyawan =$("#karyawan").val();
    if(karyawan){
      url+='&karyawan='+karyawan;
    }


    location =url;
  }
</script>