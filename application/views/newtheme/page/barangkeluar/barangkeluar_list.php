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
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
      <input type="hidden" name="jenis" id="jenis" value="<?php echo $jenis?>" class="form-control">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Bahan</label>
      <select name="id_bahan" id="id_bahan" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($persediaan as $p){ ?>
          <option value="<?php echo $p['product_id']?>"><?php echo $p['nama']?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Kode PO</label>
      <select name="kode_po" class="form-control autopo" data-live-search="true">
        <option value="*">Semua</option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
      <a target="_blank" onclick="downloadexcel()" class="btn btn-info btn-sm text-white">Excel</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nama PO</th>
                  <th>Nama Barang</th>
                  <th>Warna</th>
                  <th>Ukuran/Satuan</th>
                  <th>Jumlah/Satuan</th>
                  <th>Keterangan</th>
                  <th>Pengambil</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <?php foreach($p['details'] as $d){?>
                      <tr>
                        <td><?php echo $p['no']?></td>
                        <td><?php echo $p['tanggal']?></td>
                        <td><?php echo $p['kode_po']?></td>
                        <td><?php echo $d['nama']?></td>
                        <td><?php echo $d['warna']?></td>
                        <td><?php echo $d['ukuran'].' '.$d['satuan_ukuran']?></td>
                        <td><?php echo $d['jumlah'].' '.$d['satuanJml']?></td>
                        <td><?php echo $p['keterangan']?></td>
                        <td><?php echo $p['pengambil']?></td>
                        <td>
                          <!--<a href="<?php echo $p['edit']?>" class="btn btn-warning btn-sm text-white">Edit</a>-->
                          <?php if(akseshapus()==1){?>
                            <a href="<?php echo BASEURL.'Gudang/barangkeluarhapus/'.$p['id'].'/'.$d['id'].'/'.$jenis;?>" class="btn btn-danger btn-xs text-white">Hapus</a>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  <?php }?>
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

    var filter_status = $('input[name=\'jenis\']').val();

    if (filter_status) {
      url += '&jenis=' + encodeURIComponent(filter_status);
    }

    var id_bahan = $("#id_bahan").val();

    if (id_bahan!='*') {
      url += '&id_bahan=' + encodeURIComponent(id_bahan);
    }
    location =url;
  }


  function downloadexcel(){
    var url='?&excel=1';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }


</script>