<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pengajuan_harian.xls");
?>              
              <table border="1" style="width: 100%;border-collapse: collapse;">

                        <thead>

                        <tr style="background-color: lime">


                            <th>Tanggal</th>

                            <th>Divisi</th>

                            <th>Cash</th>

                            <th>Transfer</th>

                            <th>Total</th>
                            <th>Keterangan</th>

                            

                        </tr>

                        </thead>

                        <tbody>
                            <?php 
                                $cashtotal=0;
                                $tftotal=0;
                            ?>
                                <?php foreach ($harian as $key => $us): ?>
                                    <?php 
                                    $cashtotal+=($us['cash']);
                                    $tftotal+=($us['transfer']);
                                    $rincian=$this->GlobalModel->getData('pengajuan_harian_new_detail',array('idpengajuan'=>$us['id']));?>
                            <tr style="background-color: lightblue">


                                <td><?php echo date('d F Y',strtotime($us['tanggal'])) ?></td>

                                <td><?php if ($us['kategori'] == 1) {

                                   echo "Sablon";

                                } else if($us['kategori'] == 2) { echo "Bordir"; } else if($us['kategori'] == 3) {echo "Konveksi";}?></td>

                                <td><?php echo ($us['cash'])?></td>
                                <td><?php echo ($us['transfer'])?></td>
                                <td><?php echo ($us['cash']+$us['transfer'])?></td>
                                <td>

                                <?php 
                                    // if($us['status']==0){
                                    //     echo '<span class="badge bg-primary text-white">Diajukan</span>';
                                    // }else if($us['status']==1){
                                    //     echo '<span class="badge bg-success text-white">Disetujui</span>';
                                    // }else{
                                    //     echo '<span class="badge bg-danger text-white">Ditolak</span>';
                                    // }

                                ?>        

                                </td>

                                

                            </tr>
                            <?php foreach($rincian as $r){?>
                                <tr>
                                    <td colspan="2"><?php echo $r['nama_item']?></td>
                                    <td>
                                        <?php 
                                        if($r['pembayaran']==1){ 
                                            echo $r['harga'];
                                        }else{ echo 0;}
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($r['pembayaran']==2){ echo $r['harga'];}else{ echo 0;}?>
                                    </td>
                                    <td></td>
                                    <td><?php echo $r['keterangan']?></td>
                                </tr>
                            <?php } ?>

                                <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr style="background-color: yellow">
                                <td colspan="2"><b>Grand Total</b></td>
                                <td><?php echo $cashtotal?></td>
                                <td><?php echo $tftotal?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                            <td colspan="6"></td>
                               </tr>
                            <tr>
                                 <td colspan="6" align="right"><i>Registered by Forboys Production System</i></td>
                            </tr>
                        </tfoot>

                    </table>