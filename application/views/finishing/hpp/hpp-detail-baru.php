<style type="text/css">

    table, th, td {
        font-size: 25px !important;
        border: 2px solid black !important;

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
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-size: 20px !important;
    font-weight:bold;
    float: right;
  }

  .center { text-align:center !important;}
  .right { text-align:right !important;}
</style>

<div class="row">
    <div class="col-md-12">
        <table class="table " border="2" style="border: 2px solid black !important;">
            <tr>
                <td colspan="5" class="text-center">
                    <h1>HPP <?php echo $jenis?> </h1>
                </td>
            </tr>
            <tr>
                <td>PO</td>
                <td><?php echo $po['nama_hpp'] ?></td>
                <td rowspan="8" width="25%" height="70%">
                    <b style="text-decoration:underline"> Spesifikasi PO : <small class="no-print"></small></b>
                    <div style="font-size: 23.5px !important">
                        <?php if(!empty($spek)){ ?>
                            <?php 
                                foreach($spek as $s){
                                    echo $s['kolom'].' : '.$s['isi'].'<br>';
                                }
                            ?>
                        <?php } ?>
                    </div>
                </td>
                <td rowspan="8" width="25%" height="70%">
                    <img src="<?php echo BASEURL.$po['gambar_po'] ?>" style="width: 100%;"  >
                </td>
                <?php if(!empty($po['gambar_po2'])){ ?>
                <td rowspan="8" width="25%" height="70%">
                    <img src="<?php echo BASEURL.$po['gambar_po2'] ?>" style="width: 100%;"  >
                </td>
                <?php } ?>
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
                    <?php echo $namabahan['nama_item_keluar'] ?>
                </td>
            </tr>
            <tr>
                <td>TIM POTONG</td>
                <td><?php echo strtoupper($timpotong) ?></td>
            </tr>
            <tr>
                <td>JUMLAH PO</td>
                <td>
                    <?php echo isset( $produk['jml_setor_qty'])? $produk['jml_setor_qty']:0 ?> PCS<br>
                    <?php echo isset( $produk['jml_setor_qty'])? $produk['jml_setor_qty']/12:0 ?> DZ
                </td>
            </tr>
            <tr>
                <td>CMT JAHIT</td>
                <td><?php echo strtoupper($namacmt) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table " border="2" style="border: 2px solid black !important;">
            <thead>
                <tr>
                    <th><center>NO</center></th>
                    <th><center>PERINCIAN BIAYA</center></th>
                    <th width="120"><center>KETERANGAN</center></th>
                    <th><center>HARGA</center></th>
                    <th width="200"><center>JUMLAH</center></th>
                </tr>
            </thead>
            <tbody>
                <?php $total=0;?>
                <tr>
                    <td class="center">1</td>
                    <td>BAHAN UTAMA</td>
                    <td class="center"><?php echo $pot['jumlah_pemakaian_bahan_utama'] ?></td>
                    <td class="center"><?php echo number_format($namabahan['harga_item']) ?></td>
                    <td class="right"><?php echo number_format($namabahan['harga_item']*$pot['jumlah_pemakaian_bahan_utama'])?></td>
                    <?php $total+=($namabahan['harga_item']*$pot['jumlah_pemakaian_bahan_utama'])?>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>BAHAN VARIASI</td>
                    <td class="center">0</td>
                    <td class="center">0</td>
                    <td class="right">0</td>
                </tr>
                <tr>
                    <td class="center">3</td>
                    <td>BAHAN CELANA</td>
                    <td class="center"><?php echo !empty($pot)?$pot['jumlah_pemakaian_bahan_variasi']:'0'; ?></td>
                    <td class="center"><?php echo !empty($celana)?number_format($celana['harga_item']):'0'; ?></td>
                    <td class="right"><?php echo !empty($celana)?number_format($celana['harga_item']*$pot['jumlah_pemakaian_bahan_variasi']):'0'; ?></td>
                    <?php $total+=!empty($celana)?($celana['harga_item']*$pot['jumlah_pemakaian_bahan_variasi']):0; ?>
                </tr>
                <tr>
                    <td class="center">4</td>
                    <td>KAIN - KANTONG</td>
                    <td class="center"><?php echo $kainkantong['ukuran_item_keluar']?></td>
                    <td class="center"><?php echo number_format($kainkantong['harga_item']) ?></td>
                    <td class="right"><?php echo number_format($kainkantong['harga_item']*$kainkantong['ukuran_item_keluar'])?></td>
                    <?php $total += !empty($kainkantong)?($kainkantong['harga_item']*$kainkantong['ukuran_item_keluar']):0?>
                </tr>
                <tr>
                    <td class="center">5</td>
                    <td>ONGKOS POTONG</td>
                    <td class="center">12</td>
                    <td class="center"><?php echo number_format($master_harga_potongan['harga_potongan']) ?></td>
                    <td class="right"><?php echo number_format($master_harga_potongan['harga_potongan'] * 12); ?></td>
                    <?php $total += ($master_harga_potongan['harga_potongan'] * 12); ?>
                </tr>
                <tr>
                    <td class="center">6</td>
                    <td>BORDIR : <?php echo strtoupper($bordir['nama_cmt']) ?></td>
                    <td class="center"></td>
                    <td class="center"></td>
                    <td class="right"><?php echo number_format($biaya_bordir['total']/$pot['hasil_lusinan_potongan']) ?></td>
                    <?php $total+=($biaya_bordir['total']/$pot['hasil_lusinan_potongan']) ?><
                </tr>
                <tr>
                    <td class="center">7</td>
                    <td>SABLON : <?php echo !empty($sablon)?strtoupper($sablon['cmt_name']):'-';?> <?php echo empty($sablon)?'':'' ?></td>
                    <td class="center"></td>
                    <td class="center"></td>
                    <td class="right"><?php echo !empty($sablon)?number_format($sablon['cmt_job_price']):'0';?></td>
                    <?php $total+=!empty($sablon)?$sablon['cmt_job_price']:0;?>
                </tr>
                <tr>
                    <td class="center">8</td>
                    <td>JAHIT : <?php echo strtoupper($namacmt) ?></td>
                    <td class="center"></td>
                    <td class="center"></td>
                    <td class="right"><?php echo !empty($jahit)?number_format($jahit['cmt_job_price']):'0';?></td>
                    <?php $total += !empty($jahit)?($jahit['cmt_job_price']):0;?>
                </tr>
                <?php $no=8;$totplastik=0;?>
                <?php if(!empty($plastik)){ ?>
                    
                    <?php foreach($plastik as $p){?>
                        <?php $total+=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totkarton=0;?>
                <?php if(!empty($karton)){ ?>
                    <?php foreach($karton as $p){?>
                        <?php $total+=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totpita=0;?>
                <?php if(!empty($pita)){ ?>
                    <?php foreach($pita as $p){?>
                        <?php $total+=(($p['harga_item']/42)*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?> Roll<br><?php echo round($p['harga_item'] / 42,1) ?> Pcs</td>
                            <td class="right"><?php echo number_format(($p['harga_item']/42)*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totkaret=0;?>
                <?php if(!empty($karet)){ ?>
                    <?php foreach($karet as $p){?>
                        <?php $total+=(($p['harga_item']/48)*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?> Roll<br><?php echo round($p['harga_item'] / 48,1) ?> Pcs</td>
                            <td class="right"><?php echo number_format(($p['harga_item']/48)*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $tothangtag=0;?>
                <?php if(!empty($hangtag)){ ?>
                    <?php foreach($hangtag as $p){?>
                        <?php $total+=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totlabel=0;?>
                <?php if(!empty($label)){ ?>
                    <?php foreach($label as $p){?>
                        <?php $total+=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totsizebordir=0;?>
                <?php if(!empty($size_bordir)){ ?>
                    <?php foreach($size_bordir as $p){?>
                        <?php $total+=(($p['harga_item']/40)*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?> Roll<br><?php echo number_format($p['harga_item']/40);?> Pcs</td>
                            <td class="right"><?php echo number_format(($p['harga_item']/40)*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php $totsizetempel=0;?>
                <?php if(!empty($size_tempel)){ ?>
                    <?php foreach($size_tempel as $p){?>
                        <?php $total +=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($kancing)){ ?>
                    <?php foreach($kancing as $p){?>
                        <?php $total+=($p['harga_item']*$p['jumlah_item_perlusin']);?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td><?php echo strtoupper($p['nama_item_keluar'])?></td>
                            <td class="center"><?php echo $p['jumlah_item_perlusin']?></td>
                            <td class="center"><?php echo number_format($p['harga_item']);?></td>
                            <td class="right"><?php echo number_format($p['harga_item']*$p['jumlah_item_perlusin']);?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($tress)){ ?>
                    <?php foreach($tress as $p){?>
                        <?php 
                            if(strtolower($po['nama_po'])=="kfb" OR strtolower($po['nama_po'])=="kkf" OR strtolower($po['nama_po'])=="skf"){
                                $hargapertitik=30;
                            }
                        ?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper($p['kategori'])?></td>
                            <td class="center"><?php echo ($p['jumlah_titik']*12)?></td>
                            <td class="center"><?php echo number_format($hargapertitik);?></td>
                            <td class="right"><?php echo number_format(($p['jumlah_titik']*12)*$hargapertitik);?></td>
                        </tr>
                        <?php $total +=(($p['jumlah_titik']*12)*$hargapertitik);?>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($lobang)){ ?>
                    <?php foreach($lobang as $p){?>
                        <?php 
                            if(strtolower($po['nama_po'])=="kfb" OR strtolower($po['nama_po'])=="kkf" OR strtolower($po['nama_po'])=="skf"){
                                $hargapertitik=30;
                            }
                        ?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper($p['kategori'])?></td>
                            <td class="center"><?php echo ($p['jumlah_titik']*12)?></td>
                            <td class="center"><?php echo number_format($hargapertitik);?></td>
                            <td class="right"><?php echo number_format(($p['jumlah_titik']*12)*$hargapertitik);?></td>
                        </tr>
                        <?php $total+=(($p['jumlah_titik']*12)*$hargapertitik);?>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($pasang)){ ?>
                    <?php foreach($pasang as $p){?>
                        <?php 
                            if(strtolower($po['nama_po'])=="kfb" OR strtolower($po['nama_po'])=="kkf" OR strtolower($po['nama_po'])=="skf"){
                                $hargapertitik=30;
                            }
                        ?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper($p['kategori'])?></td>
                            <td class="center"><?php echo ($p['jumlah_titik']*12)?></td>
                            <td class="center"><?php echo number_format($hargapertitik);?></td>
                            <td class="right"><?php echo number_format(($p['jumlah_titik']*12)*$hargapertitik);?></td>
                        </tr>
                        <?php $total +=(($p['jumlah_titik']*12)*$hargapertitik);?>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($cucian)){ ?>
                    <?php foreach($cucian as $p){?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper("cucian")?></td>
                            <td class="center"></td>
                            <td class="center"><?php echo number_format($p['total']/12);?></td>
                            <td class="right"><?php echo number_format($p['total']);?></td>
                        </tr>
                        <?php $total += ($p['total']);?>
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($buangbenang)){ ?>
                    <?php foreach($buangbenang as $p){?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper("buang benang")?></td>
                            <td class="center"></td>
                            <td class="center"><?php echo number_format($p['harga']);?></td>
                            <td class="right"><?php echo number_format($p['harga']*12);?></td>
                        </tr>
                        <?php $total+=($p['harga']*12);?><
                    <?php } ?>
                <?php } ?>
                <?php if(!empty($packing)){ ?>
                    <?php foreach($packing as $p){?>
                        <tr>
                            <td class="center"><?php echo $no+=1 ?></td>
                            <td>BIAYA <?php echo strtoupper("packing")?></td>
                            <td class="center"></td>
                            <td class="center"><?php echo number_format($p['harga_dz']/12);?></td>
                            <td class="right"><?php echo number_format($p['harga_dz']);?></td>
                        </tr>
                        <?php $total += ($p['harga_dz']);?>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td class="center" colspan="4"><b>TOTAL</b></td>
                    <td class="right" ><b>Rp.&nbsp;<?php echo number_format($total) ?></b></td>
                </tr>
                <tr>
                    <form action="<?php echo BASEURL.'finishing/submitOperational' ?>" method="post">
                        <td class="center" colspan="4"><b>OPERASIONAL</b></td>
                        <td class="right" >
                            <b class="print"><?php $opr= (empty($po['operaitonal_price'])) ? $operation['val_operational'] : $po['operaitonal_price']; echo 'Rp. '.number_format($opr); ?></b>
                            <span  class="no-print">
                            <input type="text" class="form-control no-print" name="valOperation" id="valOperation" value="<?php echo (empty($po['operaitonal_price'])) ?0 : $po['operaitonal_price'] ?>">
                                <input type="hidden" value="<?php echo $po['kode_po'] ?>" name="kode_po">
                                <input class="btn btn-info no-print" type="submit" id="" name="button" value="UPDATE">
                            </span>
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>