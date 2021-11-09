
  <div class="row">
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Action</label><br>
              <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
              <a href="<?php echo $tambah?>" class="btn btn-info btn-sm">Tambah</a>
              <!-- <button class="btn btn-info btn-sm" onclick="excel()">Excel</button> -->
          </div>
      </div>
  </div>
<table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p){?>
                	<tr>
                		<td><?php echo $p['tanggal']?></td>
                		<td><?php echo $p['total']?></td>
                		<td><?php echo $p['keterangan']?></td>
                		<td>
                			<?php if(akseshapus()==1){?>
                				<a href="<?php echo $p['hapus']?>" class="btn btn-danger btn-sm">Hapus</a>
                			<?php } ?>
                		</td>
                	</tr>
                <?php } ?>
              </tbody>
            </table>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

   

    location=url;
  }

   function excel(){
    var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }
</script>