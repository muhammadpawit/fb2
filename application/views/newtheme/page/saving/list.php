<div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tanggal Awal</label>
                  <input type="text" name="tanggal1" value="<?php echo $tanggal1?>" id="tanggal1" class="form-control">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="text" name="tanggal2" value="<?php echo $tanggal2?>" id="tanggal2" class="form-control">
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
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Action</label><br>
                  <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
                  <button onclick="excels()" class="btn btn-info btn-sm">Excel</button>
                </div>
              </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Periode</th>
          <th>Jumlah (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($products as $p){?>
          <tr>
            <td><?php echo $p['no']?></td>
            <td><?php echo $p['nama']?></td>
            <td><?php echo $p['periode']?></td>
            <td><?php echo number_format($p['jumlah'])?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><b>Total</b></td>
          <td><?php echo number_format($total)?></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var tim=$("#tim").val();
    
    
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(tim!='*'){
      url+='&cmt='+tim;
    }


    location = url;
  }

  function excels(){
     var url='?excel=1';
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