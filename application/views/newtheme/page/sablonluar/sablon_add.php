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
			<a href="<?php echo base_url()?>Sablonluar/sablon_add" class="btn btn-danger btn-sm text-white" id="reset" style="display: none">Reset</a>
			<button id="simpan" class="btn btn-primary btn-sm text-white"><i class="fa fa-save"></i> Simpan</button>
			<button id="klikexcel" class="btn btn-info btn-sm text-white">Excel</button>
		</div>
	</div>
</div>
<?php echo isset($cm)?($cm['cmt_name']):'';?>
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
								<input type="hidden" name="pendapatan[<?php echo $p['no']?>][id_kelolapo_kirim_setor]" value="<?php echo isset($p['id_kelolapo_kirim_setor']) ? $p['id_kelolapo_kirim_setor'] : 0?>">
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
					<?php 
						$pengeluarantotal=0;
						$biayatukang=0;
						$biayalain=0;
					?>
					<?php foreach($pengeluaran as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php echo number_format($p['belanjacat'])?>
								<input type="hidden" name="pengeluaran[<?php echo $p['no']?>][id]" value="<?php echo isset($p['id']) ? $p['id'] : 0?>">
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
							$biayatukang+=($p['upahtukang_harian']+$p['upahtukang_borongan']);
							$biayalain+=($p['biayalain']);
						?>
					<?php } ?>
				</tbody>
			</table>
			<br>
			<?php $komisi=0;$tdzz=0;?>
			<?php foreach(array_unique($pekerjaan) as $p =>$val){?>
								<?php
								$name=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$val));
							?>
						<?php 
							$komisi+=$name['price_group']*array_sum($dzs[$val]);	
						?>
			<?php } ?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Pendapatan</th>
						<th>Pengeluaran</th>
						<th>Sewa</th>
						<th>Saldo</th>
					</tr>
				</thead>
				<tbody>
					<td><?php echo number_format($total)?></td>
					<td><?php echo number_format($pengeluarantotal+$komisi)?></td>
					<td><?php echo number_format($sewa)?></td>
					<td><?php echo number_format($total-$sewa-$pengeluarantotal-$komisi)?></td>
					<input type="hidden" name="total_pendapatan" value="<?php echo $total?>">
					<input type="hidden" name="total_pengeluaran" value="<?php echo $pengeluarantotal+$komisi?>">
					<input type="hidden" name="sewa" value="<?php echo $sewa?>">
				</tbody>
			</table>
			<br>
			<?php if(isset($cm['jenis_pembayaran'])==1){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<!-- <caption>Bagi Hasil</caption>
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
			</table> -->
			<?php } ?>
			<br>
			<?php if(isset($cm['jenis_pembayaran'])==2){?>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
			<caption>Komisi</caption>
			<?php 
				//print_r(array_count_values($pekerjaan));
				//echo json_encode($pendapatan);

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
					<?php //echo json_encode($pekerjaan) ?>
					<?php $b=0;?>
					<?php foreach(array_unique($pekerjaan) as $p =>$val){?>
					<tr>
						<td>
							<?php
								$name=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$val));
								echo !empty($name)?$name['nama_job']:'';
							?>
						</td>
						<td><?php $b=array_sum($dzs[$val]);echo number_format($b,2) ;?></td>
						<td><?php echo number_format($name['price_group'])?></td>
						<td><?php echo number_format($name['price_group']*array_sum($dzs[$val]))?></td>
						<td><?php echo count($dzs[$val]);?> PO </td>
					</tr>
					<?php 
						$tdz+=array_sum($dzs[$val]);
						$tjml+=$name['price_group']*array_sum($dzs[$val]);
						$tpo+=count($dzs[$val]);
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td><b>Potongan Klaim</b></td>
						<td><b></b></td>
						<td></td>
						<td>
							<input type="number" name="potongan_claim" id="potongan_claim" class="form-control" value="<?php echo $pot?>" placeholder="0">
						</td>
						<td><b><?php echo $pot_ket?></b>
							<input type="hidden" name="total_klaim" id="total_klaim" value="<?php echo $pot?>">
						</td>
					</tr>
					<tr>
						<td><b>Total Diterima</b></td>
						<td><b><?php echo number_format($tdz,2)?></b></td>
						<td></td>
						<td><b id="display_komisi_bersih"><?php echo number_format($tjml-$pot)?></b></td>
						<td><b><?php echo $tpo?> PO</b></td>
					</tr>
				</tfoot>
			</table>
			<?php } ?>

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
			
			<caption></caption>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Pembayaran Sablon Mingguan <br><?php echo isset($cm)?($cm['cmt_name']):'';?></th>
						<th>Jumlah (Rp)</th>
					</tr>
				</thead>	
				<tbody>
					<tr>
						<td><input type="checkbox" class="komponen-check" data-id="upahtukang" value="<?php echo $biayatukang ?>" checked> 1</td>
						<td>Biaya Upah Tukang</td>
						<td><?php echo number_format($biayatukang) ?></td>
					</tr>
					<tr>
						<td><input type="checkbox" class="komponen-check" data-id="komisi" id="check_komisi" value="<?php echo $tjml-$pot ?>" checked> 2</td>
						<td>Komisi</td>
						<td><span id="display_komisi_val"><?php echo number_format($tjml-$pot) ?></span></td>
					</tr>
					<tr>
						<td><input type="checkbox" class="komponen-check" data-id="biayalain" value="<?php echo $biayalain ?>"> 3</td>
						<td>Biaya Lain-lain</td>
						<td><?php echo number_format($biayalain) ?></td>
					</tr>
					<tr>
						<td colspan="2"><b>Jumlah</b></td>
						<td><b id="display_jumlah"><?php echo number_format($biayatukang+$tjml-$pot) ?></b></td>
					</tr>
					<tr>
						<td colspan="2"><b>Total Yang Diterima</b></td>
						<td>
							<b id="display_total_diterima"><?php echo number_format($biayatukang+$tjml-$pot) ?></b>
							<input type="hidden" name="total_komisi" id="input_total_komisi" value="<?php echo $tjml?>">
							<input type="hidden" name="total_upah_tukang" id="input_total_upahtukang" value="<?php echo $biayatukang?>">
							<input type="hidden" name="total_diterima" id="base_total_diterima" value="<?php echo ($biayatukang+$tjml-$pot)?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</form>
<script type="text/javascript">
	
	$('#potongan_claim').on('input', function() {
		var pot_claim = parseFloat($(this).val()) || 0;
		$('#total_klaim').val(pot_claim);
		var tjml = <?php echo isset($tjml) ? (float)$tjml : 0 ?>;
		var komisi_bersih = tjml - pot_claim;
		$('#display_komisi_bersih').text(new Intl.NumberFormat('en-US').format(komisi_bersih));
		
		$('#check_komisi').val(komisi_bersih);
		$('#display_komisi_val').text(new Intl.NumberFormat('en-US').format(komisi_bersih));
		
		$('.komponen-check').trigger('change');
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

	function updateTotalDiterima() {
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
	}

	$('.pinjaman-input').on('input', updateTotalDiterima);

	$('.komponen-check').on('change', function() {
		var total = 0;
		var upahtukang = 0;
		var komisi = 0;
		
		$('.komponen-check:checked').each(function() {
			var val = parseInt($(this).val()) || 0;
			total += val;
			
			if($(this).data('id') == 'upahtukang'){
				upahtukang = val;
			}
			if($(this).data('id') == 'komisi'){
				komisi = <?php echo isset($tjml) ? (float)$tjml : 0 ?>;
			}
		});
		
		$('#display_jumlah').text(new Intl.NumberFormat('en-US').format(total));
		$('#base_total_diterima').val(total);
		$('#input_total_komisi').val(komisi);
		$('#input_total_upahtukang').val(upahtukang);
		
		updateTotalDiterima();
	});

	$( "#simpan" ).click(function(event){
		event.preventDefault();
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
</script>