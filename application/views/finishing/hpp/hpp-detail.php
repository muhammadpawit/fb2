<style type="text/css">

    table, th, td {
        font-size: 30px !important;
        border: 2px solid black !important;

    }
    h6{
        font-size: 30px !important;
    }
	.print{ display:none !important}
	@media print
{    
	.print{ display:block !important}
    .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-size: 20px !important;
    font-weight:bold;
    float: right;
  }
</style>
<!-- Start Page content -->

<div class="content">

    <div class="container-fluid">

        <div class="row no-print">
            <div class="col-md-2">
                <a href="<?php echo $back ?>" class="btn btn-danger btn-sm full">Kembali</a>
            </div>
        </div>
        <br>

        <div class="row">

            <div class="col-md-12">

                <div class="card-box">



                    <div class="row">

                        <div class="col-12">

                            <table class="table " border="2" style="border: 2px solid black !important;">

                                <tr>

                                    <td colspan="5" class="text-center">

                                        <h3>HPP <?php echo $jenis?> </h3>

                                    </td>

                                </tr>

                                <tr>

                                    <td>PO</td>

                                    <td><?php echo $po['nama_po'].' '.$po['nama_hpp'] ?></td>
                                    <td rowspan="8" width="25%" height="70%">
                                        Spesifikasi Gambar <small class="no-print"><pre>Gunakan &#60;br&#62; untuk enter </pre></small>
                                        <form method="post" action="<?php echo BASEURL?>Finishing/save_spesifikasi">
                                            <input type="hidden" name="idpo" value="<?php echo $po['id_produksi_po']?>">
                                            <div class="no-print">
                                                <textarea name="spesifikasi"><?php echo $po['spesifikasi']?></textarea>
                                            </div>
                                            <div class="print" style="display: none;"><?php echo $po['spesifikasi']?></div>
                                            <button type="submit" class="no-print">Submit</button>
                                        </form>
                                    </td>
                                    <td rowspan="8" width="25%" height="70%">

                                        <?php //if (!empty($produk['gambar_po'])){ ?>

                                            <img src="<?php echo BASEURL.$po['gambar_po'] ?>" style="width: 100%;"  >

                                        <?php //} else { ?>

                                        <form action="<?php echo BASEURL.'finishing/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST">

                                            <div class="row no-print">

                                                <div class="form-group col-12 text-center">

                                                    <label>Gambar KAOS</label>

                                                    <input type="file" name="gambarPO1" class="form-control">

                                                    <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">

                                                </div>

                                                <div class="col-12">

                                                    <button type="submit" class="btn btn-warning"> SUBMIT</button>

                                                </div>

                                            </div>

                                        </form>

                                        <?php //} ?>

                                    </td>

                                    <td rowspan="8" width="25%" height="70%">

                                        <?php //if (!empty($produk['gambar_po2'])){ ?>

                                            <img src="<?php echo BASEURL.$po['gambar_po2'] ?>" style="width: 100%;"  >

                                        <?php //} else { ?>

                                        <form action="<?php echo BASEURL.'finishing/submitImageHppdua' ?>" enctype="multipart/form-data" method="POST">

                                            <div class="row no-print">

                                                <div class="form-group col-12 text-center">

                                                    <label>Gambar KAOS</label>

                                                    <input type="file" name="gambarPO2" class="form-control">

                                                    <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">

                                                </div>

                                                <div class="col-12">

                                                    <button type="submit" class="btn btn-warning"> SUBMIT</button>

                                                </div>

                                            </div>

                                        </form>

                                        <?php //} ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td>ARTIKEL</td>

                                    <td><?php echo $po['kode_artikel'] ?></td>

                                    

                                </tr>

                                <tr>

                                    <td>JENIS</td>

                                    <td><?php echo $po['jenis_po'] ?></td>

                                </tr>

                                <tr>

                                    <td>SIZE</td>

                                    <td><?php echo $pot['size_potongan'] ?></td>

                                </tr>

                                <tr>

                                    <td>BAHAN</td>

                                    <td>
                                        <?php //echo $produk['bahan_potongan'] ?>
                                        <?php echo $namabahan['nama_item_keluar'] ?>
                                    </td>

                                </tr>

                                <tr>

                                    <td>TIM POTONG</td>

                                    <td><?php echo strtoupper($timpotong) ?></td>

                                </tr>

                                <tr>

                                    <td>JUMLAH PO</td>

                                    <td><?php echo isset( $produk['jml_setor_qty'])? $produk['jml_setor_qty']:0 ?> PCS</td>

                                </tr>

                                <tr>

                                    <td>NAMA CMT</td>


                                    <td><?php echo strtoupper($namacmt) ?></td>

                                </tr>

                            </table>

                            

                        </div>



                        <div class="col-12">

                            <table class="table " border="2" style="border: 2px solid black !important;">

                                <tr class="text-center">
                                	<th>No</th>

                                    <th>PERINCIAN BIAYA</th>

                                    <th>KETERANGAN</th>

                                    <th>HARGA</th>

                                    <th>JUMLAH</th>

                                </tr>

                        <?php $no=0;$resiko = 0;$total = 0; $totalAlat = 0; if (isset($bahan)): ?>

                            <?php foreach ($bahan as $key => $bahanAja): ?>

                                <?php if ($bahanAja['bahan_kategori'] == "UTAMA"){ ?>

                                <tr>
                                	<td><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_utama'] ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                    <td><?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); ?></td>

                                    <?php 

                                    $totalAlat +=($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); 

                                    ?>

                                </tr>

                                

                                <?php } else if($bahanAja['bahan_kategori'] == "CELANA"){ ?>



                                <tr>
                                	<td><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_variasi'] ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); 

                                    ?>

                                </tr>



                                <?php } else if($bahanAja['bahan_kategori'] == "KAINKANTONG") { ?> 

                                <tr>
                                	<td><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $bahanKantong['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bahanKantong['ukuran_item_keluar'] ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($bahanKantong['harga_item']) ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($bahanKantong['harga_item'] * $bahanKantong['ukuran_item_keluar']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($bahanKantong['harga_item'] * $bahanKantong['ukuran_item_keluar']); 

                                    ?>

                                </tr> 

                                <?php } ?>

                            <?php endforeach ?>
                            
                            <?php if(!empty($variasi)){?>
                                <tr>
                                    <td><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $variasi['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $variasi['ukuran_item_keluar'] ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($variasi['harga_item']) ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($variasi['harga_item'] * $variasi['ukuran_item_keluar']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($variasi['harga_item'] * $variasi['ukuran_item_keluar']); 

                                    ?>

                                </tr> 
                            <?php } ?>

                        <?php endif ?>



                            <?php if (isset($master_harga_potongan)): ?>

                                <tr>
                                	<td><?php echo $no+=1?></td>
                                    <td>

                                        ONGKOS POTONG

                                    </td>

                                    <td class="text-center">

                                        12

                                    </td>

                                    <td>

                                        <?php echo number_format($master_harga_potongan['harga_potongan']) ?>

                                    </td>

                                    <td>

                                        <?php echo number_format($master_harga_potongan['harga_potongan'] * 12); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($master_harga_potongan['harga_potongan'] * 12); 

                                    ?>

                                </tr>

                            <?php endif ?>



                                <?php $bordirHitung = 0; ?>

                                <?php $explodeSize = explode('-', $bukupotongan['size_potongan']); ?>

                                <?php foreach ($cmt as $key => $cmtt): ?>

                                    <tr>
                                    	<td><?php echo $no+=1?></td>

                                        <td>
                                            <?php if($cmtt['kategori_cmt']=='JAHIT'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?>(<?php echo $namacmt //echo strtoupper($produk['nama_cmt']) ?>)
                                            <?php }else if($cmtt['kategori_cmt']=='BORDIR'){ ?>
                                                <?php if($produk['nama_po']=="PFK"){?>
                                                <?php echo $cmtt['kategori_cmt'] ?>(Luar)
                                                <?php }else{?>
                                                    <?php echo $cmtt['kategori_cmt'] ?>(DALAM)
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <?php if($cmtt['kategori_cmt']=='SABLON'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?>(<?php echo $cmtt['id_master_cmt']>0?strtoupper($cmtt['nama_cmt']):' '; ?>)
                                            <?php }?>
                                            <?php } ?>
                                            
                                        </td>

                                        <td></td>

                                        <td></td>

                                        <?php //if (isset($bordirer)){ ?>

                                            <?php if ($cmtt['kategori_cmt'] == "BORDIR"){ ?>


                                                
                                                <?php foreach ($bordirer as $key => $hasilBordir): ?>
                                                    <?php 
                                                        //$bordirHitung += $hasilBordir['total_tarif']; rumus lama
                                                        $bordirHitung += ($hasilBordir['total_stich']*0.18); // rumus baru
                                                    ?> 
                                                     

                                                <?php endforeach ?>
                                           
                                                <?php $totalAlat += $bordirHitung / $bukupotongan['hasil_lusinan_potongan']; ?>
                                            <td>
                                                
                                                        <?php echo number_format($bordirHitung / $bukupotongan['hasil_lusinan_potongan']) ; ?>
                                            </td>



                                            <?php } else if($cmtt['kategori_cmt'] == "SABLON") { ?>

                                                <?php //if($produk['kode_po']=="SWF01" OR $produk['kode_po']=="FBS05" OR $produk['kode_po']=="FBS03" OR $produk['kode_po']=="FBO03" OR $produk['kode_po']=="HGSO03"){ // po if ?>
                                                <?php //if($cmtt['id_master_cmt_job']>=81){?>
                                                    <?php $totalAlat +=($cmtt['cmt_job_price']+$bawahansablon);  ?>
                                                    <td><?php echo number_format($cmtt['cmt_job_price']+$bawahansablon); ?></td>

                                                <?php //} else{?> 
                                                    <?php 
                                                        /*
                                                         if($cmtt['cmt_job_price']<=25000){
                                                            $totalAlat +=25000; 
                                                         }else{
                                                            $totalAlat +=($cmtt['cmt_job_price']);    
                                                         }
                                                         */
                                                         //$totalAlat +=25000; 

                                                         ?>   
                                                        <!--
                                                        <td>
                                                            <?php //echo number_format(25000); ?>   
                                                            <?php if($cmtt['cmt_job_price']<=25000){
                                                                //echo number_format(25000);
                                                            }else{
                                                                //echo number_format($cmtt['cmt_job_price']);
                                                            }?>
                                                            <?php //echo number_format($cmtt['cmt_job_price']); ?>   

                                                        </td>-->
                                                    <?php //} // end po if ?>

                                            <?php } else { ?>



                                             <?php 

                                             $totalAlat +=($cmtt['cmt_job_price']); 

                                             ?>   

                                            <td>
                                                <?php echo number_format($cmtt['cmt_job_price']); ?>   

                                            </td>



                                            <?php } ?>

                                        <?php //} ?>

                                    </tr>

                                <?php endforeach ?>



                                <?php $rinciItem = 0;$rinciCmt=0; ?>

                                <?php foreach ($perincian as $key => $rinci): ?>

                                    <?php $explodeBordir = explode(' ', $rinci['nama_item_keluar']); ?>

                                    <?php if (strtoupper($rinci['nama_item_keluar']) == "KARET 555A") {?>

                                    <tr>
                                    	<td><?php echo $no+=1?></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?> 

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 48,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td>

                                            <?php echo number_format(($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                <?php } elseif (strtoupper($rinci['nama_item_keluar']) == "KARET 11A") {?>

                                    <tr>
                                    	<td><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 72,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td>

                                            <?php echo number_format(($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "PITA") {?>

                                    <tr>
                                    	<td><?php echo $no+=1?></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 42,1) ?> Pcs)

                                        </td>

                                        

                                        <?php 

                                        $total += ($rinci['harga_item'] / 42) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td>

                                            <?php echo number_format(($rinci['harga_item'] / 42) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                   <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "LABEL 108") { ?>

                                    <tr>
                                    	<td><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td>

                                            <?php echo $rinci['harga_item'] ?> 

                                        </td>

                                        <?php 

                                        $total += $rinci['harga_item'] * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td>

                                            <?php echo number_format(($rinci['harga_item']) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtolower($explodeBordir[1]) == "bordir") {  ;?>

                                    <tr>

                                    	<td><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 40) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 40) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td>

                                            <?php echo number_format(($rinci['harga_item'] / 40) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr> 

                                    

                                   <?php  } else { ?>

                                    <tr>

                                    	<td><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td>

                                            <?php echo $rinci['harga_item'] ?>

                                        </td>

                                        <?php 

                                        $total += $rinci['jumlah_item_perlusin'] * $rinci['harga_item']; 

                                        ?>

                                        <td>

                                            <?php echo number_format($rinci['jumlah_item_perlusin'] * $rinci['harga_item']) ?>

                                        </td>

                                    </tr>

                                    <?php } ?>

                                <?php $rinciItem += $rinci['jumlah_item_keluar'] * $rinci['harga_item']; ?>

                                <?php endforeach ?>
                                <?php $hargapertitik=0;?>
                                <?php foreach ($boronganmesin as $key => $mesin): ?>
                                    <?php 
                                        $hargapertitik=$mesin['harga_titik'];
                                        if(strtolower($produk['nama_po'])=="kfb" OR strtolower($produk['nama_po'])=="kkf" OR strtolower($produk['nama_po'])=="skf"){
                                            $hargapertitik=30;
                                        }
                                    ?>
                                    <tr>

                                    	<td><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?$mesin['kategori']:$mesin['kategori']) ?></td>

                                        <td class="text-center"><?php echo $mesin['jumlah_titik']*12 ?></td>

                                        <td><?php echo $hargapertitik ?></td>

                                        <td><?php echo ($mesin['jumlah_titik']*12)*$hargapertitik ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['jumlah_titik']*12)*$hargapertitik;
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($buangbenang as $key => $mesin): ?>

                                    <tr>

                                        <td><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Buang Benang":'Buang Benang') ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td><?php echo $mesin['harga'] ?></td>

                                        <td><?php echo ($mesin['harga']*12) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['harga']*12);
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($packing as $key => $mesin): ?>

                                    <tr>

                                        <td><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Packing":'Packing') ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td><?php echo number_format( $mesin['harga_dz']/12,0) ?></td>

                                        <td><?php echo ($mesin['harga_dz']) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['harga_dz']);
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($cucian as $key => $mesin): ?>
                                    <?php 
                                        //$harga=$mesin['harga'];
                                        //$harga=1000;
                                        $harga=$cucianhpp['cucianhpp'];
                                        /*
                                        if($produk['nama_po']=="KSK"){
                                            $harga=1000;
                                        }*/

                                    ?>

                                    <tr>

                                        <td><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"cucian":'cucian') ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td><?php echo $harga ?></td>

                                        <td><?php echo ($harga*12) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($harga*12);
                                    ?>

                                <?php endforeach ?>

                                <?php if($biayalain){?>

                                    <?php foreach($biayalain as $b){?>

                                        <tr>

                                        <td><?php echo $no+=1?></td>

                                            <td><?php echo $b['namabiaya'] ?></td>

                                            <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                            <td><?php echo number_format($b['biaya']) ?></td>

                                            <td><?php echo number_format($b['biaya']) ?></td>

                                        </tr>

                                    <?php
                                        $total+=($b['biaya']);
                                    ?>

                                    <?php } ?>

                                <?php } ?>


                                <tr>

                                    <td colspan="4" class="text-center">TOTAL</td>

                                    <td>Rp. <?php  

                                    $totalHPP = $total + $totalAlat;

                                    echo number_format($total + $totalAlat); 

                                    ?></td>

                                </tr>

                                <tr>

                                    <td colspan="4" class="text-center">OPERASIONAL</td>

                                    <td>

                                        <form action="<?php echo BASEURL.'finishing/submitOperational' ?>" method="post">

                                        <div class="row">

                                            <div class="col-12">
											<span class="print">
												<?php $opr=0;$opr= (empty($po['operaitonal_price'])) ? $operation['val_operational'] : $po['operaitonal_price']; echo 'Rp. '.number_format($opr); ?>
											</span>
                                            <input type="text" class="form-control no-print" name="valOperation" id="valOperation" value="<?php echo (empty($po['operaitonal_price'])) ?0 : $po['operaitonal_price'] ?>">
	
                                            </div>

                                            <input type="hidden" value="<?php echo $po['kode_po'] ?>" name="kode_po">

                                            <div class="col-12 mt-1">

                                                <input class="btn btn-info no-print" type="submit" id="" name="button" value="UPDATE">

                                            </div>

                                        </div>

                                        </form>

                                    </td>

                                </tr>



                                <tr>

                                    <td colspan="4" class="text-center">GRAND TOTAL</td>

                                    <td id="grandTotal">

                                        Rp. <?php $grand= $po['operaitonal_price'] + $total + $totalAlat; 

                                            echo number_format($grand);?> 

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="4" class="text-center">HARGA PCS</td>

                                    <td id="hargaPCS">

                                        Rp. <?php echo number_format($grand / 12) ?>

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="5">

                                        <div class="row">

                                            <div class="col-2"></div>

                                            <div class="col-4 text-right" style="padding-right: 14px;">

                                                <h6>PARAF PERSETUJUAN / ACC PIMPINAN</h6>

                                                <h6>TANGGAL : <?php echo date('d F Y') ?></h6>

                                                <br><br><br><br><br><br>

                                                <h6 style="padding-right: 80px">( H.RICKO WENDRA )</h6>

                                            </div>
                                            <div class="col-6">&nbsp;&nbsp;&nbsp;&nbsp;</div>

                                        </div>

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                    <!-- end row -->
            <i class="registered">Registered by Forboys Production System</i>

<?php 

// $nonsequential['BORDIR'] = array("namaCMT"=>"Pak Abdul", "IdCMT"=>"1"); 

// $nonsequential['BORDIR']['JOBDESK'] = array("KatJob"=>"Wangki", "priceJob"=>"100000"); 

// $nonsequential['JAHIT'] = array("namaCMT"=>"Bu Jenni", "IdCMT"=>"1"); 

// $nonsequential['JAHIT']['JOBDESK'] = array("KatJob"=>"Wangki", "priceJob"=>"100000"); 



// foreach ($nonsequential as $key => $value) {

//    print_r($value['namaCMT']);

// }

// pre($nonsequential);

?>



                    <div class="hidden-print mt-4 mb-4">

                        <div class="text-center">

                            <div class="row">

                                <div class="col-6">

                                     <form action="<?php echo BASEURL.'finishing/hppproduksidetailAct' ?>" method="POST" id="submit">

                                        <input type="hidden" name="hargasatuan" value="<?php echo ($grand / 12) ?>">

                                        <input type="hidden" name="kodepo" value="<?php echo $po['kode_po'] ?>">
                                        <!--
                                        <button type="submit" class="btn btn-info no-print">submit</button>-->
                                    </form>

                                </div>

                                <div class="col-6 no-print">

                                    <a onClick="printsubmit()" class="btn btn-primary waves-effect waves-light text-white"><i class="fa fa-print m-r-5"></i> Print</a>

                                </div>

                            </div>

                           

                            

                        </div>

                    </div>

                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->

<script type="text/javascript">

$( document ).ready(function() {

    $( "#valOperation" ).keyup(function() {

        var value = $(this).val();

        var tambah = (parseInt(<?php echo round($totalHPP) ?>)+parseInt(value));

        $('#grandTotal').text(tambah);

        $('#hargaPCS').text(new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(Math.round(tambah/12)));

    });

});

function printsubmit(){
        window.print();
    $("#submit").submit();
}

</script>