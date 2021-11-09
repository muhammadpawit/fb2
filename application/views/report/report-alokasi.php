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
                    <form action="<?php echo BASEURL.'report/laporanalokasicmt' ?>" method="GET" class="mb-3">
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
        </div> <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <h2 class="text-center">LAPORAN KAOS</h2>
              <h4 class="text-center"><?php echo (isset($tanggal['tanggalMulai'])?date('d F Y ',strtotime($tanggal['tanggalMulai'])):'') ?> - <?php echo (isset($tanggal['tanggalAkhir'])?date('d F Y ',strtotime($tanggal['tanggalAkhir'])):'') ?></h4>
                    <?php $no = 1; ?>

                    <div class="row" style="page-break-after: always;">
                      <div class="col-12">
                    <h4 class="text-center">KIRIM CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table ">
                        <thead>
                          <tr><th colspan="15" class="text-center">JENIS PO</th></tr>
                        <tr style="background: yellow;">
                        	<th>CMT</th>
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>TOTAL PO</th>
                            <th>TOTAL PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                       	<?php foreach ($cmt as $key => $cmtt): ?>
                        	<?php $totalpodicmt=0; ?>
                        	<?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0;$skw=0;$kdop=0;$hgh=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0; ?>
                       		<?php $kdt=0;$totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                       	<tr>
                       		<td><?php echo $cmtt['cmt_name'] ?></td>
                        	<td>
	                        <?php foreach ($kirim as $key => $bod): ?>
	                        	<?php $totalPo +=1; ?>
	                        	<?php if ("KDS" == $bod['nama_po']): ?>
	                        		<?php $kds +=1; ?>
		                       	<?php endif ?>

		                       	<?php if ("FBO" == $bod['nama_po']): ?>
	                        		<?php $fbo +=1; ?>
		                       	<?php endif ?>

		                       	<?php if ("SWK" == $bod['nama_po']): ?>
	                        		<?php $swk +=1; ?>
		                       	<?php endif ?>

		                       	<?php if ("KDO" == $bod['nama_po']): ?>
	                        		<?php $kdo +=1; ?>
		                       	<?php endif ?>

		                       	<?php if ("FBS" == $bod['nama_po']): ?>
	                        		<?php $fbs +=1;?>
		                       	<?php endif ?>

		                       	<?php if ("KDT" == $bod['nama_po']): ?>
	                        		<?php $kdt +=1; ?>
		                       	<?php endif ?>

                            <?php if ("KDW" == $bod['nama_po']): ?>
                              <?php $kdw +=1; ?>
                            <?php endif ?>

                            <?php if ("HGK" == $bod['nama_po']): ?>
                              <?php $hgk +=1; ?>
                            <?php endif ?>

	                        	<?php if ($cmtt['id_cmt'] == $bod['id_master_cmt']): ?>
		                       		<?php if ("FBO" == $bod['nama_po']): ?>
		                            	<?php $totalpodicmt+=1; echo $bod['kode_po'] ?>,
		                       		<?php endif ?>
	                        	<?php endif ?>
	                        <?php endforeach ?>
                       		</td>

                       		<td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGH" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
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
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDT" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SWK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo $totalpodicmt ?></td>
                       		<td style="background: #b9b990;"><?php echo $totalPiecePo ?></td>
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
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $skw; ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo $totalPo ?></td>
                       		<td><?php echo $totalPcs ?></td>
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
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                      </div>
                    </div>

                    <div class="row" style="page-break-after: always;">
                      <div class="col-12" >
                    <h4 class="text-center">(STOCK) SETOR CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table ">
                        <thead>
                        <tr><th colspan="15" class="text-center">JENIS PO</th></tr>
                        <tr style="background: yellow;">
                          <th>CMT</th>
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>TOTAL PO</th>
                            <th>TOTAL PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                          <?php $totalpodicmt=0; ?>
                          <?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $kdt=0;$totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                        <tr>
                          <td><?php echo $cmtt['cmt_name'] ?></td>
                          <td>
                            <?php //pre($setor); ?>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php $totalPo +=1; ?>
                            <?php if ("KDS" == $set['nama_po']): ?>
                              <?php $kds +=1; ?>
                            <?php endif ?>

                            <?php if ("FBO" == $set['nama_po']): ?>
                              <?php $fbo +=1; ?>
                            <?php endif ?>

                            <?php if ("SWK" == $set['nama_po']): ?>
                              <?php $swk +=1; ?>
                            <?php endif ?>

                            <?php if ("KDO" == $set['nama_po']): ?>
                              <?php $kdo +=1; ?>
                            <?php endif ?>

                            <?php if ("KDOP" == $set['nama_po']): ?>
                              <?php $kdop +=1;?>
                            <?php endif ?>

                            <?php if ("FBS" == $set['nama_po']): ?>
                              <?php $fbs +=1; ?>
                            <?php endif ?>

                            <?php if ("KDT" == $set['nama_po']): ?>
                              <?php $kdt +=1; ?>
                            <?php endif ?>

                            <?php if ("KDW" == $set['nama_po']): ?>
                              <?php $kdw +=1; ?>
                            <?php endif ?>

                            <?php if ("HGK" == $set['nama_po']): ?>
                              <?php $hgk +=1; ?>
                            <?php endif ?>

                            <?php if ("HGH" == $bod['nama_po']): ?>
                              <?php $hgh +=1; ?>
                            <?php endif ?>

                            <?php if ("SKW" == $bod['nama_po']): ?>
                              <?php 
                              $skw +=1; 
                              ?>
                            <?php endif ?>

                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGH" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
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
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDT" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SWK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo $totalpodicmt ?></td>
                          <td style="background: #b9b990;"><?php echo $totalPiecePo ?></td>
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
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $skw; ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo $totalPo ?></td>
                          <td><?php echo $totalPcs ?></td>
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
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totskw, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totswk, 0, '.', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                      </div>
                    </div>

                    <div class="row" style="page-break-after: always;">
                      <div class="col-12">
                    <h4 class="text-center"> PROSES CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                    <table id="" class="table ">
                        <thead>
                        <tr><th colspan="15" class="text-center">JENIS PO</th></tr>
                        <tr style="background: yellow;">
                          <th>CMT</th>
                            <?php foreach ($jenisPo as $key => $jeni): ?>
                            <th><?php echo $jeni['nama_jenis_po'] ?></th>
                            <?php endforeach ?>
                            <th>TOTAL PO</th>
                            <th>TOTAL PCS</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $array=[]; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                          <?php $totalpodicmt=0; ?>
                          <?php $fbo=0;$fbs=0; ?>
                          <?php $swk=0; ?>
                          <?php $hgk=0;$hgo=0; ?>
                          <?php $kdw=0;$kdt=0;$kds=0;$kdo=0; ?>

                          <?php $Totkds=0;$Totkdo=0;$Totkdop=0;$Totkdw=0;$Totkdt=0; ?>
                          <?php $Totfbo=0;$Totfbs=0; ?>
                          <?php $Totswk=0; ?>
                          <?php $Tothgk=0;$Tothgo=0;$Totskw=0;$Tothgh=0; ?>
                          <?php $totalPo=0;$totalPiecePo=0; ?>
                          <?php $kdt=0;$totalPo=0;$totalPiecePo=0;$totalPcs=0; ?>
                        <tr>
                          <td><?php echo $cmtt['cmt_name'] ?></td>
                          <td>
                            <?php //pre($setor); ?>
                          <?php foreach ($proses as $key => $pros): ?>
                            <?php $totalPo +=1; ?>
                            <?php if ("KDS" == $pros['nama_po']): ?>
                              <?php $kds +=1; ?>
                            <?php endif ?>

                            <?php if ("FBO" == $pros['nama_po']): ?>
                              <?php $fbo +=1; ?>
                            <?php endif ?>

                            <?php if ("SWK" == $pros['nama_po']): ?>
                              <?php $swk +=1; ?>
                            <?php endif ?>

                            <?php if ("KDO" == $pros['nama_po']): ?>
                              <?php $kdo +=1; ?>
                            <?php endif ?>

                            <?php if ("FBS" == $pros['nama_po']): ?>
                              <?php $fbs +=1; ?>
                            <?php endif ?>

                            <?php if ("KDT" == $pros['nama_po']): ?>
                              <?php $kdt +=1; ?>
                            <?php endif ?>

                            <?php if ("KDW" == $pros['nama_po']): ?>
                              <?php $kdw +=1; ?>
                            <?php endif ?>

                            <?php if ("HGK" == $pros['nama_po']): ?>
                              <?php $hgk +=1; ?>
                            <?php endif ?>

                            <?php if ($cmtt['id_cmt'] == $pros['id_master_cmt']): ?>
                              <?php if ("FBO" == $pros['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $pros['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>

                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("FBS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po']; 
                                  $array[$key]['fbs'] =1;?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGH" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("HGO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDO" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
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
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDS" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>, 
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDT" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("KDW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SKW" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td>
                          <?php foreach ($setor as $key => $set): ?>
                            <?php if ($cmtt['id_cmt'] == $set['id_master_cmt']): ?>
                              <?php if ("SWK" == $set['nama_po']): ?>
                                  <?php $totalpodicmt+=1; echo $set['kode_po'] ?>,
                              <?php endif ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          </td>
                          <td style="background: #b9b990;"><?php echo $totalpodicmt ?></td>
                          <td style="background: #b9b990;"><?php echo $totalPiecePo ?></td>
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
                          <td><?php echo $kds; ?></td>
                          <td><?php echo $kdt; ?></td>
                          <td><?php echo $kdw ?></td>
                          <td><?php echo $skw; ?></td>
                          <td><?php echo $swk; ?></td>

                          <td><?php echo $totalPo ?></td>
                          <td><?php echo $totalPcs ?></td>
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
                          <td><?php echo number_format($Totkds, 0, '.', '.'); ?></td>
                          <td><?php echo number_format($Totkdt, 0, '.', '.') ?></td>
                          <td><?php echo number_format($Totkdw, 0, '.', '.'); ?></td>
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
