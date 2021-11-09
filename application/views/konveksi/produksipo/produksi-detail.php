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
                            <h4 class="m-0 d-print-none">DETAIL PROJECT ORDER(PO)</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr><th>Kode Po</th>
                                            <th>Kode Artikel</th>
                                            <th>Nama Po</th>
                                            <th>Jenis Po</th>
                                            <th>Kategori Po</th>
                                            <th>Tanggal Prod</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $prod['kode_po'] ?></td>
                                        <td><?php echo $prod['kode_artikel'] ?></td>
                                        <td><?php echo $prod['nama_po'] ?></td>
                                        <td><?php echo $prod['jenis_po'] ?></td>
                                        <td><?php echo $prod['kategori_po'] ?></td>
                                        <td><?php echo $prod['created_date'] ?></td>
                                    </tr>
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
