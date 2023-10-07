<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?php echo date('Y-m-d') ?>" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value=""></option>
                <option value="1">Claim</option>
                <option value="2">Kasbon</option>
            </select>
          </div>
          <div class="form-group">
            <label>Nama CMT</label>
            <select name="idcmt" class="form-control select2bs4" style="width: 100%;" required>
                <option value=""></option>
                <?php foreach($cm as $c){?>
                <option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" autocomplete="off" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" required="required" name="keterangan"></textarea>
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
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" autocomplete="off" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
  <div class="col-md-3">
		<div class="form-group">
			<label>CMT</label>
			<select name="cmt" id="cmt" class="form-control select2bs4">
        <option value="*"></option>
        <?php foreach($cm as $c){ ?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt ? 'selected':'';?>><?php echo $c['cmt_name']?></option>
        <?php } ?>
      </select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterwithcmt()">Filter</button>
			<span class=""><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></span>
      <button class="btn btn-success btn-sm" onclick="excelwithtglcmt()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <table class="table table-bordered yessearch">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama CMT</th>
            <th>Nominal</th>
            <th>Sisa</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1;?>
        <?php foreach ($prods as $data): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['tanggal']; ?></td>
            <td><?php echo $data['namacmt']; ?></td>
            <td><?php echo number_format($data['harga'],2); ?></td>
            <td><?php echo number_format($data['sisa'],2); ?></td>
            <td><?php echo $data['keterangan']; ?></td>
            <td>
              <a href="<?php echo BASEURL.'Sablon/history/'.$data['type'].'/'.$data['id'] ?>" class="btn btn-xs btn-warning">History</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	</div>
</div>
<script>
  function excelwithtglcmt(){
    var url='?&excel=1';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    var filter_status = $('select[name=\'cmt\']').val();

    if (filter_status != '*') {
      url += '&cmt=' + encodeURIComponent(filter_status);
    }



    location =url;
  }

</script>