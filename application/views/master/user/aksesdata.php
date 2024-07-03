<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msgt')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msgt'); ?> 
                    </div>
                       <?php } ?>
                    </p>
 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Otorisasi user <?php echo $user ?></h3>
                        <div class="card-tools">
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="clear: both;margin: 5px">&nbsp;</div>
                        <div class="table-responsive">

                            <form method="post" action="<?php echo $action?>">
                                <input type="hidden" name="user_id" value="<?php echo $id?>">
                                <table class="table mb-0 table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Pengaturan</th>
                                            <th></th>
                                            <th width="250">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>
                                            Dapat Mengedit Inputan
                                            <input type="hidden" value="1" name="user_menu[1][akses]" >
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <select class="form-control select2bs4" name="user_menu[1][nilai]">
                                                <option value="0">Belum disetting</option>
                                                <!-- <option value="1" <?php //echo $aksesedit['nilai']==1?'selected':'selected'?>>Ya</option>
                                                <option value="2" <?php //echo $aksesedit['nilai']==2?'selected':''?>>Tidak</option> -->
                                                <option value="1" selected>Ya</option>
                                                <option value="2" >Tidak</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Dapat Menghapus Inputan
                                            <input type="hidden" value="2" name="user_menu[2][akses]" >
                                        </td>
                                        <td>:</td>
                                        <td>
                                             <select class="form-control select2bs4" name="user_menu[2][nilai]">
                                                <option value="0">Belum disetting</option>
                                                <!-- <option value="1" <?php //echo $akseshapus['nilai']==1?'selected':'selected'?>>Ya</option>
                                                <option value="2" <?php //echo $akseshapus['nilai']==2?'selected':''?>>Tidak</option> -->
                                                <option value="1" selected>Ya</option>
                                                <option value="2" >Tidak</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Dapat Menyetujui Transaksi (Pengajuan Harian,Kasbon)
                                            <input type="hidden" value="3" name="user_menu[3][akses]" >
                                        </td>
                                        <td>:</td>
                                        <td>
                                             <select class="form-control select2bs4" name="user_menu[3][nilai]">
                                                <option value="0">Belum disetting</option>
                                                <option value="1" <?php echo $setujui['nilai']==1?'selected':''?>>Ya</option>
                                                <option value="2" <?php echo $setujui['nilai']==2?'selected':'selected'?>>Tidak</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Waktu Aktif</td>
                                        <td></td>
                                        <td>
                                            <select name="waktu" class="form-control select2bs4" required="required">
                                                <option value="">Pilih waktu</option>
                                                <option value="5" <?php echo $aksesedit['waktu']==5?'selected':''?>>5 Menit</option>
                                                <option value="15" <?php echo $aksesedit['waktu']==15?'selected':''?>>15 Menit</option>
                                                <option value="30" <?php echo $aksesedit['waktu']==30?'selected':''?>>30 Menit</option>
                                                <option value="45" <?php echo $aksesedit['waktu']==45?'selected':''?>>45 Menit</option>
                                                <option value="60" <?php echo $aksesedit['waktu']==60?'selected':''?>>1 Jam</option>
                                                <option value="120" <?php echo $aksesedit['waktu']==120?'selected':''?>>2 Jam</option>
                                                <option value="180" <?php echo $aksesedit['waktu']==180?'selected':''?>>3 Jam</option>
                                                <option value="8640" <?php echo $aksesedit['waktu']==8640?'selected':''?>>1 Minggu</option>
                                                <option value="17280" <?php echo $aksesedit['waktu']==17280?'selected':''?>>2 Minggu</option>
                                                <option value="34560" <?php echo $aksesedit['waktu']==34560?'selected':''?>>1 Bulan</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <span class="pull-right text-white"><a onclick="simpan()" class="btn btn-success">Simpan</a></span>   <span class="pull-right text-white"><a href="<?php echo BASEURL.'Masterdata/user'?>" class="btn btn-danger">Batal</a></span>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>



<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#datatable').DataTable();
      
    } );

    function simpan(){
        $("form").submit();
    }
</script>