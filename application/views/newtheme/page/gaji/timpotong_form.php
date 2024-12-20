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
		<label>Tim Potong</label><br>
		<select name="tim" class="form-control select2bs4" data-live-search="true" required>
			<option value="*">Pilih</option>
			<?php foreach($tp as $t){?>
				<option value="<?php echo $t['id']?>"><?php echo strtolower($t['nama'])?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="tambahan()">Tambahan</button>
		</div>
	</div>
</div>
<form method="post" action="<?php echo $action?>">
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama PO</th>
					<th>JML PO (Dz)</th>
					<th>JML PO (Pcs)</th>
					<th>Pembayaran %</th>
					<th>Harga/Pcs</th>
					<th>Total Pendapatan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<?php $buku=1; ?>
			<tbody id="listajuan">
				<input type="hidden" name="total" value="<?php echo $totals?>">
				<input type="hidden" name="saving" value="<?php echo $savings?>">
				<input type="hidden" name="nominal" value="<?php echo $nominals?>">
				<?php foreach($products as $p){?>
					<?php if($p['total'] > 0){ ?>
					<input type="hidden" name="products[<?php echo $p['no']?>][tanggal]" value="<?php echo $p['tanggal']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][idpo]" value="<?php echo $p['idpo']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][kode_po]" value="<?php echo $p['idpo']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][lusin]" value="<?php echo $p['lusin']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][pcs]" value="<?php echo $p['pcs']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][harga]" value="<?php echo $p['price']?>">
					<input type="hidden" name="products[<?php echo $p['no']?>][total]" value="<?php echo $p['totals']?>">
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kodepo']?></td>
						<td><?php echo $p['lusin']?></td>
						<td><?php echo $p['pcs']?></td>
						<td>
							<select name="products[<?php echo $p['no']?>][perkalian]">
								<option value="1" <?php echo ($p['full']==1)?'selected':'';?>>100%</option>
								<option value="0.5" <?php echo ($p['full']==2)?'selected':'';?>>50%</option>
								<option value="0">0%</option>
							</select>
						</td>
						<td><?php echo $p['harga']?></td>
						<td><?php echo $p['total']?></td>
						<td></td>
					</tr>
					<?php $buku++; ?>
					<?php } ?>
				<?php } ?>
				
			</tbody>
			<tfoot>
				
			<tr>
					<td colspan="7"><b></b></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="7"><b>Total</b></td>
					<td><b><?php echo $total?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="7"><b>Saving 5%</b></td>
					<td><b><?php echo $saving?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="7"><b>Total yang diterima</b></td>
					<td><b><?php echo $nominal?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php if(!empty($products)){?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Untuk Periode </label>
			<input type="text" name="periode" class="form-control" required="required">&nbsp;
			<input type="hidden" name="tim" class="form-control" value="<?php echo $tim?>">&nbsp;
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Potongan Claim </label>
			<input type="text" name="nominal" value="0" class="form-control" required="required">&nbsp;
			<input type="hidden" name="tim" class="form-control" value="<?php echo $tim?>">&nbsp;
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Keterangan Claim </label>
			<input type="text" name="keterangan" class="form-control" required="required">&nbsp;
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-md-12">
		<button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
		<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
	function filter(){
		var url='?';
		var filter_date_start = $('input[name=\'tanggal1\']').val();

		if (filter_date_start) {
			url += '&tanggal1=' + encodeURIComponent(filter_date_start);
		}

	  var filter_date_end = $('input[name=\'tanggal2\']').val();

		if (filter_date_end) {
			url += '&tanggal2=' + encodeURIComponent(filter_date_end);
		}

	  var filter_status = $('select[name=\'tim\']').val();

		if (filter_status != '*') {
			url += '&tim=' + encodeURIComponent(filter_status);
		}

		if(filter_status=="*"){
			alert("Tim harus dipilih");
			return false;
		}
		location =url;
	}


	let i=<?php echo $buku ?>;
	function tambahan() {
    	var html='<tr>';
        html+='<td>'+i+'</td>';
        html+='<td><input type="text" name="products['+i+'][tanggal]" class="form-control datepicker" required="required"</td>';
        
        html+='<td><input type="text" name="products['+i+'][kode_po]" class="" required="required"></td>';
        html+='<td><input type="text" name="products['+i+'][dz]" onblur="jumlahpo('+i+')" class="" required="required" value="0" ></td>';
        html+='<td><input type="text" name="products['+i+'][pcs]" onblur="udz('+i+')" class="" required="required" value="0"></td>';
		html += '<td><select name="products['+i+'][perkalian]">';
		html += '<option value="1">100%</option>';
		html += '<option value="0.5">50%</option>';
		html += '<option value="0">0%</option>';
		html += '</select></td>';
		html+='<td width="50"><input type="text" name="products['+i+'][harga]" onblur="hargatotal('+i+')" required="required" value="0"></td>';
		html+='<td width="50"><span class="pendapatan'+i+'"></span></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $("#listajuan").append(html);
        //$(".select2bs4").select2();
        i++;

		$.fn.datepicker.defaults.format = "yyyy-mm-dd";
		$('.datepicker').datepicker({
			
		autoclose: true
		});
  	}

	function jumlahpo(k){
		total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    dz=$("input[name='products["+k+"][dz]']").val();
                    $("input[name='products["+k+"][pcs]']").val((dz*12));
                    j++;
                }
            }
	}

	function udz(k){
		total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    dz=$("input[name='products["+k+"][pcs]']").val();
                    $("input[name='products["+k+"][dz]']").val((dz/12));
                    j++;
                }
            }
	}

	function hargatotal(k){
		total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    harga=$("input[name='products["+k+"][harga]']").val();
					pcs=$("input[name='products["+k+"][pcs]']").val();
                    $('.pendapatan'+k+'').html(Number(harga)*Number(pcs));
                    j++;
                }
            }
	}

	$(document).on('click', '.remove', function(){

			$(this).closest('tr').remove();

		});

</script>