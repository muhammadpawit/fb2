<?php
$namafile='Rekap_Pembayaran_CMT_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>        
        <h2 style="text-decoration: underline;">PEMBAYARAN CMT JAHIT FB</h2>
        <table border="1" style="width: 100%;border-collapse: collapse;">
            <thead>
                <tr>
                    <th rowspan="2"><center>No</center></th>
                    <th rowspan="2"><center>Nama CMT</center></th>
                    <th colspan="<?php echo count($periode) ?>"><center>Pembayaran</center></th>
                    <th rowspan="2"><center>Jumlah</center></th>
                </tr>
                <tr>
                    <?php foreach($periode as $p){ ?>
                    <th><center><?php echo $p['tanggal']?></center></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php $jumlah=0;?>
                <?php foreach($prods as $p){ ?>
                    <tr>
                        <td align="center"><?php echo $p['no']?></td>
                        <td><?php echo $p['nama']?></td>
                        <?php foreach($p['tgl'] as $t){ ?>
                            <td align="center"><?php echo ($t['total'])?></td>
                        <?php } ?>
                        <td align="center"><?php echo ($p['jumlah'])?></td>
                    </tr>
                    <?php $jumlah+=($p['jumlah']);?>
                <?php } ?>
                <tr>
                    <td align="center" colspan="2"><b>Total</b></td>
                    <?php foreach($total as $p){ ?>
                    <th><center><?php echo ($p['total'])?></center></th>
                    <?php } ?>
                    <th><center><?php echo ($jumlah)?></center></th>
                </tr>
            </tbody>
        </table>