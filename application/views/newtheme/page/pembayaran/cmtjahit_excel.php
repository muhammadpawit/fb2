<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Ongkos_Jahit_".$namacmt."_(".date('d F Y',strtotime($detail['tanggal'])).").xls");
?>
<h5>Ongkos Jahit <?php echo $namacmt?><br>
Periode : <?php echo date('d F Y',strtotime($detail['tanggal'])) ?>
</h5>
<table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Rincian PO</th>
                    <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah PO</th>
                    <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah Setor PO</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Harga/Dz (Rp)</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Total (Rp)</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Keterangan</th>
                </tr>
                <tr style="vertical-align : middle;text-align:center;">
                    <td>Dz</td>
                    <td>Pcs</td>
                    <td>Dz</td>
                    <td>Pcs</td>
                </tr>
            </thead>
            <tbody>
                <?php $n=1;$jmlpodz=0;$jmlpopcs=0;$jmldz=0;$jmlpcs=0;$total=0;?>
                <?php foreach($products as $p){?>
                    <?php
                        $jmlpodz+=($p['jumlah_po_dz']);
                        $jmlpopcs+=($p['jumlah_po_pcs']);
                        $jmldz+=($p['jumlah_dz']);
                        $jmlpcs+=($p['jumlah_pcs']);
                        //$total+=($p['jumlah_dz']*$p['harga']);
                        $total+=($p['total']-$p['potpertama']);
                    ?>
                    <tr>
                        <td><?php echo $n++?></td>
                        <td><?php echo strtoupper($p['kode_po'])?></td>
                        <td align="center"><?php echo $p['jumlah_po_dz']?></td>
                        <td align="center"><?php echo $p['jumlah_po_pcs']?></td>
                        <td align="center"><?php echo $p['jumlah_dz']?></td>
                        <td align="center"><?php echo $p['jumlah_pcs']?></td>
                        <td align="center"><?php echo ($p['harga'])?></td>
                        <td align="center"><?php echo ($p['total']-$p['potpertama'])?></td>
                        <td><?php echo strtolower($p['keterangan'])?></td>
                    </tr>
                <?php }?>
                    <?php for($j=0;$j<1;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="2" align="center"><b>Total</b></td>
                    <td align="center"><b><?php echo $jmlpodz?></b></td>
                    <td align="center"><b><?php echo $jmlpopcs?></b></td>
                    <td align="center"><b><?php echo $jmldz?></b></td>
                    <td align="center"><b><?php echo $jmlpcs?></b></td>
                    <td></td>
                    <td align="center"><b><?php echo ($total)?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Pengembalian Bangke</b></td>
                    <td align="center"><b><?php echo $detail['pengembalian_bangke']?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Potongan Bangke</b></td>
                    <td align="center"><b><?php echo $detail['potongan_bangke']?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Biaya Transport Antar & Penjemputan Po</td>
                    <td align="center"><b><?php echo ($detail['biaya_transport'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Potongan Pinjaman/Claim</td>
                    <td align="center"><b><?php echo ($detail['potongan_lainnya'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Total Yang diterima</b></td>
                    <td align="center"><b><?php echo ($detail['total']) ?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table>
            <tr>
                <td>
                    <table style="background-color: #ffba75;width: 100%;border:1px solid black" cellpadding="5">
                        <thead>
                            <tr>
                                <th valign="top">Ketentuan CMT :</th>
                                <th>
                                    <table border="1" style="border-collapse: collapse;" cellpadding="3">
                                        <tr align="center">
                                            <td>Jumlah Dz</td>
                                            <td>Harga (Rp)</td>
                                        </tr>
                                        <?php foreach(table('harga_transport') as $h){?>
                                            <tr>
                                                <td><?php echo $h['keterangan']?></td>
                                                <td align="right"><?php echo $h['harga']?></td>
                                            </tr>
                                        <?php } ?>

                                    </table>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td></td>
                <td>
                    <table style="background-color: white;width: 100%;border:1px solid black" cellpadding="5">
                        <tr>
                            <td align="center"><b>Potongan Klaim / Bangke</b></td>
                        </tr>
                        <tr>
                            <td>Potongan tidak ada bangke Rp.50.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Potongan bangke tidak komplit Rp.25.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Setelan (tidak ada bangke) Rp.40.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Setelan (tidak komplit) Rp.20.000/pcs</td>
                        </tr>
                        <tr>
                            <td>BS dimasukan packingan Rp.100.000/pcs</td>
                        </tr>
                    </table>
                </td>
                <td></td>
                <td>
                    <table style="width: 100%;border:1px solid black" cellpadding="5">
                       <thead>
                            <tr style="background-color: #adffc5;width: 100%;border:1px solid black">
                                <td colspan="5" align="center">Daftar Harga <?php echo $namacmt?></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Nama PO</th>
                                <th>Harga Lama/Dz</th>
                                <th>Harga Baru/Dz</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number=1;?>
                            <?php foreach(daftarharga_cmt($detail['idcmt']) as $r){?>
                                <tr>
                                    <td><?php echo $number++?></td>
                                    <td><?php echo $r['namapo']?></td>
                                    <td><?php echo ($r['hargalama'])?></td>
                                    <td><?php echo ($r['hargabaru'])?></td>
                                    <td><?php echo $r['keterangan']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br>

 <?php if(!empty($bangke)){?>
    <div class="col-md-6">
        <label>Potongan Bangke</label>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan/Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$bang=0;?>
                <?php foreach($bangke as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['kode_po'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo ($b['harga'])?></td>
                        <td><?php echo ($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $bang+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo ($bang)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <?php if(!empty($kembalianbangke)){?>
    <div class="col-md-6">
        <label>Pengembalian Bangke</label>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan/Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$kb=0;?>
                <?php foreach($kembalianbangke as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['kode_po'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo ($b['harga'])?></td>
                        <td><?php echo ($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $kb+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo ($kb)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>