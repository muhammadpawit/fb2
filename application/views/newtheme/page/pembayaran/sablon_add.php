<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" placeholder="tanggal awal">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" placeholder="tanggal akhir">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select name="cmt" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih CMT</option>
				<?php foreach($cmt as $c){?>
					<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<button id="klik" class="btn btn-info btn-sm text-white">Kalkulasi</button>
			<a href="<?php echo base_url()?>Pembayaran/sablon_add" class="btn btn-danger btn-sm text-white" id="reset" style="display: none">Reset</a>
			<button id="simpan" class="btn btn-success btn-sm text-white">Simpan</button>
		</div>
	</div>
</div>
<form method="post" action="<?php echo $action?>">
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
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['namapo']?></td>
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
					<?php $pengeluarantotal=0;?>
					<?php foreach($pengeluaran as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo number_format($p['belanjacat'])?></td>
							<td><?php echo number_format($p['upahtukang_harian'])?></td>
							<td><?php echo number_format($p['upahtukang_borongan'])?></td>
							<td><?php echo number_format($p['biayalain'])?></td>
							<td><?php echo number_format($p['tokenlistrik'])?></td>
							<td><?php echo number_format($p['total'])?></td>
						</tr>
						<?php $pengeluarantotal+=($p['total']);?>
					<?php } ?>
				</tbody>
			</table>
			<br>
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
					<td><?php echo number_format($pengeluarantotal)?></td>
					<td><?php echo number_format($sewa)?></td>
					<td><?php echo number_format($total-$sewa-$pengeluarantotal)?></td>
				</tbody>
			</table>
			<br>
			<?php $saldo=($total-$sewa-$pengeluarantotal);?>
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
		</div>
	</div>
</form>
<script type="text/javascript">
	
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
		
		var cmt = $('select[name=\'cmt\']').val();

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
</script>