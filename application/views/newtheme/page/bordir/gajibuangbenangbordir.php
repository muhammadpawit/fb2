<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>PO</th>
                  <th>Bagian</th>
                  <th>Size</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p){?>
                  <tr>
                    <td><?php echo $p['no']?></td>
                    <td><?php echo $p['tanggal']?></td>
                    <td><?php echo $p['pekerja']?></td>
                    <td><?php echo $p['kode_po']?></td>
                    <td><?php echo $p['bagian']?></td>
                    <td><?php echo $p['size']?></td>
                    <td><?php echo $p['qty']?></td>
                    <td><?php echo $p['harga']?></td>
                    <td><?php echo number_format($p['total'])?></td>
                  </tr>

                <?php }?>
              </tbody>
            </table>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		var url ='?&excel=1';
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