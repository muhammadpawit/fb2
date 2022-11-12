 <?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Ongkos_Jahit_Periode_".date('d F Y',strtotime($tanggal2)).".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table style="width: 100%;">
    <tr>
        <td align="center" style="text-align: center;" colspan="9"><h2>Rekap Laporan Transfer CMT</h2></td>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="text-align: left;" colspan="9">Periode <?php echo date('d F Y',strtotime($tanggal2)) ?></td>
    </tr>
</table>
<table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama CMT</th>
                    <th>Atas Nama</th>
                    <th>Nomor Rekening</th>
                    <th>Bank</th>
                    <th>Jumlah Kirim Kaos/ Kemeja (Pcs)</th>                    
                    <th>Jumlah Setor Kaos/Kemeja (Pcs)</th>
                    <th>Jumlah Transferan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $totals=0;$jmlkirim=0;$jmlsetor=0;?>
                <?php if(!empty($products)){?>
                    <?php foreach($products as $p){?>
                        <tr>
                            <td><?php echo $p['no']?></td>
                            <td><?php echo strtoupper($p['nama'])?></td>
                            <td><?php echo strtoupper($p['an'])?></td>
                            <td><?php echo strtoupper($p['norek'])?></td>
                            <td><?php echo strtoupper($p['bank'])?></td>
                            <td><?php echo ($p['jmlkirim'])?></td>
                            <td><?php echo ($p['jmlsetor'])?></td>
                            <td align="right"><?php echo $p['totals']?>&nbsp;</td>
                            <td></td>
                        </tr>
                        <?php $totals+=($p['totals'])?>
                        <?php $jmlkirim+=($p['jmlkirim'])?>
                        <?php $jmlsetor+=($p['jmlsetor'])?>
                    <?php } ?>
                        <tr>
                            <td colspan="4"><b>Total</b></td>
                            <td></td>
                            <td><b><?php echo $jmlkirim?></b></td>
                            <td><b><?php echo $jmlsetor?></b></td>
                            <td align="right"><b><?php echo $totals?>&nbsp;</b></td>
                            <td></td>
                        </tr>
                        <?php if(isset($gajiskb)){ ?>
                            <tr>
                                <td colspan="4"><b>Transferan Anak Harian</b></td>
                                <td></td>
                                <td><b></b></td>
                                <td><b></b></td>
                                <td align="right"><b><?php echo $gajiskb['total']?>&nbsp;</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Transferan Borongan (Permak)</b></td>
                                <td></td>
                                <td><b></b></td>
                                <td><b></b></td>
                                <td align="right"><b><?php echo $vermak?>&nbsp;</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Transferan Ops Cab. Sukabumi</b></td>
                                <td></td>
                                <td><b></b></td>
                                <td><b></b></td>
                                <td align="right"><b><?php echo $opsskb['total']?>&nbsp;</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Total Transferan Cab. Sukabumi</b></td>
                                <td></td>
                                <td><b></b></td>
                                <td><b></b></td>
                                <td align="right"><b><?php echo ($totals+$gajiskb['total']+$opsskb['total'])?>&nbsp;</b></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                <?php }else{ ?>
                <tr>
                    <td colspan="8">Data tidak ditemukan</td>
                </tr>
                <?php }?>
            </tbody>
        </table>
<br>
<table style="width: 100%;border-collapse: collapse;" border="0">
    <tr>
        <td style="text-align: left;width: 60%" colspan="6"></td>
        <td style="text-align: center;width: 40%">
            <table style="width: 100%;border-collapse: collapse;" border="1">
                <tr>
                    <td style="text-align: center;width: 50%">SPV</td>
                    <td style="text-align: center;width: 50%" colspan="2">Admin Keu</td>
                </tr>
                <tr>
                    <td style="text-align: center;width: 50%;height: 120px" valign="bottom">Muchlas</td>
                    <td style="text-align: center;width: 50%;height: 120px" valign="bottom" colspan="2">Dinda Dahlia</td>
                </tr>
            </table>        
        </td>
    </tr>
</table> 
    <table style="width: 100%;">
        <tr>
            <td colspan="9" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
        </tr>
    </table>       