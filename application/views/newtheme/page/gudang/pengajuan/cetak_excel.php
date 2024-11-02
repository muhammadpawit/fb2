<?php
$filename='Pengajuan_Harian_'.date('d-m-Y',strtotime($parent['tanggal']));
//if(akseshapus()==1){

//}else{
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=".$filename.".xls");    
//}

?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  body{text-transform:capitalize !important;/*color:blue !important;*/} 
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table>
    <tr align="center">
        <td colspan="10">
            <h4 class="m-0">FORM AJUAN <?php echo $mingguan ?> FORBOYS<br>BAGIAN : <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";}else if($parent['kategori'] == 4) {echo "CABANG SUKABUMI";}?></h4>
<?php if($parent['status']==0){?>
                        <div style="z-index: 999;position: absolute;top:2%;right: 1%" class="alert alert-danger">
                            <h1>Pengajuan ini belum disetujui secara sistem</h1>
                        </div>
                    <?php } ?>            
        </td>
    </tr>
</table>

<table border="1" style="width: 100%;border-collapse: collapse;">

                                    <tr>

                                        <td><b>Hari</b></td>

                                        <td><b>TANGGAL</b></td>

                                    </tr>

                                    <tr>

                                        <td><b><?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?></b></td>

                                        <td><b><?php echo date('d/m/Y',strtotime($parent['tanggal'])) ?></b></td>

                                    </tr>

                                </table>                                  
<br>
<table border="1" style="width: 100%;border-collapse: collapse;">

                                    <thead>

                                        <tr>

                                            <th>NO.</th>

                                            <th>NAMA AJUAN</th>
                                            <th>WARNA</th>

                                            <th>JUMLAH</th>

                                            <th>SATUAN</th>
                                            <?php if( $parent['kategori']<4){ ?>
                                            <th width="125">HARGA SATUAN (Rp)</th>
                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>
                                            <th>TIPE PEMBAYARAN</th>
                                            <th>NAMA SUPPLIER</th>
                                            <?php } ?>
                                            <th>KETERANGAN</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">REVISI SPV</th>
                                            <?php }?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0;$warna=null; ?>

                                    <?php foreach ($item_cash as $key => $tem): ?>
                                        <?php
                                            if(isset($tem['nama_item'])){
                                                $warna = $this->GlobalModel->QueryManualRow("
                                                SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                                                "); 
                                            }    
                                        ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo !empty($warna) ? $warna['warna_item'] :null;?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <?php if( $parent['kategori']<4){ ?>

                                            <td width="125" align="center"><?php echo ($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo ($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo $tem['supplier']; ?></td>
                                            <?php } ?>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo $tem['komentar']?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <?php if( $parent['kategori']<4){ ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="3">Total Cash (Rp)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php //echo number_format($parent['cash'] + $parent['transfer']) ;?>
                                                 <?php echo ($parent['cash']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php if($parent['status']!=1){?>
                                            <td></td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                                <br><br>
<table border="1" style="width: 100%;border-collapse: collapse;">

                                    <thead>

                                    <tr>

                                        <th>NO.</th>

                                        <th>NAMA AJUAN</th>

                                        <th>WARNA</th>

                                        <th>JUMLAH</th>

                                        <th>SATUAN</th>
                                        
                                        <?php if( $parent['kategori']<4){ ?>
                                        <th width="125">HARGA SATUAN (Rp)</th>

                                        <th width="125">TOTAL (Rp)</th>

                                        <th>TIPE PEMBAYARAN</th>

                                        <th>NAMA SUPPLIER</th>
                                        <?php } ?>

                                        <th>KETERANGAN</th>
                                        <?php if($parent['status']!=1){?>
                                        <th width="200">REVISI SPV</th>
                                        <?php }?>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item_tf as $key => $tem): ?>
                                        <?php
                                            if(isset($tem['nama_item'])){
                                                $warna = $this->GlobalModel->QueryManualRow("
                                                SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                                                "); 
                                            }    
                                        ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo !empty($warna) ? $warna['warna_item'] :null;?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <?php if( $parent['kategori']<4){ ?>

                                            <td width="125" align="center"><?php echo ($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo ($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo $tem['supplier']; ?></td>
                                            <?php } ?>


                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo $tem['komentar']?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <?php if( $parent['kategori']<4){ ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="3">Total Transfer (Rp)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php //echo number_format($parent['cash'] + $parent['transfer']) ;?>
                                                 <?php echo ($parent['transfer']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php if($parent['status']!=1){?>
                                            <td></td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
<br>                       
<?php if( $parent['kategori']<4){ ?>                
                                <table border="2" style="width: 100%;border-collapse: collapse; text-align: center;">

                                    <tr>
                                        <td colspan="3"><center>Ajuan :</center> </td>
                                    </tr>
                                    <tr>

                                        <td>Cash (Rp)</td>
                                        <td>Transfer (Rp)</td>
                                        <td>Total (Rp)</td>
                                    </tr>

                                    <tr>

                                        <td><?php echo ($parent['cash']) ?></td>

                                        <td><?php echo ($parent['transfer']) ?></td>

                                        <td><?php echo ($parent['cash']+$parent['transfer']) ?></td>

                                    </tr>

                                </table>
<br><br>

<table border="2" style="width: 100%;border-collapse: collapse; text-align: center;">

                                    <tr>
                                        <td colspan="3"><center>Diterima :</center> </td>
                                    </tr>
                                    <tr>

                                        <td>Cash (Rp)</td>
                                        <td>Transfer (Rp)</td>
                                        <td>Total (Rp)</td>
                                        <td>Paraf Bu Haji</td>
                                    </tr>

                                    <tr>

                                        <td><?php echo ($parent['diterima_cash']) ?></td>

                                        <td><?php echo ($parent['diterima_tf']) ?></td>

                                        <td><?php echo ($parent['diterima_cash']+$parent['diterima_tf']) ?></td>

                                        <td>
                                            <br><br><br>
                                        </td>

                                    </tr>

                                </table>
<br><br>
                        <table border="2" style="width: 100%;border-collapse: collapse; text-align: center;">

                        <tr>
                            <td colspan="3"><center>Resume :</center> </td>
                        </tr>
                        <tr>

                            <td>Saldo Cash (Rp)</td>
                            <td>Keterangan</td>
                            <td>Paraf SPV</td>
                        </tr>

                        <tr>

                            <td><br><br><br><?php echo ($parent['diterima_cash']-$parent['cash']) ?></td>

                            <td>Sisa Ajuan</td>

                            <td></td>

                        </tr>

                        </table>      
<?php } ?>                        
<br><br>
                                    <table>
                                        <tr>
                                            <th colspan="7"></th>
                                            <th colspan="3"><center>Validasi Ajuan :</center> </th>
                                        </tr>
                                        <tr>
                                            <th colspan="7"></th>
                                            <th>Di Setujui oleh:</th>
                                            <th>Di Periksa oleh:</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                       

                                        <tr>
                                            <td colspan="7"></td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas )

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Mia )

                                            </td>
                                            <td height="100" align="center">
                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <?php 

                                                    if($parent['kategori']==4){
                                                        echo "(Vina)";
                                                    }else{
                                                        echo "(Ifah)";
                                                    }

                                                ?>

                                            </td>

                                        </tr>
                                        <tr align="center">
                                            <td colspan="7"></td>
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="10"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="10" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
                                    </table>