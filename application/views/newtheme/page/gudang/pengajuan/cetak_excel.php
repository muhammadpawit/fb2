<?php
//if(akseshapus()==1){

//}else{
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=pengajuan_harian.xls");    
//}

?>
<table>
    <tr align="center">
        <td colspan="10">
            <h4 class="m-0">FORM PENGAJUAN HARIAN <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";}?> FORBOYS</h4>
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

                                            <th>DAFTAR ITEM AJUAN OPS</th>

                                            <th>JUMLAH <br>BARANG</th>

                                            <th>SATUAN</th>

                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">TOTAL (Rp)</th>

                                            <th>PEMBAYARAN</th>

                                            <th>SUPPLIER</th>

                                            <th>KET.</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">KOMENTAR</th>
                                            <?php } ?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item as $key => $tem): ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <td width="125"><?php echo ($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo ($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo $tem['supplier']; ?></td>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><?php echo $tem['komentar']?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="2">Total (Rp)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php echo ($parent['cash'] + $parent['transfer']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php if($parent['status']!=1){?>
                                            <td></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="9"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="9" align="right"><b>Registered by Forboys Production System</b></td>
                                        </tr>
                                    </tfoot>
                                </table>   
<br>                                       
<table border="2" style="width: 100%;border-collapse: collapse; text-align: center;">

                                    <tr>

                                        <td>CASH (Rp)</td>

                                        <td><?php echo ($parent['cash']) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER (Rp)</td>

                                        <td><?php echo ($parent['transfer']) ?></td>

                                    </tr>

                                </table>
<br><br>
                                    <table>

                                        <tr>
                                            <th colspan="7"></th>
                                            <th>Menyetujui</th>
                                            <th>Di Periksa oleh:</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td colspan="7"></td>
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="7"></td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas Muchtar)

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Dinda )

                                            </td>
                                            <td height="100" align="center">
                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( <?php echo strtoupper($adminkeu)?> )

                                            </td>

                                        </tr>

                                        <tr>
                                    </table>