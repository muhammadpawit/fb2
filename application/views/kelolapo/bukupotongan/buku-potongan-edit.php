<form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-12">
        <table class="table">
                                <tr>
                                    <td><label>Tanggal</label></td>
                                    <td><input type="date" class="form-control" name="tanggal" value="<?php echo $potongan['created_date']?>" required></td>
                                </tr>
                                <tr>
                                    <td><label>Nama PO</label></td>
                                    <td>
                                        <input type="hidden" name="kode_po" value="<?php echo $poProd['kode_po']?>" class="form-control" readonly>
                                        <input type="text" name="namaPo" value="<?php echo $poProd['nama_po']?>-<?php echo $poProd['kode_po']?>" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Tim Potong</label></td>
                                    <td>
                                       <!--  <input type="text" class="form-control" name="timPotong" required> -->
                                       <select name="timPotong" class="form-control">
                                            <option value="">Pilih</option>
                                            <?php foreach($timpotong as $tp){ ?>
                                                <option value="<?php echo $tp['id']?>" <?php echo $tim['id']==$tp['id']?'selected':'';?>><?php echo $tp['nama']?></option>
                                            <?php }?>
                                       </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Gambar Sample Bahan Utama</label></td>
                                    <td>
                                       <img style="height: 249px;width: 50%;" src="<?php echo $potongan['sample_bahan_utama_img'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Panjang Gelaran</label></td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" name="panjangGelaran" value="<?php echo $potongan['panjang_gelaran_potongan_utama'] ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Bahan</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="pemakaianBahan" value="<?php echo $potongan['pemakaian_bahan_utama']?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Jumlah Gambar </label></td>
                                    <td>
                                        <input type="number" class="form-control" name="jumlahGambar" value="<?php echo $potongan['jumlah_gambar_utama']?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Size </label></td>
                                    <td>
                                        <input type="text" class="form-control" name="sizeBahan" value="<?php echo $potongan['size_potongan'] ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label>Pemakaian Bahan Utama</label>
        <table class="table table-bordered" id="item_table">

                                <tr>

                                    <th>BIDANG BAHAN</th>

                                    <th>WARNA</th>

                                    <th>KODE BAHAN</th>

                                    <th>BERAT BHN</th>

                                    <th>SISA BHN</th>

                                    <th>PEMAKAIAN BHN</th>

                                    <th>BANYAK LAPIS</th>

                                    <!-- <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th> -->

                                </tr>

                                <?php foreach($utama as $bahan){?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="bidangBahan[]" value="<?php echo $bahan['bidang_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['bidang_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="warna[]" value="<?php echo $bahan['warna_potongan']?>" class="form-control">
                                            <?php echo $bahan['warna_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="kodeBahan[]" value="<?php echo $bahan['kode_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['kode_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="beratBahan[]" value="<?php echo $bahan['berat_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['berat_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="sisaBahan[]" value="<?php echo $bahan['sisa_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['sisa_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="text" name="pemakaianBahankg[]" value="<?php echo $bahan['pemakaian_bahan_potongan']?>" required>
                                        </td>
                                        <td>
                                            <input type="text" name="banyakLapis[]" value="<?php echo $bahan['banyak_lapis_potongan']?>" required>
                                        </td>

                                    </tr>
                                <?php } ?>

                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
                                <tr>
                                    <td><label>Panjang Gelar Variasi</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="panjangGelaranVariasi" value="<?php echo $potongan['panjang_gelaran_variasi']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Gelaran Variasi</label></td>
                                    <td>
                                        <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" value="<?php echo $potongan['jumlah_pemakaian_bahan_variasi']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Sample Bahan Image Variasi</label>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="sempleBhnImgVar" >
                                    </td>
                                </tr>
                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label>Pemakaian Bahan Celana / Variasi</label>
        <table class="table table-bordered" id="item_tabl2e">

                                <tr>

                                    <th>BIDANG BAHAN</th>

                                    <th>WARNA</th>

                                    <th>KODE BAHAN</th>

                                    <th>BERAT BHN</th>

                                    <th>SISA BHN</th>

                                    <th>PEMAKAIAN BHN</th>

                                    <th>BANYAK LAPIS</th>

                                    <!-- <th><button type="button" name="add" class="btn btn-success btn-sm add2"><i class="fa fa-plus"></i></button></th> -->

                                </tr>

                                <?php foreach($variasi as $bahan){?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="bidangBahanVar[]" value="<?php echo $bahan['bidang_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['bidang_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="warnaVar[]" value="<?php echo $bahan['warna_potongan']?>" class="form-control">
                                            <?php echo $bahan['warna_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="kodeBahanVar[]" value="<?php echo $bahan['kode_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['kode_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="beratBahanVar[]" value="<?php echo $bahan['berat_bahan_potongan']?>" class="form-control">
                                            <?php echo $bahan['berat_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="sisaBahanVar[]" value="<?php echo $bahan['sisa_bahan_potongan']?>" required>
                                            <?php echo $bahan['sisa_bahan_potongan']?>
                                        </td>
                                        <td>
                                            <input type="text" name="pemakaianBahankgVar[]" value="<?php echo $bahan['pemakaian_bahan_potongan']?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="banyakLapisVar[]" value="<?php echo $bahan['banyak_lapis_potongan']?>" required>
                                        </td>

                                    </tr>
                                <?php } ?>

                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <a href="<?php echo BASEURL.'Kelolapo/bukupotongan'?>" class="btn btn-danger text-white btn-sm" style="width: 100%">Batal</a>
    </div>
    <div class="col-md-6 col-sm-12">
        <button type="submit" class="btn btn-success btn-sm" style="width: 100%">Update</button>
    </div>
</div>
</form>