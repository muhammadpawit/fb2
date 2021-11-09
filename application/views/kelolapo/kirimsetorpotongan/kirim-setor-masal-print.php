<style type="text/css">
    .table tr,.table th,.table tr td{
        border: 1px solid black;
    }
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="clearfix">
                        <div class="pull-left mb-3">
                            <img src="assets/images/logo.png" alt="" height="28">
                        </div>
                        <div class="text-center">
                            <h4 class="m-0 d-print-none">NOTA KIRIM PO CMT</h4>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="pull-left mt-3">
                                <p><b>TRUE FORBOYS</b></p>
                                <p class="text-muted">Jln. Z No. 1 Kampung baru sukabumi selatan, Kebon Jeruk, Jakarta</p>
                                <p class="text-muted">No Hp 081380301330</p>
                            </div>

                        </div><!-- end col -->
                        <div class="col-4 offset-2">
                            <table class="table">
                                <tr>
                                    <td>Hari / Tanggal :</td>
                                    <td><?php echo $nota['kode_nota_cmt'] ?></td>
                                </tr>
                                <tr>
                                    <td>Nama CMT </td>
                                    <td><?php echo $nota['cmt_name'] ?> (<?php echo $nota['cmt_job_desk'] ?>)</td>
                                </tr>
                                <tr>
                                    <td>Cabang</td>
                                    <td><?php echo $nota['cabang_cmt'] ?></td>
                                </tr>
                            </table>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table  mt-4" border="2">
                                    <thead>
                                        <tr>
                                            <th>Nama PO</th>
                                            <th>Atas(Rincian)</th>
                                            <th>Bawah(Rincian)</th>
                                            <th>Jml Po</th>
                                            <th>Keterangan</th>
                                            <th>Jml Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pokirim as $key => $po): ?>
                                            <tr>
                                                <td><?php echo $po['nama_po'] ?> <?php echo $po['kode_po'] ?></td>
                                                <td>
                                            <?php foreach ($bagiankirimAts as $key => $atas): ?>
                                                <?php foreach ($atas as $key => $at): ?>
                                                    <?php if ($at['kode_po'] == $po['kode_po']): ?>
                                                    <?php echo $at['bagian_potongan_atas'] ?>, 
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                                </td>
                                                <td>
                                            <?php foreach ($bagiankirimbBwh as $key => $bawah): ?>
                                                <?php foreach ($bawah as $key => $bw): ?>
                                                    <?php if ($bw['kode_po'] == $po['kode_po']): ?>
                                                    <?php echo $bw['bagian_potongan_bawah'] ?>, 
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                                </td>
                                                <td>Total Keseluruhan (<?php echo $po['progress'] ?>)</td>
                                                <td><?php echo $po['qty_tot_pcs'] ?></td>
                                                <td><?php echo $po['jml_barang'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="clearfix pt-5">
                                <h6 class="text-muted">Catatan:</h6>

                                <small>
                                        <ol>
                                            <li>PO yang sudah di terima harap di cek dahulu potongan dan kelengkapannya</li>
                                            <li>Apabila ada kekurangan, harap segera konfirmasi bagian QC</li>
                                            <li>Batas Maksimal konfirmasi 3 x 24 Jam</li>
                                            <li>Apabila tidak ada konfirmasi PO di anggap komplit</li>
                                        </ol>
                                </small>
                            </div>

                        </div>
                        <div class="col-6">
                            <table class=" table">
                                <tr class="text-center">
                                    <td>CMT</td>
                                    <td>SPV</td>
                                    <td>Admin KLO</td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        Nama :
                                    </td>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                            <!-- <a href="#" class="btn btn-info waves-effect waves-light">Submit</a> -->
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->