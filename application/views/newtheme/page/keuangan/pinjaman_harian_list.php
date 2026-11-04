<!-- Modal Tambah Pinjaman -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Pinjaman Karyawan Harian</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d') ?>" required>
          </div>
          <div class="form-group">
            <label>Nama Karyawan Harian</label>
            <select name="idkaryawan" class="form-control select2bs4" required="required" data-live-search="true" style="width: 100%;">
                <option value="">Pilih</option>
                <?php foreach($karyawan as $p){?>
                  <option value="<?php echo $p['id']?>"><?php echo strtoupper($p['nama'])?><?php echo !empty($p['bagian']) ? ' - '.strtoupper($p['bagian']) : '' ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah Pinjaman</label>
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
    </div>
  </div>
</div>

<!-- Modal Tambah Potongan -->
<div id="modalPotongan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title">Tambah Potongan Pinjaman Karyawan Harian</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action_potongan?>">
          <input type="hidden" name="redirect_to" value="pinjamankaryawanharian">
          <div class="form-group">
            <label>Tanggal Potongan</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required="required">
          </div>
          <div class="form-group">
            <label>Nama Karyawan Harian</label>
            <select name="idkaryawan" id="idkaryawan_potongan" style="width:100%" class="form-control select2bs4" required="required" data-live-search="true">
                <option value="">Pilih</option>
                <?php foreach($karyawan as $p){?>
                  <option value="<?php echo $p['id']?>"><?php echo strtoupper($p['nama'])?><?php echo !empty($p['bagian']) ? ' - '.strtoupper($p['bagian']) : '' ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Pinjaman</label>
            <select name="listpinjaman" id="listpinjaman_harian" class="form-control" required="required">
              <option value="">Pilih Karyawan Terlebih Dahulu</option>
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
          <button type="submit" class="btn btn-success">Simpan Potongan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
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
      <label>Nama Karyawan Harian</label>
      <select id="karyawan" class="form-control select2bs4" data-live-search="true" style="width: 100%;">
        <option value="">Pilih</option>
        <?php foreach($karyawan as $p){?>
          <option value="<?php echo $p['id']?>" <?php echo $p['id']==$kar ? 'selected':''?>><?php echo strtoupper($p['nama'])?><?php echo !empty($p['bagian']) ? ' - '.strtoupper($p['bagian']) : '' ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
    </div>
  </div>

  <div class="col-md-5">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filters()">Filter</button>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Tambah Pinjaman</button>
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPotongan">Potongan Pinjaman</button>
      <a href="<?php echo $list_potongan ?>" class="btn btn-warning btn-sm text-white">List Potongan</a>
      <a href="<?php echo $excel ?>" class="btn btn-sm btn-info">Excel</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>Rp <?php echo number_format($recap['nom_lunas']) ?></h3>
        <p>Total Lunas (<?php echo $recap['lunas'] ?> Data)</p>
      </div>
      <div class="icon">
        <i class="fa fa-check"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>Rp <?php echo number_format($recap['nom_belum_lunas']) ?></h3>
        <p>Total Belum Lunas (<?php echo $recap['belum_lunas'] ?> Data)</p>
      </div>
      <div class="icon">
        <i class="fa fa-times-circle"></i>
      </div>
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
          <th>Bagian</th>
          <th>Jumlah Pinjaman</th>
          <th>Jumlah Potongan</th>
          <th>Sisa Pinjaman</th>
          <th>Keterangan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if($products){?>
          <?php foreach($products as $p){?>
            <tr>
              <td><?php echo $n++?></td>
              <td><?php echo $p['tanggal']?></td>
              <td><?php echo ucwords($p['nama'])?></td>
              <td><?php echo strtoupper($p['bagian'])?></td>
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

  $(document).ready(function() {
    $("#idkaryawan_potongan").change(function() {
      $('#listpinjaman_harian').empty();
      var val = $(this).val();
      if(val){
        $.get("<?php echo BASEURL ?>Keuangan/getpinjamanharian?&idkaryawan="+val, 
          function(data){   
            $('#listpinjaman_harian').append(data);
          }
        );
      }
    });
  });
</script>

