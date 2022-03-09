<div class="row">
            <div class="col-md-3">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
            </div>
            <div class="col-md-3">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
            </div>
            <div class="col-md-3">
              <label>Bagian</label>
              <select name="cat" id="cat" class="form-control select2bs4">
                <option value="*">Semua</option>
                <option value="0" <?php echo $cat=='0'?'selected':'';?>>Default</option>
                <option value="1" <?php echo $cat==1?'selected':'';?>>Konveksi</option>
                <option value="2" <?php echo $cat==2?'selected':'';?>>Bordir</option>
              <option value="3" <?php echo $cat==3?'selected':'';?>>Sablon</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Action</label><br>
              <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
              <button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
              <a href="<?php echo $kembali?>" class="btn btn-sm btn-info btn-sm">Kembali</a>
            </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="100">Tanggal</th>
                  <th>Divisi</th>
                  <th>Keterangan</th>
                  <th>Saldomasuk</th>
                  <th>Saldokeluar</th>
                  <th>Sisa</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1?>
                <?php foreach($mutasi as $m){?>
                  <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo date('d-m-Y',strtotime($m['tanggal'])) ?></td>
                    <td>
                      <?php 
                        if($m['bagian']==1){
                          echo "Konveksi";
                        }else if($m['bagian']==2){
                          echo "Bordir";
                        }else if($m['bagian']==3){
                          echo "Sablon";
                        }else{
                          echo "Default";
                        }
                      ?>
                    </td>
                    <td><?php echo $m['keterangan']?></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldomasuk'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldokeluar'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldo'])?></p></td>
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

    location=url;
  }

  function excel(){
    var url='?excel=1';
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

    location=url;
  }


</script>  