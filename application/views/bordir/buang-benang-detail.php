
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
                            <h4 class="m-0 text-center">Buang Benang Detail</h4>
                            <div class="table-responsive">
                                <table class="table mt-4 table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Po</th>
                                        <th>Bagian Yang</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Keterangan</th>
                                    </tr></thead>
                                    <tbody>

                                        <?php foreach ($detail as $key => $det): ?>
                                        <tr>
                                            <td><?php echo $det['created_date'] ?></td>
                                            <td><?php echo $det['nama_po'].$det['kode_po'] ?></td>
                                            <td><?php echo $det['bagian_buang_benang'] ?></td>
                                            <td><?php echo $det['size_buang_benang'] ?></td>
                                            <td><?php echo $det['qty_buang_benang'] ?></td>
                                            <td><?php echo $det['harga_buang_benan'] ?></td>
                                            <td><?php echo $det['keterangan_buang_benang'] ?></td>
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
