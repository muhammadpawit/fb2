<div class="row">
  <div class="form-group">
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
            </div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
    <table class="table table-bordered">
      <thead>
        <tr style="text-align: center!important;" valign="top">
          <th rowspan="2" style="vertical-align : middle;text-align:center;">#</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Tanggal</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Trf</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Kas Diterima</th>
          <th colspan="3">Kas Konveksi</th>
          <th colspan="3">Kas Bordir</th>
          <th colspan="3">Kas Sablon</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Ket</th>
        </tr>
        <tr>
          <th class="tg-0lax">TRF</th>
          <th class="tg-0lax">Masuk</th>
          <th class="tg-0lax">Sisa</th>
          <th class="tg-0lax">TRF</th>
          <th class="tg-0lax">Masuk</th>
          <th class="tg-0lax">Sisa</th>
          <th class="tg-0lax">TRF</th>
          <th class="tg-0lax">Masuk</th>
          <th class="tg-0lax">Sisa</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($products as $p){?>
          <?php $hari= date('l',strtotime($p['tanggal']))?>
        <tr>
          <td>#</td>
          <td><?php echo hari($hari).', '.date('d-m-Y',strtotime($p['tanggal']))?></td>
          <td></td>
          <td><?php echo number_format($p['kasmasuk'])?></td>
          <td></td>
          <td><?php echo number_format($p['masukkonveksi'])?></td>
          <td><?php echo number_format($p['masukkonveksi']-$p['keluarkonveksi'])?></td>
          <td></td>
          <td><?php echo number_format($p['masukbordir'])?></td>
          <td><?php echo number_format($p['masukbordir']-$p['keluarbordir'])?></td>
          <td></td>
          <td><?php echo number_format($p['masuksablon'])?></td>
          <td><?php echo number_format($p['masuksablon']-$p['keluarsablon'])?></td>
          <td><?php echo $p['keterangan']?></td>
        </tr>
        <?php if($p['konveksi']){?>
          <?php foreach($p['konveksi'] as $k){?>
            <tr>
              <td></td>
              <td></td>
              <td><?php echo number_format($k['nominal'])?></td>
              <td></td>
              <td>
                <?php if($k['bagian']==1){?>
                  <?php echo number_format($k['nominal'])?>
                <?php } ?>
              </td>
              <td></td>
              <td></td>
              <td>
                <?php if($k['bagian']==2){?>
                  <?php echo number_format($k['nominal'])?>
                <?php } ?>
              </td>
              <td></td>
              <td></td>
              <td>
                <?php if($k['bagian']==3){?>
                  <?php echo number_format($k['nominal'])?>
                <?php } ?>
              </td>
              <td></td>
              <td></td>
              <td><?php echo strtolower($k['keterangan'])?></td>
            </tr>
          <?php } ?>
        <?php } ?>
      <?php } ?>
      </tbody>
    </table>
    </div>
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