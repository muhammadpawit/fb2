<form method="post" action="<?php echo $edit?>">
    <input type="hidden" name="idpo" value="<?php echo $gudangfb[0]['idpo'] ?>">
	                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <?php if ($this->session->flashdata('msg')) { ?>
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                   <?php echo $this->session->flashdata('msg'); ?> 
                            </div>
                            <?php } ?>
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div class="clearfix">
                                        <div class="pull-left mb-3">
                                            <img src="assets/images/logo.png" alt="" height="28">
                                        </div>
                                        <div class="pull-right">
                                            <h4>NOTA KIRIM GUDANG FORBOYS</h4>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-6">
                                            <div class="pull-left mt-3">
                                                <p><b>Jl. Z No.1 Kampung baru, Sukabumi Selatan,<br>
                                                        Kebon Jeruk, Jakarta HP : 081380401330</b></p>
                                                <p class="text-muted">
                                                </p>
                                            </div>

                                        </div><!-- end col -->
                                        <div class="col-4 offset-2">
                                            <div class="mt-3 pull-right">
                                                <table >
                                                    <tr>
                                                        <td><strong>Kirim Tanggal</strong></td>
                                                        <td>: <input type="text" name="tanggal_kirim" value="<?php echo date('Y-m-d',strtotime($gudangfb[0]['tanggal_kirim'] ))?>" class="datepicker"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Kepada YTH</strong></td>
                                                        <td>: <?php echo $gudangfb[0]['nama_penerima'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>&nbsp;
                                                            <?php echo $gudangfb[0]['tujuan'] ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                               
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <h6>NO FAKTUR : <strong><input type="text" name="nofaktur" value="<?php echo $gudangfb[0]['nofaktur'] ?>_<?php echo rand(2,10) ?>"></strong></h6>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table mt-4 table-bordered">
                                                    <thead>
                                                    <tr><th>No</th>
                                                        <th>ARTIKEL</th>
                                                        <th>NAMA PO</th>
                                                        <th>RINCIAN PO</th>
                                                        
                                                        
                                                    </tr></thead>
                                                    <tbody>
                                                        <?php $jumlah = 0;$total=0; $j=0; ?> 
                                                        <?php foreach ($gudangfb as $key => $gudang): ?>
                                                        <tr>
                                                            <td><?php echo $no++?></td>
                                                            <td><?php echo $gudang['artikel_po'] ?></td>
                                                            <td><?php echo $gudang['kode_po'] ?> <?php //echo $gudang['nama_po'] ?></td>
                                                            <td>
                                                                <?php foreach ($dataRinci as $key => $rinci): ?>
                                                                    <?php if ($key == $gudang['kode_po']): ?>
                                                                        <?php foreach ($rinci as $key => $detail): ?>
																		<p>
																			<label><?php echo $detail['rincian_size']?></label>

																			<input type="hidden" name="rincian[<?php echo $j?>][rincian_size]" value="<?php echo $detail['rincian_size'] ?>">

																			<input type="text" name="rincian[<?php echo $j?>][dz]" value="0" required> Dz
																			<input type="text" name="rincian[<?php echo $j ?>][pcs]" value="0"> Pcs<br><br>
																		</p>
                                                                        <?php $j++; endforeach ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                


                                                            </td>
                                                           
                                                            
                                                        </tr>
                                                        <?php endforeach ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr style="text-align: center;">
                                                    <td width="100px"><b>PIC Gudang</b></td>
                                                    <td width="100px"><b>Adm Finishing</b></td>
                                                    <td width="100px"><b>Driver</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px"></td>
                                                    <td style="height: 100px"></td>
                                                    <td style="height: 100px"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row no-print">
                                        <div class="col-6">
                                            <div class="clearfix pt-5">
                                                <h6 class="text-muted">Notes:</h6>

                                                <small>
                                                   BAE BAE INI BARANG BAGUS JANGAN AMPE RUSAK
                                                </small>
                                            </div>

                                        </div>
                                        
                                    </div>

                                    <div class="hidden-print mt-4 mb-4 no-print">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-info">Update</button>
                                            <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Cancel</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->
</form>