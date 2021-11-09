<!-- Modal -->
<div id="myModalK" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Karyawan Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $actionkaryawan?>">
          <div class="form-group">
            <label>Nama </label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label></label>
            <input type="hidden" name="bagian" value="GUDANG" class="form-control" required="required">
            <input type="hidden" name="tipe" value="1" class="form-control" required="required">
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Absen Masuk</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
        <div class="form-group text-center">
            <label class="text-center"><h3><div class="clocks"></div></h3></label>
        </div>
        <div class="form-group">
          <label>Tanggal</label>
          <input type="text" name="tanggal" class="form-control" value="<?php echo date('Y-m-d')?>" readonly>
        </div>
        <div class="form-group">
          <label>Nama Karyawan</label>
          <!--<input type="text" name="nama" class="form-control" required="required">-->
          <select name="nama" class="form-control select2bs4" data-live-search="true" required="required">
            <option value="">Pilih</option>
            <?php foreach($karyawan as $k){?>
              <option value="<?php echo $k['id']?>"><?php echo strtolower($k['nama'])?></option>
            <?php } ?>
          </select>
          <input type="hidden" name="bagian" value="2" class="form-control">
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <input type="text" name="keterangan" value="-" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="simpan" class="btn btn-success btn-sm" value="Simpan">
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <?php if ($this->session->flashdata('msgt')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    <?php echo $this->session->flashdata('msgt'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="date" name="tanggal1" value="<?php echo $tanggal1?>" id="tanggal1" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <!--
  <div class="col-md-3">
    <div class="form-group">
      <label>Bagian</label>
      <select name="bagian" class="form-control select2bs4" id="bagian" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($divisi as $c){?>
          <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
        <?php } ?>
      </select>
    </div>
  </div>-->
  <div class="col-md-4">
    <div class="form-group">
      <label>Action</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#myModal">Absen In</button>
      <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#myModalK">Tambah Nama</button>
      <!--<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah Karyawan</a>-->
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatabless">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Nama Karyawan</th>
                          <th>Jam Masuk</th>
                          <th>Jam Keluar</th>
                          <th>Keterangan</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($products)){?>
                          <?php foreach($products as $p){?>
                        <tr>
                          <td><?php echo $p['tanggal']?></td>
                          <td><?php echo $p['nama']?></td>
                          <td style="background-color: <?php echo $p['bg']?>;color: white"><?php echo $p['jam_masuk']?></td>
                          <td>
                            <?php if($p['jam_keluar']!=null){?>
                              <?php echo $p['jam_keluar']?>
                            <?php }else{?>
                              <?php if(date('d-m-Y')!=$p['tanggal']){?>
                                <span class="badge bg-danger">tidak absen out</span>
                              <?php } ?>
                            <?php } ?>
                          </td>
                          <td><?php echo $p['keterangan']?></td>
                          <td>
                            <?php if($p['action']!=null){?>
                              <?php if(empty($p['jam_keluar'])){?>
                                 <a href="<?php echo $p['action']?>" class="badge bg-success">proses absen out</a>
                              <?php }else{ ?>
                                  <?php if($p['jam_masuk']>'08:00:01'){ ?>
                                      <span class="badge bg-danger">telat masuk</span>
                                  <?php }else{ ?>
                                      <span class="badge bg-success">ok</span>
                                  <?php } ?>
                              <?php } ?>
                            <?php }else{?>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php }else{ ?>
                          <tr>
                            <td colspan="6">Belum ada data absen hari ini</td>
                          </tr>
                        <?php } ?>
                      </tbody>
                   </table>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    /*
    var filter_status = $('select[name=\'namaPo\']').val();

    if (filter_status != '*') {
      url += '&namaPo=' + encodeURIComponent(filter_status);
    }*/
    location =url;
    
  }
</script>
<script>
      function clock() {
      let date = new Date();
      let hrs = date.getHours();
      let mins = date.getMinutes();
      let secs = date.getSeconds();
      let period = "WIB - Pagi";
    
      if (hrs == 0) hrs = 12;
      if (hrs > 12) {
        hrs = hrs - 12;
        period = "WIB - Sore";
      }
    
      hrs = hrs < 10 ? `0${hrs}` : hrs;
      mins = mins < 10 ? `0${mins}` : mins;
      secs = secs < 10 ? `0${secs}` : secs;
    
      let time = `${hrs}:${mins}:${secs} ${period}`;
      setInterval(clock, 1000);
      document.querySelector(".clocks").innerText = time;

    }
    
    clock();

  </script>