
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
                        <div class="pull-right">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="m-0 text-center">Mesin Bordir Detail</h4>
                            
                            <div class="table-responsive">
                                <table class="table mt-4 table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Operator</th>
                                        <th>Mesin</th>
                                        <th>NAMA PO</th>
                                        <th>Tanggal Naik</th>
                                        <th>Jml Naik</th>
                                        <th>Tanggal Turun</th>
                                        <th>Jml Turun</th>
                                        <th>Size</th>
                                        <th>Stich</th>
                                        <th>Total Stich</th>
                                        <th>Spon</th>
                                        <th>APL</th>
                                        <th>Yang Di Bordir</th>
                                        <th>Tarif</th>
                                        <th>Target</th>
                                    </tr></thead>
                                    <tbody>
                                        <?php foreach ($detail as $key => $det): ?>
                                        <tr>
                                            <td><?php echo $det['nama_operator'];?></td>
                                            <td><?php echo $det['mesin_bordir'];?></td>
                                            <?php if($det['jenis']==1){?>
                                                <td><?php echo $det['kode_po'] ?></td>
                                            <?php }else{ ?>
                                            <td><?php echo Getname('master_po_luar',$det['kode_po']) ?></td>
                                            <?php } ?>
                                            <td><?php echo $det['created_date'] ?></td>
                                            <td><?php echo $det['jumlah_naik_mesin'] ?></td>
                                            <td><?php echo $det['created_date'] ?></td>
                                            <td><?php echo $det['jumlah_turun_mesin'] ?></td>
                                            <td><?php echo $det['size'] ?></td>
                                            <td><?php echo $det['stich'] ?></td>
                                            <td><?php echo $det['total_stich'] ?></td>
                                            <td><?php echo $det['spon'] ?></td>
                                            <td><?php echo $det['apl'] ?></td>
                                            <td><?php echo $det['bagian_bordir'] ?></td>
                                            <td><?php echo number_format($det['total_tarif']) ?></td>
                                            <td><?php echo number_format($det['total_stich'] * 0.13) ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
