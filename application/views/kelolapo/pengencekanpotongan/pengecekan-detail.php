<!-- Toastr css -->
<link href="<?php echo PLUGINS ?>jquery-toastr/jquery.toast.min.css" rel="stylesheet" />  
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="clearfix">
                        <div class="text-center">
                            <h4>DETAIL PENGECEKAN POTONGAN</h4>
                        </div>
                        <div class="pull-left mb-3">
                            <table >
                                <tr>
                                    <td>Tim Potong</td>
                                    <td>: <?php echo !empty($timpotong)?$timpotong['nama']:$potongan['tim_potong_ptoongan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>: <?php echo $potongan['created_date'] ?></td>
                                </tr>
                            </table>     
                        </div>
                        <div class="pull-right">
                            <table style="margin-right: 90px;">
                                <tr>
                                    <td>Nama PO</td>
                                    <td>: <?php echo $potongan['nama_po'].$potongan['kode_po'] ?></td>
                                </tr>
                                <tr>
                                    <td>Jml Warna</td>
                                    <td>: <?php echo $potongan['jumlah_gambar_utama'] ?></td>
                                </tr>
                                <tr>
                                    <td>Jml Potongan(Dz)</td>
                                    <td>: <?php echo $potongan['hasil_lusinan_potongan'] ?></td>
                                </tr>
                                <tr>
                                    <td>Jml Potongan(Pcs)</td>
                                    <td>: <?php echo $potongan['hasil_lusinan_potongan'] * 12 ?></td>
                                </tr>
                            </table>                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mt-4" border="1">
                                    <thead>
                                    <tr><th>No</th>
                                        <th>Bagian</th>
                                        <th>Warna</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                    </tr></thead>
                                    <tbody>
                                            <tr>
                                                <td colspan="5" class="text-center">ATASAN</td>
                                            </tr>
                                        <?php $jmlAt=0; foreach ($atas as $key => $at): ?>
                                            <tr>
                                                <td><?php echo $key+1 ?></td>
                                                <td><?php echo $at['bagian_potongan_atas'] ?></td>
                                                <td>
                                                    <?php echo $at['warna_potongan_atas'] ?>
                                                </td>
                                                <td><?php echo $at['keterangan_potongan'] ?></td>
                                                <td><?php echo $at['jumlah_potongan'] ?></td>
                                            </tr>
                                            <?php $jmlAt += $at['jumlah_potongan'];?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mt-4" border="1">
                                    <thead>
                                    <tr><th>No</th>
                                        <th>Bagian</th>
                                        <th>Warna</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                    </tr></thead>
                                    <tbody>
                                            <tr>
                                                <td colspan="5" class="text-center">BAWAHAN</td>
                                            </tr>
                                        <?php $jmlBw=0; foreach ($bawah as $key => $bw): ?>
                                            <tr>
                                                <td><?php echo $key+1 ?></td>
                                                <td><?php echo $bw['bagian_potongan_bawah'] ?></td>
                                                <td>
                                                    <?php echo $bw['warna_potongan_bawah'] ?>
                                                </td>
                                                <td><?php echo $bw['keterangan_potongan'] ?></td>
                                                <td><?php echo $bw['jumlah_potongan'] ?></td>
                                            </tr>
                                            <?php $jmlBw += $bw['jumlah_potongan']; ?>
                                        <?php endforeach ?>
                    <?php 
                    $total = ($jmlAt + $jmlBw); 
                    $totPotongan = $potongan['hasil_lusinan_potongan'] * 12;
                    ?>
                                        <tr>
                                            <td colspan="4" class="text-right"> 
                                                JUMLAH YANG DIKIRIM
                                            </td>
                                            <td>
                                                <?php echo $total; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    
                        
                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right">
                            <a href="<?php echo BASEURL.'kelolapo/pengencekanpotongan'?>" class="btn btn-danger waves-effect waves-light">Kembali</a>
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                        </div>
                    </div>
                    
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->

<!-- Toastr js -->
<script src="<?php echo PLUGINS ?>jquery-toastr/jquery.toast.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        $("#gagalprint").click(function () {
            $.toast({
                heading: '<h4>Oh Tidak BISAAA!</h4>',
                text: '<h5>Periksa Kembali Inputan Andaaa!!</h5>',
                position: 'top-right',
                loaderBg: '#bf441d',
                icon: 'error',
                hideAfter: 3000,
                stack: 1
            });
        });
    });
</script>