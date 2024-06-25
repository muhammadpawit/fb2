<style type="text/css">
    table {
        width: 100%;
        font-size: 18.5px !important;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
    }
    table, th, td {
        
        border: 1px solid black !important;
        border-collapse: collapse;

    }
    h6{
        font-size: 25px !important;
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
                            <table style="width: 100%;">

                                <tr>

                                    <td colspan="4" class="text-center">

                                        <center>
                                            <h1>
                                                HPP <?php echo $jenis?> 
                                            </h1>
                                        </center>

                                    </td>

                                </tr>
                                <tr>
                                    <td width="20%">&nbsp;PO</td>
                                    <td width="20%">&nbsp;<?php echo $po['nama_hpp'] ?></td>
                                    <td width="20%" rowspan="8" valign="middle" align="center">
                                        <img src="<?php echo BASEURL.$po['gambar_po'] ?>" style="width: 100%;"  >
                                    </td>
                                    <td width="20%" rowspan="8" valign="middle" align="center">
                                        <img src="<?php echo BASEURL.$po['gambar_po2'] ?>" style="width: 100%;"  >
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;ARTIKEL</td>
                                    <td>&nbsp;<?php echo $po['kode_artikel'] ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;JENIS</td>
                                    <td>&nbsp;<?php echo $po['jenis_po'] ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;SIZE</td>
                                    <td>&nbsp;<?php echo $pot['size_potongan'] ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;BAHAN</td>
                                    <td>&nbsp;<?php echo $namabahan['nama_item_keluar'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;TIM POTONG</td>
                                    <td>&nbsp;<?php echo strtoupper($timpotong) ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;JUMLAH PO</td>
                                    <td>&nbsp;<?php echo isset( $pot['hasil_pieces_potongan'])? $pot['hasil_pieces_potongan']:0 ?> PCS / <?php echo isset( $pot['hasil_lusinan_potongan'])? $pot['hasil_lusinan_potongan']:0 ?> DZ
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;CMT JAHIT</td>
                                    <td>&nbsp;<?php echo strtoupper($namacmt) ?></td>
                                </tr>

                            </table>

                            <table style="width: 100%;">
                                <tr>
                                    <td colspan="5">
                                        <div style="padding:5px;">
                                            <div>
                                            <b> Spesifikasi PO <small class="no-print"></small></b>
                                            </div>
                                            <?php if(!empty($spek)){ ?>
                                                <?php 
                                                    foreach($spek as $s){
                                                        echo $s['kolom'].' : '.$s['isi'].'<br>';
                                                    }
                                                ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table class="table" style="width: 100%;" cellpadding="5">

                                <tr class="text-center">
                                	<th width="5%"><center>No</center></th>

                                    <th width="50%"><center>PERINCIAN BIAYA</center></th>

                                    <th><center>KETERANGAN</center></th>

                                    <th><center>HARGA</center></th>

                                    <th ><center>JUMLAH</center></th>

                                </tr>

                        <?php $no=0;$resiko = 0;$total = 0; $totalAlat = 0; if (isset($bahan)): ?>

                            <?php foreach ($bahan as $key => $bahanAja): ?>

                                <?php if ($bahanAja['bahan_kategori'] == "UTAMA"){ ?>

                                <tr>
                                	<td><center><?php echo $no+=1?></center></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_utama'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                    <td align="right"><?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); ?></td>

                                    <?php 

                                    $totalAlat +=($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); 

                                    ?>

                                </tr>

                                

                                <?php } else if($bahanAja['bahan_kategori'] == "CELANA"){ ?>



                                <tr>
                                	<td><center><?php echo $no+=1?></center></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_variasi'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                    <td align="right">

                                        <?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); 

                                    ?>

                                </tr>



                                <?php } else if($bahanAja['bahan_kategori'] == "KAINKANTONG") { ?> 

                                <tr>
                                	<td><center><?php echo $no+=1?></center></td>
                                    <td>

                                        <?php echo str_replace("KAINKANTONG","KAIN - KANTONG",$bahanKantong['bahan_kategori']) ?>

                                    </td>

                                    <td align="center">

                                        <?php echo $bahanKantong['ukuran_item_keluar'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo number_format($bahanKantong['harga_item']) ?>

                                    </td>

                                    <td align="right">

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

                                    <td align="center">

                                        <?php echo $variasi['ukuran_item_keluar'] ?>

                                    </td>

                                    <td align="center">

                                        <?php echo number_format($variasi['harga_item']) ?>

                                    </td>

                                    <td align="right">

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
                                	<td><center><?php echo $no+=1?></center></td>
                                    <td>

                                        ONGKOS POTONG

                                    </td>

                                    <td align="center">

                                        12

                                    </td>

                                    <td align="center">

                                        <?php echo number_format($master_harga_potongan['harga_potongan']) ?>

                                    </td>

                                    <td align="right">

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
                                        <td><center><?php echo $no+=1?></center></td>

                                        <td>
                                            <?php if($cmtt['kategori_cmt']=='JAHIT'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : <?php echo strtoupper($cmtt['nama_cmt']) //echo strtoupper($produk['nama_cmt']) ?>
                                            <?php }else if($cmtt['kategori_cmt']=='BORDIR'){ ?>
                                                <?php if($produk['nama_po']=="PFK"){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : LUAR
                                                <?php }else{?>
                                                    <?php echo $cmtt['kategori_cmt'] ?> : DALAM
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <?php if($cmtt['kategori_cmt']=='SABLON'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : <?php echo $cmtt['id_master_cmt']>0?strtoupper($cmtt['nama_cmt']):' '; ?>
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
                                            <td align="right">
                                                
                                                        <?php echo number_format($bordirHitung / $bukupotongan['hasil_lusinan_potongan']) ; ?>
                                            </td>



                                            <?php } else if($cmtt['kategori_cmt'] == "SABLON") { ?>

                                                <?php //if($produk['kode_po']=="SWF01" OR $produk['kode_po']=="FBS05" OR $produk['kode_po']=="FBS03" OR $produk['kode_po']=="FBO03" OR $produk['kode_po']=="HGSO03"){ // po if ?>
                                                <?php //if($cmtt['id_master_cmt_job']>=81){?>
                                                    <?php $totalAlat +=($cmtt['cmt_job_price']+$bawahansablon);  ?>
                                                    <td align="right"><?php echo number_format($cmtt['cmt_job_price']+$bawahansablon); ?></td>

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

                                            <td align="right">
                                                <?php echo number_format($cmtt['cmt_job_price']); ?>   

                                            </td>



                                            <?php } ?>

                                        <?php //} ?>

                                    </tr>

                                <?php endforeach ?>



                                <?php $rinciItem = 0;$rinciCmt=0; ?>

                                <?php foreach ($perincian as $key => $rinci): ?>

                                    <?php $explodeBordir = explode(' ', $rinci['nama_item_keluar']); ?>

                                    <?php if (strtoupper($rinci['nama_item_keluar']) == "KARET 555A" OR strtoupper($rinci['nama_item_keluar']) == "SIMULASI KARET 555A") {?>

                                    <tr>
                                        <td><center><?php echo $no+=1?></center></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?> 

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 48,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                <?php } elseif (strtoupper($rinci['nama_item_keluar']) == "KARET 11A") {?>

                                    <tr>
                                        <td><center><?php echo $no+=1?></center></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td align="center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 72,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "PITA" OR strtoupper($rinci['nama_item_keluar']) == "SIMULASI PITA" ) {?>

                                    <tr>
                                        <td><center><?php echo $no+=1?></center></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td align="center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round( ($rinci['jumlah_item_keluar']*$rinci['harga_item'])  / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                        </td>

                                        

                                        <?php 
                                            $hargapita=2000;
                                            
                                        $total += $hargapita; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format($hargapita) ?>

                                        </td>

                                    </tr>

                                   <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "LABEL 108") { ?>

                                    <tr>
                                        <td><center><?php echo $no+=1?></center></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['harga_item'] ?> 

                                        </td>

                                        <?php 

                                        $total += $rinci['harga_item'] * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item']) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtolower($explodeBordir[1]) == "bordir") {  ;?>

                                    <tr>

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td align="center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['jumlah_item_keluar']*$rinci['harga_item'] / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                        </td>

                                        <?php 
                                            $hargasizebordir=1000;
                                        $total += $hargasizebordir=1000;; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format($hargasizebordir) ?>

                                        </td>

                                    </tr> 

                                    

                                   <?php  } elseif (strtolower($rinci['nama_item_keluar']) == "simulasi size bordir" OR strtolower($rinci['nama_item_keluar']) == "size bordir") {  ;?>

                                                <tr>

                                                    <td><center><?php echo $no+=1?></center></td>

                                                    <td>

                                                        <?php echo $rinci['nama_item_keluar'] ?>

                                                    </td>

                                                    <td align="center">

                                                        <?php echo $rinci['jumlah_item_perlusin'] ?>

                                                    </td>

                                                    <td align="center">

                                                        (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['jumlah_item_keluar']*$rinci['harga_item'] / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                                    </td>

                                                    <?php 
                                                        $hargasizebordir=1000;
                                                    $total += $hargasizebordir=1000;; 

                                                    ?>

                                                    <td align="right">

                                                        <?php echo number_format($hargasizebordir) ?>

                                                    </td>

                                                </tr> 



                                                <?php  } else { ?>

                                    <tr>

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                        <td align="center">

                                            <?php echo $rinci['harga_item'] ?>

                                        </td>

                                        <?php 

                                        $total += $rinci['jumlah_item_perlusin'] * $rinci['harga_item']; 

                                        ?>

                                        <td align="right">

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
                                        if(strtolower($produk['nama_po'])=="kfb" OR strtolower($produk['nama_po'])=="kkf" OR strtolower($produk['nama_po'])=="skf"
                                        OR strtolower($produk['nama_po'])=="ksf"
                                        ){
                                            $hargapertitik=30;
                                        }
                                    ?>
                                    <tr>

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?$mesin['kategori']:$mesin['kategori']) ?></td>

                                        <td align="center"><?php echo $mesin['jumlah_titik']*12 ?></td>

                                        <td align="center"><?php echo $hargapertitik ?></td>

                                        <td align="right"><?php echo number_format(($mesin['jumlah_titik']*12)*$hargapertitik) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['jumlah_titik']*12)*$hargapertitik;
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($buangbenang as $key => $mesin): ?>

                                    <tr>

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Buang Benang":'Buang Benang') ?></td>

                                        <td align="center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td align="center"><?php echo $mesin['harga'] ?></td>

                                        <td align="right"><?php echo number_format(($mesin['harga']*12)) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['harga']*12);
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($packing as $key => $mesin): ?>

                                    <tr>

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Packing":'Packing') ?></td>

                                        <td align="center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td align="center"><?php echo number_format( $mesin['harga_dz']/12,0) ?></td>

                                        <td align="right"><?php echo number_format($mesin['harga_dz']) ?></td>

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

                                        <td><center><?php echo $no+=1?></center></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"cucian":'cucian') ?></td>

                                        <td align="center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                        <td align="center"><?php echo number_format($harga) ?></td>

                                        <td align="right"><?php echo number_format(($harga*12)) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($harga*12);
                                    ?>

                                <?php endforeach ?>

                                <?php if($biayalain){?>

                                    <?php foreach($biayalain as $b){?>

                                        <tr>

                                            <td><center><?php echo $no+=1?></center></td>

                                            <td><?php echo $b['namabiaya'] ?></td>

                                            <td align="center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                            <td align="center"><?php echo number_format($b['biaya']) ?></td>

                                            <td align="right"><?php echo number_format($b['biaya']) ?></td>

                                        </tr>

                                    <?php
                                        $total+=($b['biaya']);
                                    ?>

                                    <?php } ?>

                                <?php } ?>


                                <tr>

                                    <td colspan="4" align="center">TOTAL</td>

                                    <td align="right">Rp. <?php  

                                    $totalHPP = $total + $totalAlat;

                                    echo number_format($total + $totalAlat); 

                                    ?></td>

                                </tr>

                                <tr>

                                    <td colspan="4" align="center">OPERASIONAL</td>

                                    <td  align="right">

                                    <?php $opr=0;$opr= (empty($po['operaitonal_price'])) ? $operation['val_operational'] : $po['operaitonal_price']; echo 'Rp. '.number_format($opr); ?>

                                    </td>

                                </tr>



                                <tr>

                                    <td colspan="4"  align="center">GRAND TOTAL</td>

                                    <td id="grandTotal" align="right">

                                        Rp. <?php $grand= $po['operaitonal_price'] + $total + $totalAlat; 

                                            echo number_format($grand);?> 

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="4"  align="center">HARGA PCS</td>

                                    <td id="hargaPCS" align="right">

                                        Rp. <?php echo number_format($grand / 12) ?>

                                    </td>

                                </tr>

                            </table>
                            <br>
                            <br>
                            <table border="0" style="border: 0px solid !important;" cellpadding="27">
                                <tr>
                                    <td align="right">
                                        Persetujuan Pimpinan<br>
                                        Tanggal : <?php echo strtoupper(date('d F Y')) ?>
                                        <?php 
                                             for($i=0;$i<=5;$i++){
                                                echo "<br>"; 
                                             }        
                                        ?>
                                        ( H.RICKO WENDRA )
                                    </td>
                                </tr>
                            </table>