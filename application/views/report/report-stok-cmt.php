<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<style type="text/css">
    .table tr,.table th,.table tr td,.table tr th{
        border: 1px solid black;
    }
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row hidden-print" >
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">Item Masuk</h4>
                   <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>
                    <form action="<?php echo BASEURL.'report/laporanproduksikaos' ?>" method="GET" class="mb-3">
                        <div class="row mb-4">
                        	<div class="col-4">
                        		<div class="form-group">
	                                <label>Jenis PO</label>
	                                <select class="form-control" name="cmtKat">
                                      <option></option>
                                      <option value="JAHIT">JAHIT</option>
                                      <option value="BORDIR">BORDIR</option>
	                                    <option value="SABLON">SABLON</option>
	                                </select>
	                            </div>
	                            
                        	</div>
                          	<div class="col-6">
                          		<div class="form-group">
	                            	<label>Tanggal Mulai</label>
	                            	<input type="date" class="form-control" name="tanggalMulai">
	                            </div>
	                            <div class="form-group">
	                            	<label>Tanggal Akhir</label>
	                            	<input type="date" class="form-control" name="tanggalAkhir">
	                            </div>
                          	</div>
                        </div>
                            <button style="float: right;" class="btn  btn-info mt-4">SUBMIT</button>
                    </form>

                </div>
            </div>
        </div> 
        <?php if (isset($tanggal)): ?>
        
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive" style="font-size: 9px;">
                  <h2 class="text-center">LAPORAN KAOS</h2>
              <h4 class="text-center"><?php echo (isset($tanggal['tanggalMulai'])?date('d F Y ',strtotime($tanggal['tanggalMulai'])):'') ?> - <?php echo (isset($tanggal['tanggalAkhir'])?date('d F Y ',strtotime($tanggal['tanggalAkhir'])):'') ?></h4>
                    <?php $no = 1; ?>
                    <div class="row" style="page-break-after: always;">
                      <div class="col-12">
                    <h4 class="text-center">KIRIM CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table text-center">
                        <thead>
                          <tr>
                        	<th rowspan="2">NAMA CMT</th>
                              <th colspan="14" class="text-center">JENIS PO</th>
                              <th colspan="2" class="text-center">JUMLAH</th>
                          </tr>
                        <tr style="background: yellow;">
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>PO</th>
                            <th>PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                       	<?php foreach ($cmt as $key => $cmtt): ?>
                        	<?php $totalpodicmt=0; ?>
                          <!-- VARIABEL -->
                        	<?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0;$kdr=0;$kkw=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0;$skw=0;$kdop=0;$hgh=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0;$Totkdr=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0;$Totkkw=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>

                          <?php $TotkdsBangke=0;$TotkdoBangke=0;$TotkdwBangke=0;$TotkdtBangke=0; ?>
                          <?php $TotfboBangke=0;$TotfbsBangke=0;$TotkdopBangke=0; ?>
                          <?php $TotswkBangke=0;$TotkdrBangke=0;$TotkkwBangke=0; ?>
                          <?php $TothgkBangke=0;$TothgoBangke=0;$TotskwBangke=0;$TothghBangke=0; ?>


                          <?php $TotkdsHilang=0;$TotkdoHilang=0;$TotkdwHilang=0;$TotkdopHilang=0;$TotkdtHilang=0; ?>
                          <?php $TotfboHilang=0;$TotfbsHilang=0; ?>
                          <?php $TotswkHilang=0;$TotkdrHilang=0;$TotkkwHilang=0; ?>
                          <?php $TothgkHilang=0;$TothgoHilang=0;$TotskwHilang=0;$TothghHilang=0; ?>

                          <?php $TotkdsReject=0;$TotkdoReject=0;$TotkdwReject=0;$TotkdtReject=0; ?>
                          <?php $TotfboReject=0;$TotfbsReject=0;$TotkdopReject=0;$TotkkwReject=0; ?>
                          <?php $TotswkReject=0;$TotkdrReject=0; ?>
                          <?php $TothgkReject=0;$TothgoReject=0;$TotskwReject=0;$TothghReject=0; ?>


                          <?php $TotkdsClaim=0;$TotkdoClaim=0;$TotkdwClaim=0;$TotkdopClaim=0;$TotkdtClaim=0; ?>
                          <?php $TotfboClaim=0;$TotfbsClaim=0;$TotkkwClaim=0; ?>
                          <?php $TotswkClaim=0;$TotkdrClaim=0; ?>
                          <?php $TothgkClaim=0;$TothgoClaim=0;$TotskwClaim=0;$TothghClaim=0; ?>

                          <?php $totalPo=0;$totalPiecePo=0; ?>
                       		<?php $totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                          <!-- END VARIABEL -->
                       	<tr>
                       		<td><?php echo $cmtt['cmt_name'] ?></td>
                        	<td>
                            <!-- PERHITUNGAN -->
	                        <?php foreach ($kirim as $key => $bod): ?>
	                        	<?php $totalPo +=1;$totalPcs+=$bod['qty_tot_pcs'] ?>
	                        	<?php if ("KDS" == $bod['nama_po']): ?>
                              <?php 
                              $kds +=1;$Totkds+=$bod['qty_tot_pcs'];
                              $TotkdsBangke+=$bod['qty_bangke'];
                              $TotkdsHilang+=$bod['qty_hilang'];
                              $TotkdsReject+=$bod['qty_reject'];
                              $TotkdsClaim+=$bod['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("FBO" == $bod['nama_po']): ?>
                              <?php 
                              $fbo +=1;$Totfbo+=$bod['qty_tot_pcs']; 
                              $TotfboBangke+=$bod['qty_bangke'];
                              $TotfboHilang+=$bod['qty_hilang'];
                              $TotfboReject+=$bod['qty_reject'];
                              $TotfboClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SWK" == $bod['nama_po']): ?>
                              <?php 
                                $swk +=1;$Totswk+=$bod['qty_tot_pcs']; 
                                $TotswkBangke+=$bod['qty_bangke'];
                                $TotswkHilang+=$bod['qty_hilang'];
                                $TotswkReject+=$bod['qty_reject'];
                                $TotswkClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDO" == $bod['nama_po']): ?>
                              <?php 
                                $kdo +=1;$Totkdo+=$bod['qty_tot_pcs']; 
                                $TotkdoBangke+=$bod['qty_bangke'];
                                $TotkdoHilang+=$bod['qty_hilang'];
                                $TotkdoReject+=$bod['qty_reject'];
                                $TotkdoClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDOP" == $bod['nama_po']): ?>
                              <?php 
                              $kdop +=1;$Totkdop+=$bod['qty_tot_pcs']; 
                                $TotkdopBangke+=$bod['qty_bangke'];
                                $TotkdopHilang+=$bod['qty_hilang'];
                                $TotkdopReject+=$bod['qty_reject'];
                                $TotkdopClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("FBS" == $bod['nama_po']): ?>
                              <?php 
                                $fbs +=1;$Totfbs+=$bod['qty_tot_pcs']; 
                                $TotfbsBangke+=$bod['qty_bangke'];
                                $TotfbsHilang+=$bod['qty_hilang'];
                                $TotfbsReject+=$bod['qty_reject'];
                                $TotfbsClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDT" == $bod['nama_po']): ?>
                              <?php 
                                $kdt +=1;$Totkdt+=$bod['qty_tot_pcs']; 
                                $TotkdtBangke+=$bod['qty_bangke'];
                                $TotkdtHilang+=$bod['qty_hilang'];
                                $TotkdtReject+=$bod['qty_reject'];
                                $TotkdtClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDW" == $bod['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkdw+=$bod['qty_tot_pcs'];
                                $TotkdwBangke+=$bod['qty_bangke'];
                                $TotkdwHilang+=$bod['qty_hilang'];
                                $TotkdwReject+=$bod['qty_reject'];
                                $TotkdwClaim+=$bod['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("KKW" == $bod['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkkw+=$bod['qty_tot_pcs'];
                                $TotkkwBangke+=$bod['qty_bangke'];
                                $TotkkwHilang+=$bod['qty_hilang'];
                                $TotkkwReject+=$bod['qty_reject'];
                                $TotkkwClaim+=$bod['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("KDR" == $bod['nama_po']): ?>
                              <?php 
                                $kdr +=1;$Totkdr+=$bod['qty_tot_pcs'];
                                $TotkdrBangke+=$bod['qty_bangke'];
                                $TotkdrHilang+=$bod['qty_hilang'];
                                $TotkdrReject+=$bod['qty_reject'];
                                $TotkdrClaim+=$bod['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("HGK" == $bod['nama_po']): ?>
                              <?php 
                              $hgk +=1;$Tothgk+=$bod['qty_tot_pcs']; 
                              $TothgkBangke+=$bod['qty_bangke'];
                              $TothgkHilang+=$bod['qty_hilang'];
                              $TothgkReject+=$bod['qty_reject'];
                              $TothgkClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("HGH" == $bod['nama_po']): ?>
                              <?php 
                              $hgh +=1;$Tothgh+=$bod['qty_tot_pcs']; 
                              $TothghBangke+=$bod['qty_bangke'];
                              $TothghHilang+=$bod['qty_hilang'];
                              $TothghReject+=$bod['qty_reject'];
                              $TothghClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SKW" == $bod['nama_po']): ?>
                              <?php 
                              $skw +=1;$Totskw+=$bod['qty_tot_pcs']; 
                              $TotskwBangke+=$bod['qty_bangke'];
                              $TotskwHilang+=$bod['qty_hilang'];
                              $TotskwReject+=$bod['qty_reject'];
                              $TotskwClaim+=$bod['qty_claim'];
                              ?>
                            <?php endif ?>
                            <!-- END PERHITUNGAN -->
	                        	<?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
		                       		<?php if ("FBO" == $bod['nama_po']): ?>
		                            	<?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
		                       		<?php endif ?>
	                        	<?php endif ?>
	                        <?php endforeach ?>
                       		</td>

                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("FBS" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
	                        <?php endforeach ?>
                       		</td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("HGH" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("HGK" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
	                        <?php endforeach ?>
                       		</td>

                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("HGO" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
	                        <?php endforeach ?>
                       		</td>
                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KDO" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
	                        <?php endforeach ?>
                       		</td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KDOP" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KDR" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KDS" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
	                        <?php endforeach ?>
                       		</td>
                       		<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
	                        	<?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
		                       		<?php if ("KDT" == $bod['nama_po']): ?>
		                            	<?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
		                       		<?php endif ?>
	                        	<?php endif ?>
	                        <?php endforeach ?>
                       		</td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KDW" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("KKW" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("SKW" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($kirim as $key => $bod): ?>
                            <?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
                              <?php if ("SWK" == $bod['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$bod['qty_tot_pcs']; echo $bod['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo number_format($totalpodicmt, 0, '.', '.') ?></td>
                       		<td style="background: #b9b990;"><?php echo number_format($totalPiecePo, 0, '.', '.') ?></td>
                        </tr>
                       	<?php endforeach ?>
                        <!-- SHOW VARIABEL -->
                       	<tr style="background: #b9b990;">
                       		<td>TOTAL</td>
                       		<td><?php echo $fbo; ?></td>
                          <td><?php echo $fbs; ?></td>
                          <td><?php echo $hgh; ?></td>
                          <td><?php echo $hgk; ?></td>
                       		<td><?php echo $hgo; ?></td>
                          <td><?php echo $kdo; ?></td>
                          <td><?php echo $kdop; ?></td>
                       		<td><?php echo $kdr; ?></td>
                       		<td><?php echo $kds; ?></td>
                       		<td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $kkw ?></td>
                          <td><?php echo $skw; ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo number_format($totalPo, 0, '.', '.'); ?></td>
                       		<td><?php echo number_format($totalPcs, 0, '.', '.'); ?></td>
                       	</tr>
                        <tr>
                          <td>TOTAL PCS</td>
                          <td><?php echo number_format($Totfbo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totfbs, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgh, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgk, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdop, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdr, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkkw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL BANGKE</td>
                          <td><?php echo number_format($TotfboBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtBangke, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkBangke, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL HILANG</td>
                          <td><?php echo number_format($TotfboHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtHilang, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkHilang, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL REJECT</td>
                          <td><?php echo number_format($TotfboReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtReject, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkReject, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL CLAIM</td>
                          <td><?php echo number_format($TotfboClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtClaim, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkClaim, 0, '.', '.'); ?></td>
                        </tr>
                        <!-- END SHOW VARIABEL -->
                        </tbody>
                    </table>
                      </div>
                    </div>

                    <div class="row" style="page-break-after: always;">
                      <div class="col-12">
                    <h4 class="text-center">SETOR CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table text-center">
                        <thead>
                        <tr>
                              <th rowspan="2">NAMA CMT</th>
                              <th colspan="14" class="text-center">JENIS PO</th>
                              <th colspan="2" class="text-center">JUMLAH</th>
                        </tr>
                      <tr style="background: yellow;">
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>PO</th>
                            <th>PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                          <?php $totalpodicmt=0; ?>

                          <?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0;$kdr=0;$kkw=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0;$skw=0;$kdop=0;$hgh=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0;$Totkdr=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0;$Totkkw=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>

                          <?php $TotkdsBangke=0;$TotkdoBangke=0;$TotkdwBangke=0;$TotkdtBangke=0; ?>
                          <?php $TotfboBangke=0;$TotfbsBangke=0;$TotkdopBangke=0; ?>
                          <?php $TotswkBangke=0;$TotkdrBangke=0;$TotkkwBangke=0; ?>
                          <?php $TothgkBangke=0;$TothgoBangke=0;$TotskwBangke=0;$TothghBangke=0; ?>


                          <?php $TotkdsHilang=0;$TotkdoHilang=0;$TotkdwHilang=0;$TotkdopHilang=0;$TotkdtHilang=0; ?>
                          <?php $TotfboHilang=0;$TotfbsHilang=0; ?>
                          <?php $TotswkHilang=0;$TotkdrHilang=0;$TotkkwHilang=0; ?>
                          <?php $TothgkHilang=0;$TothgoHilang=0;$TotskwHilang=0;$TothghHilang=0; ?>

                          <?php $TotkdsReject=0;$TotkdoReject=0;$TotkdwReject=0;$TotkdtReject=0; ?>
                          <?php $TotfboReject=0;$TotfbsReject=0;$TotkdopReject=0;$TotkkwReject=0; ?>
                          <?php $TotswkReject=0;$TotkdrReject=0; ?>
                          <?php $TothgkReject=0;$TothgoReject=0;$TotskwReject=0;$TothghReject=0; ?>


                          <?php $TotkdsClaim=0;$TotkdoClaim=0;$TotkdwClaim=0;$TotkdopClaim=0;$TotkdtClaim=0; ?>
                          <?php $TotfboClaim=0;$TotfbsClaim=0;$TotkkwClaim=0; ?>
                          <?php $TotswkClaim=0;$TotkdrClaim=0; ?>
                          <?php $TothgkClaim=0;$TothgoClaim=0;$TotskwClaim=0;$TothghClaim=0; ?>

                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>

                        <tr>
                          <td><?php echo $cmtt['cmt_name'] ?></td>
                          <td>
                            <?php //pre($setor); ?>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php $totalPo +=1;$totalPcs+=$set['qty_tot_pcs'] ?>
                            <?php if ("KDS" == $set['nama_po']): ?>
                              <?php 
                              $kds +=1;$Totkds+=$set['qty_tot_pcs'];
                              $TotkdsBangke+=$set['qty_bangke'];
                              $TotkdsHilang+=$set['qty_hilang'];
                              $TotkdsReject+=$set['qty_reject'];
                              $TotkdsClaim+=$set['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("FBO" == $set['nama_po']): ?>
                              <?php 
                              $fbo +=1;$Totfbo+=$set['qty_tot_pcs']; 
                              $TotfboBangke+=$set['qty_bangke'];
                              $TotfboHilang+=$set['qty_hilang'];
                              $TotfboReject+=$set['qty_reject'];
                              $TotfboClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SWK" == $set['nama_po']): ?>
                              <?php 
                                $swk +=1;$Totswk+=$set['qty_tot_pcs']; 
                                $TotswkBangke+=$set['qty_bangke'];
                                $TotswkHilang+=$set['qty_hilang'];
                                $TotswkReject+=$set['qty_reject'];
                                $TotswkClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDO" == $set['nama_po']): ?>
                              <?php 
                                $kdo +=1;$Totkdo+=$set['qty_tot_pcs']; 
                                $TotkdoBangke+=$set['qty_bangke'];
                                $TotkdoHilang+=$set['qty_hilang'];
                                $TotkdoReject+=$set['qty_reject'];
                                $TotkdoClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDOP" == $set['nama_po']): ?>
                              <?php 
                              $kdop +=1;$Totkdop+=$set['qty_tot_pcs']; 
                                $TotkdopBangke+=$set['qty_bangke'];
                                $TotkdopHilang+=$set['qty_hilang'];
                                $TotkdopReject+=$set['qty_reject'];
                                $TotkdopClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDR" == $bod['nama_po']): ?>
                              <?php 
                                $kdr +=1;$Totkdr+=$bod['qty_tot_pcs'];
                                $TotkdrBangke+=$bod['qty_bangke'];
                                $TotkdrHilang+=$bod['qty_hilang'];
                                $TotkdrReject+=$bod['qty_reject'];
                                $TotkdrClaim+=$bod['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("FBS" == $set['nama_po']): ?>
                              <?php 
                                $fbs +=1;$Totfbs+=$set['qty_tot_pcs']; 
                                $TotfbsBangke+=$set['qty_bangke'];
                                $TotfbsHilang+=$set['qty_hilang'];
                                $TotfbsReject+=$set['qty_reject'];
                                $TotfbsClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDT" == $set['nama_po']): ?>
                              <?php 
                                $kdt +=1;$Totkdt+=$set['qty_tot_pcs']; 
                                $TotkdtBangke+=$set['qty_bangke'];
                                $TotkdtHilang+=$set['qty_hilang'];
                                $TotkdtReject+=$set['qty_reject'];
                                $TotkdtClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDW" == $set['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkdw+=$set['qty_tot_pcs'];
                                $TotkdwBangke+=$set['qty_bangke'];
                                $TotkdwHilang+=$set['qty_hilang'];
                                $TotkdwReject+=$set['qty_reject'];
                                $TotkdwClaim+=$set['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("KKW" == $set['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkkw+=$set['qty_tot_pcs'];
                                $TotkkwBangke+=$set['qty_bangke'];
                                $TotkkwHilang+=$set['qty_hilang'];
                                $TotkkwReject+=$set['qty_reject'];
                                $TotkkwClaim+=$set['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("HGK" == $set['nama_po']): ?>
                              <?php 
                              $hgk +=1;$Tothgk+=$set['qty_tot_pcs']; 
                              $TothgkBangke+=$set['qty_bangke'];
                              $TothgkHilang+=$set['qty_hilang'];
                              $TothgkReject+=$set['qty_reject'];
                              $TothgkClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("HGH" == $set['nama_po']): ?>
                              <?php 
                              $hgh +=1;$Tothgh+=$set['qty_tot_pcs']; 
                              $TothghBangke+=$set['qty_bangke'];
                              $TothghHilang+=$set['qty_hilang'];
                              $TothghReject+=$set['qty_reject'];
                              $TothghClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SKW" == $set['nama_po']): ?>
                              <?php 
                              $skw +=1;$Totskw+=$set['qty_tot_pcs']; 
                              $TotskwBangke+=$set['qty_bangke'];
                              $TotskwHilang+=$set['qty_hilang'];
                              $TotskwReject+=$set['qty_reject'];
                              $TotskwClaim+=$set['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGH" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDOP" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDR" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDT" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SWK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$set['qty_tot_pcs']; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo number_format($totalpodicmt, 0, '.', '.') ?></td>
                          <td style="background: #b9b990;"><?php echo number_format($totalPiecePo, 0, '.', '.') ?></td>
                        </tr>
                        <?php endforeach ?>
                        <tr style="background: #b9b990;">
                          <td>TOTAL</td>
                          <td><?php echo $fbo; ?></td>
                          <td><?php echo $fbs; ?></td>
                          <td><?php echo $hgh; ?></td>
                          <td><?php echo $hgk; ?></td>
                          <td><?php echo $hgo; ?></td>
                          <td><?php echo $kdo; ?></td>
                          <td><?php echo $kdop; ?></td>
                          <td><?php echo $kdr; ?></td>
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $kkw ?></td>
                          <td><?php echo $skw ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo number_format($totalPo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($totalPcs, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL PCS</td>
                          <td><?php echo number_format($Totfbo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totfbs, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgh, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgk, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdop, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdr, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkkw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL BANGKE</td>
                          <td><?php echo number_format($TotfboBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtBangke, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkBangke, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL HILANG</td>
                          <td><?php echo number_format($TotfboHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtHilang, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkHilang, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL REJECT</td>
                          <td><?php echo number_format($TotfboReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtReject, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkReject, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL CLAIM</td>
                          <td><?php echo number_format($TotfboClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtClaim, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkClaim, 0, '.', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                    <div class="row"  style="page-break-before: always;">
                      <div class="col-12">
                    <h4 class="text-center">(STOCK) PROSES CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">NAMA CMT</th>
                              <th colspan="14" class="text-center">JENIS PO</th>
                            <th colspan="2" class="text-center">JUMLAH</th>
                        </tr>
                        <tr style="background: yellow;">
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>PO</th>
                            <th>PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                          <?php $totalpodicmt=0; ?>
                          <?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0;$kdr=0;$kkw=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0;$skw=0;$kdop=0;$hgh=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0;$Totkdr=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0;$Totkkw=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>

                          <?php $TotkdsBangke=0;$TotkdoBangke=0;$TotkdwBangke=0;$TotkdtBangke=0; ?>
                          <?php $TotfboBangke=0;$TotfbsBangke=0;$TotkdopBangke=0; ?>
                          <?php $TotswkBangke=0;$TotkdrBangke=0;$TotkkwBangke=0; ?>
                          <?php $TothgkBangke=0;$TothgoBangke=0;$TotskwBangke=0;$TothghBangke=0; ?>


                          <?php $TotkdsHilang=0;$TotkdoHilang=0;$TotkdwHilang=0;$TotkdopHilang=0;$TotkdtHilang=0; ?>
                          <?php $TotfboHilang=0;$TotfbsHilang=0; ?>
                          <?php $TotswkHilang=0;$TotkdrHilang=0;$TotkkwHilang=0; ?>
                          <?php $TothgkHilang=0;$TothgoHilang=0;$TotskwHilang=0;$TothghHilang=0; ?>

                          <?php $TotkdsReject=0;$TotkdoReject=0;$TotkdwReject=0;$TotkdtReject=0; ?>
                          <?php $TotfboReject=0;$TotfbsReject=0;$TotkdopReject=0;$TotkkwReject=0; ?>
                          <?php $TotswkReject=0;$TotkdrReject=0; ?>
                          <?php $TothgkReject=0;$TothgoReject=0;$TotskwReject=0;$TothghReject=0; ?>


                          <?php $TotkdsClaim=0;$TotkdoClaim=0;$TotkdwClaim=0;$TotkdopClaim=0;$TotkdtClaim=0; ?>
                          <?php $TotfboClaim=0;$TotfbsClaim=0;$TotkkwClaim=0; ?>
                          <?php $TotswkClaim=0;$TotkdrClaim=0; ?>
                          <?php $TothgkClaim=0;$TothgoClaim=0;$TotskwClaim=0;$TothghClaim=0; ?>

                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                          
                        <tr>
                          <td><?php echo $cmtt['cmt_name'] ?></td>
                          <td>
                            <?php //pre($setor); ?>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php $totalPo +=1;$totalPcs+=$pros['qty_tot_pcs'] ?>
                            <?php if ("KDS" == $pros['nama_po']): ?>
                              <?php 
                              $kds +=1;$Totkds+=$pros['qty_tot_pcs'];
                              $TotkdsBangke+=$pros['qty_bangke'];
                              $TotkdsHilang+=$pros['qty_hilang'];
                              $TotkdsReject+=$pros['qty_reject'];
                              $TotkdsClaim+=$pros['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("FBO" == $pros['nama_po']): ?>
                              <?php 
                              $fbo +=1;$Totfbo+=$pros['qty_tot_pcs']; 
                              $TotfboBangke+=$pros['qty_bangke'];
                              $TotfboHilang+=$pros['qty_hilang'];
                              $TotfboReject+=$pros['qty_reject'];
                              $TotfboClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SWK" == $pros['nama_po']): ?>
                              <?php 
                                $swk +=1;$Totswk+=$pros['qty_tot_pcs']; 
                                $TotswkBangke+=$pros['qty_bangke'];
                                $TotswkHilang+=$pros['qty_hilang'];
                                $TotswkReject+=$pros['qty_reject'];
                                $TotswkClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDO" == $pros['nama_po']): ?>
                              <?php 
                                $kdo +=1;$Totkdo+=$pros['qty_tot_pcs']; 
                                $TotkdoBangke+=$pros['qty_bangke'];
                                $TotkdoHilang+=$pros['qty_hilang'];
                                $TotkdoReject+=$pros['qty_reject'];
                                $TotkdoClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDOP" == $pros['nama_po']): ?>
                              <?php 
                              $kdop +=1;$Totkdop+=$pros['qty_tot_pcs']; 
                                $TotkdopBangke+=$pros['qty_bangke'];
                                $TotkdopHilang+=$pros['qty_hilang'];
                                $TotkdopReject+=$pros['qty_reject'];
                                $TotkdopClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDR" == $pros['nama_po']): ?>
                              <?php 
                              $kdop +=1;$Totkdr+=$pros['qty_tot_pcs']; 
                                $TotkdrBangke+=$pros['qty_bangke'];
                                $TotkdrHilang+=$pros['qty_hilang'];
                                $TotkdrReject+=$pros['qty_reject'];
                                $TotkdrClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("FBS" == $pros['nama_po']): ?>
                              <?php 
                                $fbs +=1;$Totfbs+=$pros['qty_tot_pcs']; 
                                $TotfbsBangke+=$pros['qty_bangke'];
                                $TotfbsHilang+=$pros['qty_hilang'];
                                $TotfbsReject+=$pros['qty_reject'];
                                $TotfbsClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDT" == $pros['nama_po']): ?>
                              <?php 
                                $kdt +=1;$Totkdt+=$pros['qty_tot_pcs']; 
                                $TotkdtBangke+=$pros['qty_bangke'];
                                $TotkdtHilang+=$pros['qty_hilang'];
                                $TotkdtReject+=$pros['qty_reject'];
                                $TotkdtClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("KDW" == $pros['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkdw+=$pros['qty_tot_pcs'];
                                $TotkdwBangke+=$pros['qty_bangke'];
                                $TotkdwHilang+=$pros['qty_hilang'];
                                $TotkdwReject+=$pros['qty_reject'];
                                $TotkdwClaim+=$pros['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("KKW" == $pros['nama_po']): ?>
                              <?php 
                                $kdw +=1;$Totkkw+=$pros['qty_tot_pcs'];
                                $TotkkwBangke+=$pros['qty_bangke'];
                                $TotkkwHilang+=$pros['qty_hilang'];
                                $TotkkwReject+=$pros['qty_reject'];
                                $TotkkwClaim+=$pros['qty_claim'];
                               ?>
                            <?php endif ?>

                            <?php if ("HGK" == $pros['nama_po']): ?>
                              <?php 
                              $hgk +=1;$Tothgk+=$pros['qty_tot_pcs']; 
                              $TothgkBangke+=$pros['qty_bangke'];
                              $TothgkHilang+=$pros['qty_hilang'];
                              $TothgkReject+=$pros['qty_reject'];
                              $TothgkClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("HGH" == $pros['nama_po']): ?>
                              <?php 
                              $hgh +=1;$Tothgh+=$pros['qty_tot_pcs']; 
                              $TothghBangke+=$pros['qty_bangke'];
                              $TothghHilang+=$pros['qty_hilang'];
                              $TothghReject+=$pros['qty_reject'];
                              $TothghClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ("SKW" == $pros['nama_po']): ?>
                              <?php 
                              $skw +=1;$Totskw+=$pros['qty_tot_pcs']; 
                              $TotskwBangke+=$pros['qty_bangke'];
                              $TotskwHilang+=$pros['qty_hilang'];
                              $TotskwReject+=$pros['qty_reject'];
                              $TotskwClaim+=$pros['qty_claim'];
                              ?>
                            <?php endif ?>

                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("FBO" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("FBS" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("HGH" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("HGK" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("HGO" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDO" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDOP" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDR" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDS" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDT" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KDW" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("KKW" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("SKW" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("SWK" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1;$totalPiecePo+=$pros['qty_tot_pcs']; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo number_format($totalpodicmt, 0, '.', '.') ?></td>
                          <td style="background: #b9b990;"><?php echo number_format($totalPiecePo, 0, '.', '.') ?></td>
                        </tr>
                        <?php endforeach ?>
                        <tr style="background: #b9b990;">
                          <td>TOTAL</td>
                          <td><?php echo $fbo; ?></td>
                          <td><?php echo $fbs; ?></td>
                          <td><?php echo $hgh; ?></td>
                          <td><?php echo $hgk; ?></td>
                          <td><?php echo $hgo; ?></td>
                          <td><?php echo $kdo; ?></td>
                          <td><?php echo $kdop; ?></td>
                          <td><?php echo $kdr; ?></td>
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $kkw ?></td>
                          <td><?php echo $skw; ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo number_format($totalPo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($totalPcs, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL PCS</td>
                          <td><?php echo number_format($Totfbo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totfbs, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgh, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgk, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdop, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdr, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkkw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL BANGKE</td>
                          <td><?php echo number_format($TotfboBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtBangke, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwBangke, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkBangke, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL HILANG</td>
                          <td><?php echo number_format($TotfboHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtHilang, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwHilang, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkHilang, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL REJECT</td>
                          <td><?php echo number_format($TotfboReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtReject, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwReject, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkReject, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL CLAIM</td>
                          <td><?php echo number_format($TotfboClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotfbsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothghClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgkClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TothgoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdoClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdopClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdrClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdsClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkdtClaim, 0, '.', '.') ?></td>
                          <td><?php echo number_format($TotkdwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotkkwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotskwClaim, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($TotswkClaim, 0, '.', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                      </div>
                    </div>

                    <div class="row" style="page-break-before: always;">
                      <div class="col-12">
                        <h4 class="text-center">
                          (STOCK CMT)
                        </h4>
                        <table class="table text-center">
                          <thead>
                            <tr>
                                <th rowspan="2">NAMA CMT</th>
                                <th colspan="14" class="text-center">JENIS PO</th>
                                <th colspan="2" class="text-center">JUMLAH</th>
                            </tr>
                            <tr style="background: yellow;">
                              <?php foreach ($jenisPo as $key => $jeni): ?>
                              <th><?php echo $jeni['nama_jenis_po'] ?></th>
                              <?php endforeach ?>
                              <th>PO</th>
                              <th>PCS</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                          <?php $totalpodicmt=0; ?>
                          <?php $fbo=0;$fbs=0;$kkw=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0;$kdr=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0;$skw=0;$kdop=0;$hgh=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0;$Totkdr=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0;$Totkkw=0; ?>
                          <?php $Tothgk=0;$Tothgo=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $kdt=0;$totalPo=0;$totalPiecePo=0;$totalPcs=0;$Tothgh=0; ?>

                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                        <tr>
                          <td><?php echo $cmtt['cmt_name'] ?></td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php //pre($set); ?>
                            <?php $totalPo +=1; ?>
                            <?php if ("KDS" == $set['nama_po']): ?>
                              <?php 
                              $kds +=1;
                               ?>
                            <?php endif ?>

                            <?php if ("FBO" == $set['nama_po']): ?>
                              <?php 
                              $fbo +=1; 
                              ?>
                            <?php endif ?>

                            <?php if ("SWK" == $set['nama_po']): ?>
                              <?php 
                                $swk +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("KDO" == $set['nama_po']): ?>
                              <?php 
                                $kdo +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("KDOP" == $set['nama_po']): ?>
                              <?php 
                              $kdop +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("KDR" == $set['nama_po']): ?>
                              <?php 
                                $kdr +=1;
                               ?>
                            <?php endif ?>

                            <?php if ("FBS" == $set['nama_po']): ?>
                              <?php 
                                $fbs +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("KDT" == $set['nama_po']): ?>
                              <?php 
                                $kdt +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("KDW" == $set['nama_po']): ?>
                              <?php 
                                $kdw +=1;
                               ?>
                            <?php endif ?>

                            <?php if ("KKW" == $set['nama_po']): ?>
                              <?php 
                                $kkw +=1;
                               ?>
                            <?php endif ?>

                            <?php if ("HGK" == $set['nama_po']): ?>
                              <?php 
                              $hgk +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("HGH" == $set['nama_po']): ?>
                              <?php 
                              $hgh +=1;
                              ?>
                            <?php endif ?>

                            <?php if ("SKW" == $set['nama_po']): ?>
                              <?php 
                              $skw +=1;
                              ?>
                            <?php endif ?>

                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'],(isset($tanggal['cmtKat'])?$tanggal['cmtKat']:null))): ?>
                              <?php if ("FBO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("FBS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("HGH" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("HGK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("HGO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDOP" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDR" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDT" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KDW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("KKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("SKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($stock as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == wherecmt($set['kode_po'])): ?>
                              <?php if ("SWK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo number_format($totalpodicmt, 0, '.', '.') ?></td>
                          <td style="background: #b9b990;"><?php echo number_format($totalPiecePo, 0, '.', '.') ?></td>
                        </tr>
                        <?php endforeach ?>
                        <tr style="background: #b9b990;">
                          <td>TOTAL</td>
                          <td><?php echo $fbo; ?></td>
                          <td><?php echo $fbs; ?></td>
                          <td><?php echo $hgh; ?></td>
                          <td><?php echo $hgk; ?></td>
                          <td><?php echo $hgo; ?></td>
                          <td><?php echo $kdo; ?></td>
                          <td><?php echo $kdop; ?></td>
                          <td><?php echo $kdr; ?></td>
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $kkw ?></td>
                          <td><?php echo $skw ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo number_format($totalPo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($totalPcs, 0, '.', '.'); ?></td>
                        </tr>
                        <tr>
                          <td>TOTAL PCS</td>
                          <td><?php echo number_format($Totfbo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totfbs, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgh, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgk, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Tothgo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdo, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdop, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdr, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkkw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
          
        <?php endif ?>
        </div> <!-- end row -->

    </div>
</div>
        <!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/jszip.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/pdfmake.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/vfs_fonts.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.html5.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.print.min.js"></script>

<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf']
            });
            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );

    </script>
