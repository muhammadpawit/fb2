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
    </div>
  </div>
  <div class="col-md-2">
    <label>Divisi</label>
    <select name="cat" id="cat" class="form-control select2bs4">
      <option value="*">Semua</option>
      <option value="1" <?php echo $cat==1?'selected':'';?>>Konveksi</option>
      <option value="3" <?php echo $cat==3?'selected':'';?>>Alat-alat Konveksi</option>
      <option value="2" <?php echo $cat==2?'selected':'';?>>Bordir</option>
      <option value="3" <?php echo $cat==4?'selected':'';?>>Sablon</option>
    </select>
  </div>
  <div class="col-md-3">
    <label>Supplier</label>
    <select name="supplier_id" id="supplier_id" class="form-control select2bs4" data-live-search="true">
      <option value="*">Semua</option>
      <?php foreach($supplier as $s){?>
      <option value="<?php echo $s['id']?>" <?php echo $s['id']==$suppliers_id?'selected':'';?>><?php echo strtolower($s['nama'])?></option>
      <?php } ?>
    </select>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button onclick="filters()" class="btn btn-info btn-sm">Filter</button>
      <button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert alert-success">
        Periode : <?php echo format_tanggal($tanggal1) ?> s.d <?php echo format_tanggal($tanggal2) ?>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Bagian</th>
                  <th>Tipe Pembayaran</th>
                  <th>Tanggal</th>
                  <th>Nama Supplier</th>
                  <th>Nama Item</th>
                  <th colspan="2"><center>Jumlah</center></th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php $total=0;?>
                <?php foreach($items as $i){?>
                  <?php foreach($i['prods'] as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td>
                        <?php 
                          if($i['jenis']==1){
                            echo "Konveksi";
                          }else if($i['jenis']==2){
                            echo "Bordir";
                          }else if($i['jenis']==3){
                            echo "Alat-alat Konveksi";
                          }else if($i['jenis']==4){
                            echo "Sablon";
                          }else{
                            echo "Default";
                          }
                        ?>
                      </td>
                      <td><?php echo $i['tipepembayaran']?></td>
                      <td><?php echo format_tanggal($i['tanggal'])?></td>
                      <td><?php echo strtolower($i['supplier']) ?></td>
                      <td><?php echo strtolower($p['nama']) ?></td>
                      <td align="center"><?php echo $p['jumlah']?> <?php echo $p['satuanJml']?></td>
                      <td><?php echo $p['ukuran']?> <?php echo $p['satuanukuran']?></td>
                      <td align="right"><?php echo format_angka($p['harga'])?></td>
                      <?php if($i['jenis']==1){?>
                        <?php $total+=($p['harga']*$p['ukuran'])?>
                      <td><?php echo format_angka($p['harga']*$p['ukuran'])?></td>
                      <?php }else{ ?>
                        <?php $total+=($p['harga']*$p['ukuran'])?>
                        <td><?php echo format_angka($p['harga']*$p['jumlah'])?></td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="9">
                    <center><b>Total</b></center>
                  </td>
                  <td align="left">
                    <b><?php echo format_angka($total) ?></b>
                  </td>
                </tr>
              </tfoot>
            </table>
  </div>
</div>
<script type="text/javascript">
  
  function filters(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    var filter_status = $('select[name=\'supplier_id\']').val();

    if (filter_status != '*') {
      url += '&supplier=' + encodeURIComponent(filter_status);
    }


    location=url;
  }

  function excel(){
    var url='?excel=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }


    var filter_status = $('select[name=\'supplier_id\']').val();

    if (filter_status != '*') {
      url += '&supplier=' + encodeURIComponent(filter_status);
    }

    location=url;
  }
</script>