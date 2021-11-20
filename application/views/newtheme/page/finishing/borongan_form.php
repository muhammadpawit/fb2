    	
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Input Borongan</h3>
		          <div class="card-tools">
		            
		          </div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo $action?>">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Tanggal</label>
									<input type="text" value="<?php echo date('Y-m-d');?>" name="creted_date" class="form-control datepicker">
								</div>
								<div class="form-group">
									<label>Nama Karyawan</label>
									<select name="idkaryawanharian" class="form-control select2bs4" data-live-search="true">
										<option value="">Pilih</option>
										<?php foreach($karyawan as $k){?>
											<option value="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Kategori</label>
			                        <select class="form-control select2bs4" name="kategoriBorongan" data-live-search="true">
			                            <option value="LOBANG KANCING" <?php echo $jenis==1?'selected':'disabled';?>>LOBANG KANCING</option>
			                            <option value="PASANG KANCING" <?php echo $jenis==2?'selected':'disabled';?>>PASANG KANCING</option>
			                            <option value="TRESS" <?php echo $jenis==3?'selected':'disabled';?>>TRESS</option>
			                        </select>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-12">
								<table class="table table-bordered" id="item_table">
			                        <tr>
			                            <th>Nama PO</th>
			                            <th>Jumlah PC</th>
			                            <th>Jumlah Titik (PO KFB , ISI DENGAN 5.5)</th>
			                            <th>Harga Per Titik</th>
			                            <!--<th>Jumlah RP</th>-->
			                            <th>Perkalian</th>
			                            <th>Keterangan</th>
			                            <th><button type="button" name="add" class="btn btn-success btn-sm addborongan"><i class="fa fa-plus"></i></button></th>
			                        </tr>
			                    </table>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<a href="<?php echo $batal?>" class="btn btn-danger" style="width: 100%">Batal</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<button type="submit" class="btn btn-success" style="width: 100%">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- <link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />	
 <script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script> -->	
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.addborongan', function(){
        var html = '';
        html += '<tr>';
        html += '<td><select type="text" class="form-control selectpicker kodepo" name="kodepo[]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control jumlahPc" name="jumlahpcs[]"  required ></td>';
        html += '<td><input type="text" class="form-control jumlahtitik"  name="jumlahtitik[]" required ></td>';
        html += '<td><input type="number" class="form-control jumlah" name="pricePerTitik[]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required ></td>';
        html += '<td><select name="perkalian[]" class="form-control"><option value="1">1</value></select></td>';
        html += '<td><input type="text" class="form-control keterangan" name="keterangan[]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
        $('.selectpicker').selectpicker('refresh');
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'finishing/kirimgudangsendRincinan' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".jumlahPc").val(obj.jumlah_pcs_po);
        });
    });
});
 </script>	