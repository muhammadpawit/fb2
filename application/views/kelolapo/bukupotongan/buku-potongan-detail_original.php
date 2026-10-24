<style type="text/css">
    .table-satu,td,th{
        border: 2px solid black;
    }
    @media print{
        #sj{display: block !important;}
    }
</style>
<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <!-- <div class="row">
            <div class="col-md-12 text-right">
                <button onclick="window.print()" class="btn btn-default no-print">Print</button>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="clearfix">
                        <div class="pull-left mb-3">
                            <img src="assets/images/logo.png" alt="" height="28">
                        </div>
                        
                    </div>


                    <div class="row mt-3">
                        <div class="col-4">
                            <table class="table table-satu" border="5" style="width: 200px;">
                                <tr>
                                    <td>Tanggal</td>
                                    <td><strong><?php echo date('d-m-Y',strtotime($potonganHead['created_date'])) ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Nama PO</td>
                                    <td><strong><?php echo $potonganHead['nama_po'] ?> <?php echo $potonganHead['kode_po'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>SIZE</td>
                                    <td><strong><?php echo $potonganHead['size_potongan'] ?></strong></td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <h4 class="m-0"> <span style="display: none;" id="sj">SURAT JALAN</span> BUKU POTONGAN</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                           <table class="table-satu" width="100%">
                               <tr>
                                   <td>Tim Potong</td>
                                   <td>&nbsp;<strong><?php echo $tim['nama'] ?></strong></td>
                               </tr>
                               <tr>
                                   <td>Jumlah Gambar</td>
                                   <td>&nbsp;<strong><?php echo $potonganHead['jumlah_gambar_utama'] ?></strong></td>
                               </tr>
                           </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table table-satu"  style="text-align: center;">
                                <tr height="40%">
                                    <th>SAMPLE BAHAN UTAMA</th>
                                </tr>
                                <td>
                                    <img style="height: 249px;width: 100%;" src="<?php echo $potonganHead['sample_bahan_utama_img'] ?>"><br><img style="height: 249px;width: 100%;" src="<?php echo $potonganHead['sample_bahan_utama_img2'] ?>"></td>
                            </table>
                        </div>
                        
                        <div class="col-md-9">
                            <table class="table table-bordered" style="text-align: center;">
                                <tr>
                                   <th>BIDANG BAHAN</th>
                                    <th>WARNA</th>
                                    <th>KODE BAHAN</th>
                                    <th>BERAT BAHAN</th>
                                    <th>SISA BAHAN(KG)</th>
                                    <th>PEMAKAIAN BAHAN</th>
                                    <th>BANYAKNYA LAPIS</th> 
                                    <th><span class="hidden-print">Hapus</span></th>
                                </tr>
                                    
                                <?php $jumPb=0; $jumBl=0; foreach ($potonganUtama as $key => $utama): ?>
                                    <tr>
                                        <td><?php echo $utama['bidang_bahan_potongan']; ?></td>
                                        <td><?php echo $utama['warna_potongan']; ?></td>
                                        <td><?php echo $utama['kode_bahan_potongan']; ?></td>
                                        <td><?php echo $utama['berat_bahan_potongan']; ?></td>
                                        <td><?php echo $utama['sisa_bahan_potongan']; ?></td>
                                        <td><?php echo $utama['pemakaian_bahan_potongan']; ?></td>
                                        <td><?php echo $utama['banyak_lapis_potongan']; ?></td>
                                        <td>
                                            <a href="<?php echo BASEURL?>Kelolapo/hapusdetailutama/<?php echo $utama['id_potongan_utama']?>/<?php echo $potonganHead['kode_po'] ?>" class="btn btn-xs btn-danger text-white hidden-print"><i class="fa fa-window-close"></i></a>
                                        </td>
                                    </tr>
                                    <?php $jumPb += $utama['pemakaian_bahan_potongan']; ?>
                                    <?php $jumBl += $utama['banyak_lapis_potongan']; ?>
                                <?php endforeach ?>
                                    <tr style="font-weight: bold;background-color:yellow">
                                        <td colspan="5">Jumlah</td>  
                                        <td><?php echo $jumPb ?></td>
                                        <?php if ($potonganHead['nama_po'] == "HGK"){ ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "HGS") { ?>
                                            <td><?php echo number_format((($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12),2) ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "KDT" OR $potonganHead['nama_po'] == "OTF") { ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "SKW") { ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } else { ?>
                                            <td><?php echo ($jumBl * 12) / 12; ?></td>
                                        <?php } ?>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>
                                          PANJANG GELARAN  
                                        </th>
                                        <th>
                                        <?php echo $potonganHead['panjang_gelaran_potongan_utama'] ?> 
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                          PEMAKAIAN BAHAN  
                                        </th>
                                        <th>
                                        <?php echo $potonganHead['jumlah_pemakaian_bahan_utama'] ?> 
                                        </th>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                            <table class="table table-satu"  style="text-align: center;">
                                <tr height="40%">
                                    <th>SAMPLE BAHAN VARIASI</th>
                                </tr>
                                <td><img style="height: 249px;width: 100%;" src="<?php echo $potonganHead['sample_bahan_variasi_img'] ?>"><br><img style="height: 249px;width: 100%;" src="<?php echo $potonganHead['sample_bahan_variasi_img2'] ?>"></td>
                            </table>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered" style="text-align: center;margin-top: 20px;">
                                <tr>
                                    <th colspan="8">VARIASI</th>
                                </tr>
                                <tr>
                                    <th>BIDANG BAHAN</th>
                                    <th>WARNA</th>
                                    <th>KODE BAHAN</th>
                                    <th>BERAT BAHAN</th>
                                    <th>SISA BAHAN</th>
                                    <th>PEMAKAIAN BAHAN</th>
                                    <th>BANYAKNYA LAPIS</th> 
                                    <th><span class="hidden-print">Hapus</span></th>
                                </tr>
                                <?php $jumPbv=0; $jumBlv=0; foreach ($potonganVariasi as $key => $variasi): ?>
                                <tr>
                                    <td><?php echo $variasi['bidang_bahan_potongan'] ?></td>
                                    <td><?php echo $variasi['warna_potongan'] ?></td>
                                    <td><?php echo $variasi['kode_bahan_potongan'] ?></td>
                                    <td><?php echo $variasi['berat_bahan_potongan'] ?></td>
                                    <td><?php echo $variasi['sisa_bahan_potongan'] ?></td>
                                    <td><?php echo $variasi['pemakaian_bahan_potongan'] ?></td>
                                    <td><?php echo $variasi['banyak_lapis_potongan'] ?></td>
                                    <td>
                                            <a href="<?php echo BASEURL?>Kelolapo/hapusdetailvariasi/<?php echo $variasi['id_potongan_utama']?>/<?php echo $potonganHead['kode_po'] ?>" class="btn btn-xs btn-danger text-white"><i class="fa fa-window-close"></i></a>
                                        </td>
                                </tr>
                                <?php $jumPbv += $variasi['pemakaian_bahan_potongan']; ?>
                                <?php $jumBlv += $variasi['banyak_lapis_potongan']; ?>
                                <?php endforeach ?>
                                <tr style="font-weight: bold;background-color:yellow">
                                    <td colspan="5">Jumlah</td>  
                                    <td><?php echo $jumPbv ?></td>
                                    <!-- <td><?php echo ($jumBlv); ?></td> -->
                                    <?php if ($potonganHead['nama_po'] == "HGK"){ ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "HGS") { ?>
                                            <td><?php echo number_format((($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12),2) ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "KDT" OR $potonganHead['nama_po'] == "OTF") { ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } elseif ($potonganHead['nama_po'] == "SKW") { ?>
                                            <td><?php echo ($jumBl *  $potonganHead['jumlah_gambar_utama']) / 12; ?></td>
                                        <?php } else { ?>
                                            <td><?php echo ($jumBl * 12) / 12; ?></td>
                                        <?php } ?>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>
                                      PANJANG GELARAN VARIASI
                                    </th>
                                    <th>
                                    <?php echo $potonganHead['panjang_gelaran_variasi'] ?> 
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                      PEMAKAIAN BAHAN VARIASI
                                    </th>
                                    <th>
                                    <?php echo $potonganHead['jumlah_pemakaian_bahan_variasi'] ?> 
                                    </th>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>

                    <div class="hidden-print mt-4 mb-4 no-print">
                        <div class="text-right">
                            <!-- <a href="<?php echo $pdf; ?>" target="_blank"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a> -->
                            <a href="<?php echo $kembali; ?>" class="btn btn-info waves-effect waves-light">Kembali</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->