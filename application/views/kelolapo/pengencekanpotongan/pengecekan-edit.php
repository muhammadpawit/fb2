<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />



<!-- Start Page content -->

<div class="content">

    <div class="container-fluid">



        <div class="row">

            <div class="col-md-12">



                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-20">Tambah Pengecekan Potongan</h4>

                    <p class="text-muted font-14 m-b-30">

                        <?php if ($this->session->flashdata('msg')) { ?>

                        <div class="alert alert-primary alert-dismissible fade show" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true">×</span>

                            </button>

                               <?php echo $this->session->flashdata('msg'); ?> 

                        </div>

                       <?php } ?>

                    </p>

                    <div class="alert alert-dark alert-dismissible bg-dark text-white border-0 fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                        Kalau ga ada value nya isi kolom nya dengan strip, Terima Kasih!

                    </div>

                    <hr>

                   <form action="<?php echo BASEURL.'kelolapo/formpengecekanpotonganOnAct' ?>" method="POST" enctype="multipart/form-data">

                   	<div class="row">

                        <div class="col-12">

                            <h3 class="text-center">POTONGAN ATASAN</h3>

                            <hr>

                        </div>

                   		<div class="form-group col-sm-12 col-lg-3">

                        	<label>Nama PO</label>

                            <select class="form-control select2bs4" id="poSelect" name="namaPo" title="Select Nama PO" data-live-search="true">

                                <option selected="selected" value="<?php echo $poProd['kode_po'] ?>"><?php echo $poProd['nama_po'].$poProd['kode_po'] ?></option>

                            </select>

                        </div>

                        <div class="form-group col-sm-12 col-lg-3">

                        	<label>Tanggal</label>

                        	<input type="text" class="form-control" name="tanggal" value="<?php echo $poProd['created_date'] ?>" required>

                        </div>

                        <div class="form-group col-sm-12 col-lg-3">
                            <?php $jumBl=0?>
                            <?php foreach($potonganUtama as $utama){?>
                                <?php $jumBl += str_replace(" ", "", $utama['banyak_lapis_potongan']); ?>
                            <?php } ?>
                        	<label>Jumlah Potong (Dz)</label>
                             <?php if($poProd['nama_po'] == "HGK"){ ?>
                                    <?php $pot= ($jumBl *  $poProd['jumlah_gambar_utama']) / 12; ?>
                                        <?php } elseif ($poProd['nama_po'] == "HGS") { ?>
                                            <?php $pot= ($jumBl * $poProd['jumlah_gambar_utama']) / 12; ?>
                                        <?php } elseif ($poProd['nama_po'] == "KDT" OR $poProd['nama_po'] == "OTF") { ?>
                                            <?php $pot= ($jumBl * $poProd['jumlah_gambar_utama']) / 12; ?>
                                        <?php } elseif ($poProd['nama_po'] == "SKW") { ?>
                                            <?php $pot= ($jumBl * $poProd['jumlah_gambar_utama']) / 12; ?>
                                        <?php } else { ?>
                                            <?php $pot= ($jumBl * 12) / 12; ?>
                            <?php } ?>
                        	<input type="number" step="0.01" class="form-control jumlahPotDz" name="jumlahPotDz" value="<?php echo (($jumBl * $poProd['jumlah_gambar_utama'])/12)?>" required>

                        </div>

                        <div class="form-group col-sm-12 col-lg-3">

                            <label>Jumlah Potong (Pcs)</label>

                            <input type="number" step="0.01" class="form-control jumlahPotPcs" name="jumlahPotPcs" value="<?php echo (($jumBl * $poProd['jumlah_gambar_utama']))?>" required>

                        </div>

                        <div class="form-group col-sm-12 col-lg-3">

                        	<label>Jml Warna</label>

                        	<input type="number" class="form-control jmlWarna" name="jmlWarna" value="<?php echo $poProd['jumlah_gambar_utama'] ?>" required>

                        </div>

                        

                        <div class="table-responsive">

                            <table class="table table-bordered" id="item_table">

                                <tr>

                                    <th>BAGIAN</th>

                                    <th>WARNA</th>

                                    <th>JML</th>

                                    <th>KETERANGAN</th>

                                    <th><button type="button" name="add" class="btn btn-success btn-sm addcek"><i class="fa fa-plus"></i></button></th>

                                </tr>

                                <?php foreach ($atas as $key => $at): ?>

                                <tr>

								    <td><input type="text" class="form-control" name="bagianAtas[]" value="<?php echo $at['bagian_potongan_atas'] ?>" required></td>

								    <td><input type="text" class="form-control" name="warnaAtas[]" value="<?php echo $at['warna_potongan_atas'] ?>" required></td>

								    <td><input type="number" class="form-control" name="jmlAtas[]"  value="<?php echo $at['jumlah_potongan'] ?>" required></td>

								    <td><input type="text" class="form-control" name="keteranganAts[]"  value="<?php echo $at['keterangan_potongan'] ?>"></td>

								    <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>

								</tr>

								<?php endforeach ?>

                            </table>

                        </div>

                        

                   	</div>



                    <div class="row">

                        <div class="col-sm-12">

                            <hr>

                            <h3 class="text-center">POTONGAN BAWAHAN</h3>

                            <hr>

                        </div>

                        

                        <div class="table-responsive">

                            <table class="table table-bordered" id="item_tabl2e">

                                <tr>

                                    <th>BAGIAN</th>

                                    <th>WARNA</th>

                                    <th>JML</th>

                                    <th>KETERANGAN</th>

                                    <th><button type="button" name="add2" class="btn btn-success btn-sm addcek2"><i class="fa fa-plus"></i></button></th>

                                </tr>

                                <?php foreach ($bawah as $key => $bw): ?>

                                	<tr>

									    <td><input type="text" class="form-control" name="bagianBwh[]" value="<?php echo $bw['bagian_potongan_bawah'] ?>" required></td>

									    <td><input type="text" class="form-control" name="warnaBwh[]" value="<?php echo $bw['warna_potongan_bawah'] ?>" required></td>

									    <td><input type="number" class="form-control" name="jmlBwh[]" value="<?php echo $bw['jumlah_potongan'] ?>" required ></td>

									    <td><input type="text" class="form-control" name="keteranganBwh[]"  value="<?php echo $bw['keterangan_potongan'] ?>"></td>

									    <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>

									</tr>

                                <?php endforeach ?>

                              

                            </table>

                        </div>

                    </div>

                        <button type="submit" class="btn btn-primary">SUBMIT</button>



                   </form>



                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->