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
                  <th>Nama Karyawan</th>
                  <th>Total Gaji</th>
                  <th>Total Pembulatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach($rekap as $r){?>
                  <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo $r['nama_karyawan_benang']?></td>
                    <td><?php echo number_format($r['total'])?></td>
                    <td><?php echo number_format($r['totalpembulatan'])?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetail<?php echo $r['id_pekerja']?>">
                          Detail
                        </button>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
	</div>
</div>

<!-- Modals -->
<?php foreach($pekerja as $p){ ?>
<div class="modal fade" id="modalDetail<?php echo $p['id_pekerja']?>" tabindex="-1" role="dialog" aria-labelledby="label<?php echo $p['id_pekerja']?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="label<?php echo $p['id_pekerja']?>">Detail Gaji: <?php echo $p['pekerja']?> (<?php echo date('d F Y', strtotime($tanggal1)) ?> - <?php echo date('d F Y', strtotime($tanggal2)) ?>)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>PO</th>
                    <th>Bagian</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($p['products'] as $prod){ ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($prod['created_date'])) ?></td>
                    <td><?php echo $prod['kode_po'] ?></td>
                    <td><?php echo $prod['bagian_buang_benang'] ?></td>
                    <td><?php echo $prod['size_buang_benang'] ?></td>
                    <td><?php echo $prod['qty_buang_benang'] ?></td>
                    <td><?php echo number_format($prod['harga_buang_benan']) ?></td>
                    <td><?php echo number_format($prod['qty_buang_benang'] * $prod['harga_buang_benan']) ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" align="right"><b>Total</b></td>
                    <td><b><?php echo number_format($p['total']) ?></b></td>
                </tr>
            </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
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