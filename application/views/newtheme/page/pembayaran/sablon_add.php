<form method="post" action="<?php echo $action?>">
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1; ?>" placeholder="tanggal awal">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2; ?>" placeholder="tanggal akhir">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select name="idcmt" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih CMT</option>
				<?php foreach($cmt as $c){?>
					<option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmtf?'selected':'';?>><?php echo $c['cmt_name']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<button id="klik" class="btn btn-info btn-sm text-white">Kalkulasi</button>
			<a href="<?php echo BASEURL?>Pembayaran/sablon_add" class="btn btn-danger btn-sm text-white" id="reset" style="display: none">Reset</a>
			<!-- <button id="simpan" class="btn btn-success btn-sm text-white">Simpan</button> -->
			<button id="simpan" class="btn btn-primary btn-sm text-white"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
</div>
<?php echo !empty($cm) ? ($cm['cmt_name']) : ''; ?>
	<div class="row">
		<div class="col-md-6">
			<label>Pendapatan</label>
			<table class="table table-bordered listsablon">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>DZ</th>
						<th>PCS</th>
						<th>Harga</th>
						<th>Total</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $dz=0;$pcs=0;$harga=0;$total=0; ?>
					<?php foreach($pendapatan as $p){?>
						<?php 
							$pekerjaan[]=$p['pekerjaan'];
							$dzs[$p['pekerjaan']][]=$p['dz'];
						?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php echo $p['namapo']?>
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][id_kelolapo_kirim_setor]" value="<?php echo $p['id_kelolapo_kirim_setor']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][namapo]" value="<?php echo $p['namapo']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][dz]" value="<?php echo $p['dz']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][pcs]" value="<?php echo $p['pcs']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][harga]" value="<?php echo $p['harga']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][total]" value="<?php echo $p['total']?>">
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][pekerjaan]" value="<?php echo $p['pekerjaan']?>">
							</td>
							<td><?php echo number_format($p['dz'],2)?></td>
							<td><?php echo number_format($p['pcs'])?></td>
							<td><?php echo number_format($p['harga'])?></td>
							<td><?php echo number_format($p['total'])?></td>
							<td><?php echo $p['ket']?></td>
						</tr>
					<?php
						$dz+=($p['dz']);
						$pcs+=($p['pcs']);
						$harga+=($p['harga']);
						$total+=($p['total']);
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td><b>Total</b></td>
						<td></td>
						<td><?php echo number_format($dz,2)?></td>
						<td><?php echo number_format($pcs)?></td>
						<td><?php echo number_format($harga)?></td>
						<td><?php echo number_format($total)?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="col-md-6">
			<label>Pengeluaran</label>
			<table class="table table-bordered listpengeluaran">
				<thead>
					<tr>
						<th>No</th>
						<th>Pembelanjaan Cat dan Afdruk</th>
						<th>Upah Tukang Harian</th>
						<th>Upah Tukang Borongan</th>
						<th>Biaya Lain-lain</th>
						<th>Token Listrik</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $pengeluarantotal=0;$total_tukang_borongan=0;?>
					<?php foreach($pengeluaran as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php echo number_format($p['belanjacat'])?>
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][id]" value="<?php echo $p['id']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][belanjacat]" value="<?php echo $p['belanjacat']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][upahtukang_harian]" value="<?php echo $p['upahtukang_harian']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][upahtukang_borongan]" value="<?php echo $p['upahtukang_borongan']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][biayalain]" value="<?php echo $p['biayalain']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][tokenlistrik]" value="<?php echo $p['tokenlistrik']?>">
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][total]" value="<?php echo $p['total']?>">
							</td>
							<td><?php echo number_format($p['upahtukang_harian'])?></td>
							<td><?php echo number_format($p['upahtukang_borongan'])?></td>
							<td><?php echo number_format($p['biayalain'])?></td>
							<td><?php echo number_format($p['tokenlistrik'])?></td>
							<td><?php echo number_format($p['total'])?></td>
						</tr>
						<?php 
							$pengeluarantotal+=($p['total']);
							$total_tukang_borongan+=($p['upahtukang_harian']+$p['upahtukang_borongan']);
						?>
					<?php } ?>
				</tbody>
			</table>
			<br>
					<?php $tdz=0;$tjml=0;$tpo=0;?>
					<?php foreach($rekap as $r){?>
						
						<?php 
							$tdz+=($r['dz']);
							$tjml+=($r['jumlah']);
						?>
					<?php } ?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Pendapatan</th>
						<th>Pengeluaran</th>
						<th>Sewa</th>
						<th>Provit</th>
					</tr>
				</thead>
				<tbody>
					<td><?php echo number_format($total)?></td>
					<td><?php echo number_format($pengeluarantotal+$tjml)?></td>
					<td><?php echo number_format($sewa)?></td>
					<td><?php echo number_format($total-$sewa-($pengeluarantotal+$tjml))?></td>
					<input type="hidden" name="total_pendapatan" value="<?php echo $total?>">
					<input type="hidden" name="total_pengeluaran" value="<?php echo $pengeluarantotal+$tjml?>">
					<input type="hidden" name="sewa" value="<?php echo $sewa?>">
				</tbody>
			</table>
			<br>
			<label>Potongan Klaim / Kasbon</label>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Type</th>
						<th>Keterangan</th>
						<th>Nominal</th>
						<th>Sisa Klaim</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($claim as $c){ ?>
					<tr>
						<td><?php echo $c['tanggal'] ?></td>
						<td><?php echo $c['type'] ?></td>
						<td><?php echo $c['keterangan'] ?></td>
						<td><?php echo number_format($c['nominal']) ?></td>
						<td>
							<?php echo number_format($c['sisa']) ?>
							<input type="hidden" name="klaim[<?php echo $c['id']?>][idclaim_sablon]" value="<?php echo $c['id']?>">
							<input type="hidden" name="klaim[<?php echo $c['id']?>][nominal_potong]" value="<?php echo $c['sisa']?>">
						</td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">Total Potongan Klaim</td>
						<td>
							<input type="number" name="potongan_claim" id="potongan_claim" class="form-control" value="<?php echo $totalclaim ?>" placeholder="0">
							<input type="hidden" name="total_klaim" id="total_klaim" value="<?php echo $totalclaim?>">
							<input type="hidden" name="total_komisi" value="<?php echo $tjml?>">
							<input type="hidden" name="total_upah_tukang" value="<?php echo $total_tukang_borongan?>">
							<input type="hidden" name="total_diterima" id="base_total_diterima" value="<?php echo ($tjml+$total_tukang_borongan-$totalclaim)?>">
						</td>
					</tr>
				</tfoot>
			</table>
			<br>
			<?php if(isset($pinjaman) && !empty($pinjaman)){ ?>
			<label>Potongan Pinjaman</label>
			<table class="table table-bordered">
				<?php foreach($pinjaman as $pj){ ?>
				<tr>
					<td style="width: 50px; text-align: center;">
						<input type="checkbox" class="pinjaman-check" data-id="<?php echo $pj['id']?>">
					</td>
					<td>Nominal Pinjaman (Tgl <?php echo date('d-m-Y',strtotime($pj['tanggal']))?>, Sisa: Rp <?php echo number_format($pj['totalpinjaman'] - $pj['totalpotongan']) ?>)</td>
					<td>
						<input type="number" name="potongan_pinjaman[<?php echo $pj['id']?>]" id="input_pinjaman_<?php echo $pj['id']?>" class="form-control pinjaman-input" value="0" max="<?php echo ($pj['totalpinjaman'] - $pj['totalpotongan']) ?>" disabled>
					</td>
				</tr>
				<?php } ?>
			</table>
			<br>
			<?php } ?>
			<?php if(!empty($cm) && $cm['jenis_pembayaran']==1){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Bagi Hasil</caption>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Forboys (60%)</th>
						<th>CMT (40%)</th>
						
					</tr>
				</thead>
				<tbody>
					<td><?php echo number_format($saldo*0.6)?></td>
					<td><?php echo number_format($saldo*0.4)?></td>
				</tbody>
			</table>
			<?php } ?>
			<br>
			<?php if(!empty($cm) && $cm['jenis_pembayaran']==2){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Komisi</caption>
			<?php 
			$tdz=0;
			$tjml=0;
			$tpo=0;
			?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Jenis Sablon</th>
						<th>Jumlah PO (Dz)</th>
						<th>Harga/dz (Rp)</th>
						<th>Jumlah (Rp)</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					
					<?php } ?>
					<?php $tdz=0;$tjml=0;$tpo=0;?>
					<?php foreach($rekap as $r){?>
						<tr>	
							<td><?php echo $r['jenis']?></td>
							<td><?php echo number_format($r['dz'],2)?></td>
							<td><?php echo $r['harga']?></td>
							<td><?php echo $r['jumlah']?></td>
							<td></td>
						</tr>
						<?php 
							$tdz+=($r['dz']);
							$tjml+=($r['jumlah']);
							//$tpo+=count($dzs[$val]);
						?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
					<td><b>Total Diterima</b></td>
					<td><b><?php echo number_format($tdz,2)?></b></td>
					<td></td>
					<td><b><?php echo number_format($tjml)?></b></td>
					<td><b><?php echo $tpo?></b></td>
					</tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					<tr>
						<td><b>Total Keseluruhan Diterima </b></td>
						<td>Total Upah Tukang Harian & Borongan</td>
						<td></td>
						<td><b><?php echo number_format($total_tukang_borongan)?></b></td>
						<td><b><?php echo $tpo?></b></td>
						
					</tr>

					<tr>
					<td></td>
						<td>Total Diterima Komisi</td>
						<td></td>
						<td><b><?php echo number_format($tjml)?></b></td>
						<td><b><?php echo $tpo?></b></td>
					</tr>
					<tr>
					<td></td>
						<td>Total Diterima Keseluruhan</td>
						<td></td>
						<td><b id="display_total_diterima"><?php echo number_format($tjml+$total_tukang_borongan-$totalclaim)?></b></td>
						<td><b><?php echo $tpo?></b></td>
					</tr>
				</tfoot>
			</table>
			<?php //} ?>
		</div>
	</div>
</form>
<script type="text/javascript">
	
	$('#potongan_claim').on('input', function() {
		var pot_claim = parseFloat($(this).val()) || 0;
		$('#total_klaim').val(pot_claim);
		var tjml = <?php echo isset($tjml) ? (float)$tjml : 0 ?>;
		var upah_tukang = <?php echo isset($total_tukang_borongan) ? (float)$total_tukang_borongan : 0 ?>;
		var base_total = tjml + upah_tukang - pot_claim;
		$('#base_total_diterima').val(base_total);
		$('.pinjaman-input').trigger('input');
	});

	$('.pinjaman-check').on('change', function() {
		var id = $(this).data('id');
		var input = $('#input_pinjaman_' + id);
		if($(this).is(':checked')) {
			input.prop('disabled', false);
			var max = parseInt(input.attr('max')) || 0;
			input.val(max);
		} else {
			input.prop('disabled', true);
			input.val(0);
		}
		$('.pinjaman-input').trigger('input');
	});

	$('.pinjaman-input').on('input', function() {
		var base_total = parseInt($('#base_total_diterima').val()) || 0;
		var pot = 0;
		$('.pinjaman-input').each(function(){
			if (!$(this).prop('disabled')) {
				var val = parseInt($(this).val()) || 0;
				var max = parseInt($(this).attr('max')) || 0;
				if (val > max) {
					val = max;
					$(this).val(val);
				}
				pot += val;
			}
		});
		var final_total = base_total - pot;
		$('#display_total_diterima').text(new Intl.NumberFormat('en-US').format(final_total));
	});

	$( "#simpan" ).click(function(event){
		$("form").submit();
	});

	$( "#klik" ).click(function(event){
		var url='?';
		var tanggal1 = $('input[name=\'tanggal1\']').val();

	    if (tanggal1=='') {
	      alert("tanggal awal harus diisi");
	      return false;
	    }else{
			url+='&tanggal1='+tanggal1;
		}

	    var tanggal2 = $('input[name=\'tanggal2\']').val();

	    if (tanggal2=='') {
	      alert("tanggal akhir harus diisi");
	      return false;
	    }else{
			url+='&tanggal2='+tanggal2;
		}
		
		var cmt = $('select[name=\'idcmt\']').val();

		if(cmt=="*"){
			alert("cmt harus dipilih");
	      return false;
		}else{
			url+='&cmt='+cmt;
		}

		$("#klik").prop('disabled',true);
		$("#reset").show();
		location=url;
	/*
	var url='<?php echo base_url();?>Pembayaran/loadk?&tanggal1='+tanggal1+'&tanggal2='+tanggal2+'&cmt='+cmt;
            $('.listsablon').DataTable( {
              "ordering": false,
              "searching":false,
              "paging":false,
              "ajax":{
                      'url': url,
                      'type': 'GET',
                          'beforeSend': function (request) {
                              $('.loader').show();
                          },
                          "dataSrc":function(json){
                              $('.loader').hide();
                              return json.data;
                          }
                    },
              "footerCallback": function ( row, data, start, end, display ) {
		            var api = this.api(), data;
		 
		            // Remove the formatting to get integer data for summation
		            var intVal = function ( i ) {
		                return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                        i : 0;
		            };
		 
		            // Total over all pages
		            totals = api
		                .column( 2 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // Update footer
		            $( api.column(2 ).footer() ).html(
		                ''+ totals.toFixed(2) +''
		            );

		            // Total over all pages
		            total = api
		                .column( 3 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // Update footer
		            $( api.column(3 ).footer() ).html(
		                ''+ total +''
		            );

		            // Total over all pages
		            totalharga = api
		                .column( 4 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // Update footer
		            $( api.column(4 ).footer() ).html(
		                ''+ number_format_js(totalharga) +''
		            );

		            // Total over all pages
		            grand = api
		                .column( 5 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // Update footer
		            $( api.column(5 ).footer() ).html(
		                ''+ number_format_js(grand) +''
		            );

		        }
            });


            var url='<?php echo base_url();?>Pembayaran/pengeluaransablon?&tanggal1='+tanggal1+'&tanggal2='+tanggal2+'&cmt='+cmt;
            $('.listpengeluaran').DataTable( {
              "ordering": false,
              "searching":false,
              "paging":false,
              "ajax":{
                      'url': url,
                      'type': 'GET',
                          'beforeSend': function (request) {
                              $('.loader').show();
                          },
                          "dataSrc":function(json){
                              $('.loader').hide();
                              return json.data;
                          }
                    }
            });
          $(".dataTables_length").hide();


	*/
	});


	$( "#klikexcel" ).click(function(event){
		var url='?&excel=1';
		var tanggal1 = $('input[name=\'tanggal1\']').val();

	    if (tanggal1=='') {
	      alert("tanggal awal harus diisi");
	      return false;
	    }else{
			url+='&tanggal1='+tanggal1;
		}

	    var tanggal2 = $('input[name=\'tanggal2\']').val();

	    if (tanggal2=='') {
	      alert("tanggal akhir harus diisi");
	      return false;
	    }else{
			url+='&tanggal2='+tanggal2;
		}
		
		var cmt = $('select[name=\'idcmt\']').val();

		if(cmt=="*"){
			alert("cmt harus dipilih");
	      return false;
		}else{
			url+='&cmt='+cmt;
		}

		$("#klik").prop('disabled',true);
		$("#reset").show();
		location=url;
	});

	$( "#klikpdf" ).click(function(event){
		var url='?&pdf=1';
		var tanggal1 = $('input[name=\'tanggal1\']').val();

	    if (tanggal1=='') {
	      alert("tanggal awal harus diisi");
	      return false;
	    }else{
			url+='&tanggal1='+tanggal1;
		}

	    var tanggal2 = $('input[name=\'tanggal2\']').val();

	    if (tanggal2=='') {
	      alert("tanggal akhir harus diisi");
	      return false;
	    }else{
			url+='&tanggal2='+tanggal2;
		}
		
		var cmt = $('select[name=\'idcmt\']').val();

		if(cmt=="*"){
			alert("cmt harus dipilih");
	      return false;
		}else{
			url+='&cmt='+cmt;
		}

		$("#klik").prop('disabled',true);
		$("#reset").show();
		window.open(url, '_blank');
	});
</script>