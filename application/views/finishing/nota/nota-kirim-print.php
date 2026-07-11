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
                                                        <td>: <?php echo date('d-m-Y',strtotime($gudangfb[0]['tanggal_kirim'] ))?></td>
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
                                            <h6>NO FAKTUR : <strong><?php echo $gudangfb[0]['nofaktur'] ?></strong></h6>
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
                                                        <th>HARGA SATUAN</th>
                                                        <th>JUMLAH</th>
                                                        <th>TOTAL</th>
                                                        <th>KETERANGAN</th>
                                                    </tr></thead>
                                                    <tbody>
                                                        <?php $jumlah = 0;$total=0; ?> 
                                                        <?php foreach ($gudangfb as $key => $gudang): ?>
                                                            <?php
                                                            $po=$this->GlobalModel->getdataRow('produksi_po',array('id_produksi_po'=>$gudang['kode_po']));
                                                            ?>
                                                        <tr>
                                                            <td style="vertical-align: top;"><?php echo $no++?></td>
                                                            <td style="vertical-align: top;"><?php echo $gudang['artikel_po'] ?></td>
                                                            <td style="vertical-align: top;"><?php echo $po['kode_po'] ?> <?php //echo $gudang['nama_po'] ?></td>
                                                            <td style="vertical-align: top;">
                                                                <?php foreach ($dataRinci as $key => $rinci): ?>
                                                                    <?php if ($key == $gudang['kode_po']): ?>
                                                                        <?php foreach ($rinci as $key => $detail): ?>
                                                                        <?php echo $detail['rincian_size'] ?> : <?php echo $detail['rincian_lusin'] ?> DZ - <?php echo $detail['rincian_piece'] ?> PC<br>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            </td>
                                                            <td style="vertical-align: top;">Rp. <?php echo number_format($gudang['harga_satuan']) ?></td>
                                                            <?php  $jumlah += $gudang['jumlah_piece_diterima'];?>
                                                            <td style="vertical-align: top;"><?php echo $gudang['jumlah_piece_diterima'] ?></td>
                                                            <td style="vertical-align: top;"><?php $total += $gudang['harga_satuan'] * $gudang['jumlah_piece_diterima']; echo number_format($gudang['harga_satuan'] * $gudang['jumlah_piece_diterima']) ?></td>
                                                            <td style="vertical-align: top;">
																<?php echo !empty($gudang['keterangan']) ? $gudang['keterangan'].'<br>' : '' ?>
                                                                <?php foreach ($dataRinci as $key => $rinci): ?>
                                                                    <?php if ($key == $gudang['kode_po']): ?>
                                                                        <?php foreach ($rinci as $key => $detail): ?>
                                                                        <?php echo !empty($detail['katerangan_gudang_rincian']) ? $detail['katerangan_gudang_rincian'].'<br>' : '' ?>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="6">TOTAL</td>
                                                            <td><?php echo number_format($total) ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" style="width: 100%;">
                                                <tr style="text-align: center; background-color: #f8f9fa;">
                                                    <td width="20%"><b>PIC Gudang Tanah Abang</b></td>
                                                    <td width="20%"><b>PIC Gudang H Sholeh</b></td>
                                                    <td width="20%"><b>Adm Finishing</b></td>
                                                    <td width="20%"><b>Driver</b></td>
                                                    <td width="20%"><b>Security</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px"></td>
                                                    <td style="height: 100px"></td>
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
                                            <!-- <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a> -->
                                            <a href="<?php echo $pdf?>" target="_blank" class="btn btn-success text-white">Print PDF</a>
                                            <a href="<?php echo $pdfharga?>" target="_blank" class="btn btn-success text-white">Print Ada Harga</a>
                                            <a href="<?php echo $excel?>" target="_blank" class="btn btn-success text-white">Excel</a>

                                            <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Cancel</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->