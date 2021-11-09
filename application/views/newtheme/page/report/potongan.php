<div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tanggal Awal</label>
                  <input type="date" name="tanggal1" value="<?php echo $tanggal1?>" id="tanggal1" class="form-control">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="tanggal2" value="<?php echo $tanggal2?>" id="tanggal2" class="form-control">
                </div>
              </div>
              <div class="col-sm-3">
                <label>Tim Potong</label>
                <select name="tim" id="tim" class="form-control select2bs4" data-live-search="true">
                  <option value="*">Pilih</option>
                  <?php foreach($timpotong as $t){?>
                    <option value="<?php echo $t['id']?>" <?php echo $tim==$t['id']?'selected':'';?>><?php echo $t['nama']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-3">
                <label>NAMA PO </label>
                <select name="jenis" id="jenis" class="form-control select2bs4"  data-live-search="true">
                  <option value="*">Pilih</option>
                  <?php foreach($jenis as $t){?>
                    <option value="<?php echo $t['nama_jenis_po']?>" <?php echo $jeniss==$t['nama_jenis_po']?'selected':'';?>><?php echo $t['nama_jenis_po']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Action</label><br>
                  <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
                  <a onclick="excelpotongan()" class="btn btn-info btn-sm text-white" target="_blank">Excel</a>
                </div>
              </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Tim Potong</th>
                  <th>Nama PO</th>
                  <th>Roll Bahan</th>
                  <th>Panjang Gelaran</th>
                  <th>Pemakaian Bahan Kaos</th>
                  <th>Pemakaian Bahan Celana</th>
                  <th>Size</th>
                  <th>Jml PO (Dz)</th>
                  <th>Jml PO (Pcs)</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo $p['timpotong']?></td>
                      <td><?php echo $p['kode_po']?></td>
                      <td><?php echo $p['roll_utama']?> Roll</td>
                      <td><?php echo $p['panjang_gelaran_potongan_utama']?><?php echo $p['panjang_gelaran_variasi']?></td>
                      <td><?php echo $p['pemakaian_bahan_utama']?></td>
                      <td><?php echo $p['jumlah_pemakaian_bahan_variasi']?></td>
                      <td><?php echo $p['size_potongan']?></td>
                      <td><?php echo number_format($p['lusin'],2)?></td>
                      <td><?php echo $p['pcs']?></td>
                    </tr>
                  <?php } ?>
                    <tr>
                      <td colspan="8"><b>Total</b></td>
                      <td></td>
                      <td><?php echo $totaldz?></td>
                      <td><?php echo $totalpcs?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var tim=$("#tim").val();
    var jenis=$("#jenis").val();
    
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(tim!='*'){
      url+='&tim='+tim;
    }

    if(jenis!='*'){
      url+='&jenis='+jenis;
    }

    location = url;
  }

  function excelpotongan(){
     var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var tim=$("#tim").val();
    var jenis=$("#jenis").val();
    
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(tim!='*'){
      url+='&tim='+tim;
    }

    if(jenis!='*'){
      url+='&jenis='+jenis;
    }

    location = url;
  }
</script>