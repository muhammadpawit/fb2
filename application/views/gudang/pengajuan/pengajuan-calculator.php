
<!-- Plugins css-->
<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />


    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-20">Pengajuan Kalkulator</h4>
                        <hr>
                       <form action="<?php echo BASEURL.'pengajuan/pangajuancalculatorOnCreate' ?>" method="POST">
                            <div class="form-group">
                                <label>Jenis PO</label>
                                <select class="selectpicker form-control" name="jenisPo" data-title="Pilih Jenis PO">
                                    <option value="KDO">KDO</option>
                                    <option value="SWK">SWK</option>
                                    <option value="KDS">KDS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Size</label>
                                <input type="number" class="form-control" name="size">
                            </div>
                            <div class="form-group">
                                <label>Lusin</label>
                                <input type="number" class="form-control" name="jmlLusin">
                            </div>
                            <div class="form-group">
                                <label>Berapa PO</label>
                                <input type="number" class="form-control" name="berapaPO">
                            </div>
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                       </form>

                    </div>

                </div>

            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>