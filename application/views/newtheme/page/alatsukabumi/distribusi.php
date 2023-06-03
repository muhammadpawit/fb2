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
            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d')?>" required="required">
          </div>
          <div class="form-group">
            <label>Pilih CMT</label>
            <select name="idcmt" style="width:100%" class="form-control select2bs4" required="required">
                <option value="">Pilih</option>
                <?php foreach($cmt as $p){?>
                  <option value="<?php echo $p['id_cmt']?>"><?php echo strtoupper($p['cmt_name'])?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Pilih alat</label>
            <select name="id_persediaan" style="width:100%" class="form-control select2bs4 alat" required="required">
                <option value="">Pilih</option>
                <?php foreach($alat as $p){?>
                  <option value="<?php echo $p['id_persediaan']?>" data-item="<?php echo $p['id_persediaan']?>"><?php echo strtoupper($p['nama'])?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control jumlah" required="required">
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
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control" autocomplete="off">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control" autocomplete="off">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<a data-toggle="modal" data-target="#myModal" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
                    <th>Nama CMT</th>
					<th>Nama Alat</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Keterangan</th>
					<th>
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['nama']?></td>
            <td><?php echo $p['alat']?></td>
						<td><?php echo $p['jumlah']?></td>
						<td><?php echo $p['satuan']?></td>
						<td><?php echo $p['keterangan']?></td>
						<td>
							<?php if(akseshapus()==1){ ?>
                <?php if($p['validasi']==0){ ?>
                                <a href="<?php echo BASEURL.'Alatsukabumi/distribusi_hapus/'.$p['id'] ?>"
                                class="btn btn-xs btn-danger"
                                onClick="return confirm('Apakah yakin akan menghapus data ini?') "
                                ><i class="fa fa-trash"></i></a>
                                <?php } ?>
                                <?php } ?>

                  <?php if($p['validasi']==0){ ?>

                    <a href="<?php echo BASEURL.'Alatsukabumi/distribusi_validasi/'.$p['id'] ?>"
                                class="btn btn-xs btn-primary"
                                onClick="return confirm('Apakah yakin akan memvalidasi data ini?') "
                                ><i class="fa fa-check"></i> validasi</a>

                  <?php }else{ ?>
                    <span class="badge bg-green">sudah divalidasi</span>
                    <?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script>
            $(document).on('change', '.alat', function(e){
            var dataItem = $(this).find(':selected').data('item');
            $.get( "<?php echo BASEURL.'Alatsukabumi/cariproduct' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                if(obj.stock==0){
                    $(".jumlah").val(obj.stock);
                    $(".jumlah").attr('disabled',true);
                }else{
                    $(".jumlah").val(obj.stock);
                    $(".jumlah").attr('disabled',false);
                }
            });
        });
</script>