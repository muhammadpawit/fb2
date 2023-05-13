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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
				  <tr align="center">
				    <th rowspan="2"><center>Periode</center></th>
				    <th colspan="3"><center>Debet</center></th>
				    <th colspan="7"><center>Kredit</center></th>
				    <th rowspan="2"><center>Keterangan</center></th>
				  </tr>
				  <tr align="center">
				    <th >Transfer</th>
				    <th >Giro</th>
				    <th >Kas Masuk</th>
				    <th >Kas Keluar</th>
				    <th >Sisa Kas</th>
				    <th >Sukabumi</th>
				    <th >Serang</th>
				    <th >Jawa</th>
				    <th >Ajuan Belanja</th>
				    <th>Giro</th>
				  </tr>
				</thead>
				<tbody>
					<?php
						// debit
						$transfer=0;
						$giromasuk=0;
						$kasmasuk=0;

						// kredit
						$kaskeluar=0;
						$sisakas=0;
						$sukabumi=0;
						$serang=0;
						$jawa=0;
						$ajuan=0;
						$giriokeluar=0;
					?>
					<?php foreach($prods as $p){?>
						<?php 
							 //echo $p['tanggal'];
							if( ($p['tanggal']) == ($tanggal2) ){
								$plus=0;
							}else{
								$plus=6;
							}

						 ?>
						<?php $tgl2=date('Y-m-d',strtotime($p['tanggal']."+6 day"));?>
					<tr>					
						<td>
							<?php echo date('d F',strtotime($p['tanggal']))?> s.d <?php echo date('d F Y',strtotime($p['tanggal']."+$plus day"))?>
						</td>
						<td align="center">
							<?php echo number_format($this->LaporanmingguanModel->transferan_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1)); ?>
						</td>
						<td align="center">
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,20) ) ?>
						</td>
						<td align="center">
							<?php echo number_format( $this->LaporanmingguanModel->kas_masuk_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1) ) ?>
						</td>
						<td>
							<!-- kas keluar -->
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,6) ) ?>
						</td>
						<td>
							<!-- Sisa Kas -->
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,7) ) ?>
						</td>
						<td>
							<!-- Sukabumi -->
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,1) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,1) ) ?>
						</td>
						<td>
							<!-- Serang -->
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,2) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,2) ) ?>
						</td>
						<td>
							<!-- Jawa -->
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,10) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,3) ) ?>
						</td>
						<td>
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,11) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,5) ) ?>
						</td>
						<td>
							<?php echo number_format( $this->LaporanmingguanModel->alokasi_transfer_giro_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,20) ) ?>
						</td>
						<td></td>	
					</tr>

					<?php
						// debit
						$transfer +=( $this->LaporanmingguanModel->transferan_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1) );
						$giromasuk +=( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,20) ) ;
						$kasmasuk+=( $this->LaporanmingguanModel->kas_masuk_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1) );

						// kredit
						$kaskeluar +=( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,6) );
						$sisakas +=( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,7) );
						$sukabumi += ( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,1) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,1) );
						$serang+= ( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,2) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,2) );
						$jawa += ( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,10) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,3) );
						$ajuan+=( $this->LaporanmingguanModel->alokasi_bordir_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,11) + $this->LaporanmingguanModel->alokasi_transferan_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,5) );
						$giriokeluar += ( $this->LaporanmingguanModel->alokasi_transfer_giro_between($p['tanggal'],date('Y-m-d',strtotime($p['tanggal']."+$plus day")),1,20) ) ;
					?>

					<?php } ?>
					<tr>
						<td align="center"><b>Total</b></td>
						<td align="center"><b><?php echo number_format($transfer) ?></b></td>
						<td align="center"><b><?php echo number_format($giromasuk) ?></b></td>
						<td align="center"><b><?php echo number_format($kasmasuk) ?></b></td>
						<td align="center"><b><?php echo number_format($kaskeluar) ?></b></td>
						<td align="center"><b><?php echo number_format($sisakas) ?></b></td>
						<td align="center"><b><?php echo number_format($sukabumi) ?></b></td>
						<td align="center"><b><?php echo number_format($serang) ?></b></td>
						<td align="center"><b><?php echo number_format($jawa) ?></b></td>
						<td align="center"><b><?php echo number_format($ajuan) ?></b></td>
						<td align="center"><b><?php echo number_format($giriokeluar) ?></b></td>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
			          <td colspan="12" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>