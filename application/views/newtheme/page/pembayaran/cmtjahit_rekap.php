        <?php
        $namafile=$title.'_'.time();
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$namafile.".xls");
        ?>
        <table>
            <tr align="center">
                    <td colspan="13" align="center"><h3>RINCIAN SETORAN DAN TAGIHAN CMT</h3></td>
                </tr>
        </table>
        <table border="1" style="width: 100%;border-collapse: collapse;">
            <thead>
                
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama CMT</th>
                    <th>PO</th>
                    <th>Jumlah (Pc)</th>
                    <th>Setoran (Pc)</th>
                    <th>Tagihan</th>
                    <th>Potongan Alat2</th>
                    <th>Potongan Mesin</th>
                    <th>Potongan Bangke</th>
                    <th>Potongan Permak</th>
                    <th>Total Transfer</th>
                    <th>Kondisi PO</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)){?>
                    <?php foreach($products as $p){?>
                        <?php $total+=($p['total']);?>
                        <tr align="center">
                            <td><?php echo $p['no']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo strtoupper($p['nama'])?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $p['potongan_alat']?></td>
                            <td><?php echo $p['potongan_mesin']?></td>
                            <td><?php echo $p['potongan_bangke']?></td>
                            <td><?php echo $p['potongan_vermak']?></td>
                            <td align="center"><?php echo $p['total']?></td>
                            <td></td>
                        </tr>
                        <?php foreach($p['det'] as $d){?>
                            <?php 
                            $kirim=$this->GlobalModel->QueryManualRow("SELECT kcd.jumlah_pcs FROM kirimcmt_detail kcd JOIN kirimcmt k ON(k.id=kcd.idkirim) WHERE kcd.kode_po='".$d['kode_po']."' AND k.idcmt='".$p['idcmt']."' ");
                            $setoran+=($d['jumlah_pcs']);
                            ?>
                            <tr align="center">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo $d['kode_po']?></td>
                                <td><?php echo !empty($d['kirimpcs'])?($d['kirimpcs']):($kirim['jumlah_pcs']) ?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo ($d['total']-$d['potpertama'])?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                                <td><?php echo str_replace("Pembayaran", "", $d['keterangan']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr style="background-color: yellow">
                        <td></td>
                        <td colspan="2" align="center"><b>Total</b></td>
                        <td></td>
                        <td></td>
                        <td align="center"><b><?php echo $setoran?></b></td>
                        <td colspan="5"></td>
                        <td align="center"><b><?php echo $total ?></b></td>
                        <td></td>
                    </tr>
                <?php }else{ ?>
                <tr>
                    <td colspan="8">Data tidak ditemukan</td>
                </tr>
                <?php }?>
            </tbody>
        </table>