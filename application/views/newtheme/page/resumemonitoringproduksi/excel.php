<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Resume_monitoring_".date('d F Y',strtotime($tanggal1)).' s.d '.date('d F Y',strtotime($tanggal2)).".xls");
?>
<style>
    .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown .dropdown-toggle {
    color: #333;
    text-decoration: none;
    /* padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px; */
    display: block;
}

.dropdown .dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 4px;
}

.dropdown .dropdown-menu a {
    color: #333;
    padding: 10px;
    text-decoration: none;
    display: block;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown:hover .dropdown-menu a:hover {
    background-color: #e9bceb;
}

</style>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="text-center">
                <h4 style="text-decoration: underline;">Resume Monitoring Produksi</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="badge bg-green">Updated <?php echo date('d/m/Y', strtotime($tanggal2)) ?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group table-responsive">
            <table style="border-collapse: collapse;width:100%" border="1">
                <thead style="font-weight:bold; text-align:center">
                    <tr>
                        <td rowspan="2">No</td>
                        <td rowspan="2">Jenis PO</td>
                        <td colspan="3">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle">Potongan</a>
                            <div class="dropdown-menu">
                                <!-- <a href="<?php echo BASEURL.'Resumemonitoringproduksi'?>/potongan_harian">Potongan Harian</a> -->
                                <a href="<?php echo BASEURL.'report/potongan?'.'?&tanggal1='.date('Y-m-d',strtotime("-7 days")).'&tanggal2='.date('Y-m-d')?>">Potongan Harian</a>
                                <!-- /report/potongan -->
                                <!-- <a href="<?php echo BASEURL.'Resumemonitoringproduksi'?>/potongan_mingguan">Potongan Mingguan</a> -->
                                <a href="<?php echo BASEURL.'report/potongan?'.'?&tanggal1='.date('Y-m-d',strtotime("-14 days")).'&tanggal2='.date('Y-m-d')?>">Potongan Mingguan</a>
                                <a href="<?php echo BASEURL.'Grafikpotongan'?>" target="_blank">Potongan Bulanan</a>
                            </div>
                        </div>

                        </td>
                        <td colspan="3">Kirim CMT</td>
                        <td colspan="3">Setor CMT</td>
                        <td colspan="3">Kirim Gudang</td>
                        <td colspan="3">PO Beredar</td>
                    </tr>
                    <tr>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total1=0;
                        $total2=0;
                        $total3=0;
                        $total4=0;
                        $total5=0;
                        $total6=0;
                        $total7=0;
                        $total8=0;
                        $total9=0;
                        $total10=0;
                        $total11=0;
                        $total12=0;
                        $total13=0;
                        $total14=0;
                        $total15=0;
                    ?>
                    <?php foreach($prods as $p){ ?>
                        <tr>
                            <td align="center"><?php echo $p['no']?></td>
                            <td><?php echo $p['type']?></td>
                            <td><?php echo ($p['jml_potongan'])?></td>
                            <td><?php echo ($p['pcs_potongan']/12)?></td>
                            <td><?php echo ($p['pcs_potongan'])?></td>
                            <td><?php echo ($p['jml_kirim'])?></td>
                            <td><?php echo ($p['pcs_kirim']/12)?></td>
                            <td><?php echo ($p['pcs_kirim'])?></td>
                            <td><?php echo ($p['jml_setor'])?></td>
                            <td><?php echo ($p['pcs_setor']/12)?></td>
                            <td><?php echo ($p['pcs_setor'])?></td>
                            <td><?php echo ($p['jml_kirim_gudang'])?></td>
                            <td><?php echo ($p['pcs_kirim_gudang']/12)?></td>
                            <td><?php echo ($p['pcs_kirim_gudang'])?></td>
                            <td><?php echo ($p['jml_potongan']-$p['jml_kirim_gudang'])?></td>
                            <td><?php echo (($p['pcs_potongan']/12) - ($p['pcs_kirim_gudang']/12))?></td>
                            <td><?php echo ($p['pcs_potongan']-$p['pcs_kirim_gudang'])?></td>
                        </tr>
                        <?php
                            $total1+=($p['jml_potongan']);
                            $total2+=($p['pcs_potongan']/12);
                            $total3+=($p['pcs_potongan']);
                            $total4+=($p['jml_kirim']);
                            $total5+=($p['pcs_kirim']/12);
                            $total6+=($p['pcs_kirim']);
                            $total7+=($p['jml_setor']);
                            $total8+=($p['pcs_setor']/12);
                            $total9+=($p['pcs_setor']);
                            $total10+=($p['jml_kirim_gudang']);
                            $total11+=($p['pcs_kirim_gudang']/12);
                            $total12+=($p['pcs_kirim_gudang']);
                            $total13+=($p['jml_potongan']-$p['jml_kirim_gudang']);
                            $total14+=(($p['pcs_potongan']/12) - ($p['pcs_kirim_gudang']/12));
                            $total15+=($p['pcs_potongan']-$p['pcs_kirim_gudang']);
                        ?>
                    <?php } ?>
                        <tr style="background-color: #e9bceb;">
                            <td colspan="2"><b>Total</b></td>
                            <td><b><?php echo ($total1)?></b></td>
                            <td><b><?php echo ($total2)?></b></td>
                            <td><b><?php echo ($total3)?></b></td>
                            <td><b><?php echo ($total4)?></b></td>
                            <td><b><?php echo ($total5)?></b></td>
                            <td><b><?php echo ($total6)?></b></td>
                            <td><b><?php echo ($total7)?></b></td>
                            <td><b><?php echo ($total8)?></b></td>
                            <td><b><?php echo ($total9)?></b></td>
                            <td><b><?php echo ($total10)?></b></td>
                            <td><b><?php echo ($total11)?></b></td>
                            <td><b><?php echo ($total12)?></b></td>
                            <td><b><?php echo ($total13)?></b></td>
                            <td><b><?php echo ($total14)?></b></td>
                            <td><b><?php echo ($total15)?></b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>