<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Stok_PO_Online_".time().".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table border="1" style="border-collapse: collapse;width: 100%;">
                <tr>
                    <th>Nama PO</th>
                    <th>Size</th>
                    <th>Stok</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach($rekap as $r){ ?>
                    <tr>
                        <td><?php echo $r['kode_po']?></td>
                        <td><?php echo $r['id_size']?></td>
                        <td><?php echo $r['stok']?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div> -->
<br><br>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table border="1" style="border-collapse: collapse;width: 100%;">
                <thead style="background-color: #e8e6e6;">
                    <tr>
                        <th rowspan="2"><center>No</center></th>
                        <th rowspan="2"><center>Nama PO</center></th>
                        <th rowspan="2"><center>Serian</center></th>
                        <th colspan="<?php echo $rangesize+1 ?>"><center>Size</center> </th>
                        <th rowspan="2"><center>Jumlah</center></th>
                        <th rowspan="2"><center>Ket</center></th>
                    </tr>
                    <tr style="text-align: center !important;">
                    <?php for($rs=0;$rs<=$rangesize;$rs++){ ?>
                        <th><center><?php echo GetName('size_po_online',$rs) ?></center></th>
                    <?php } ?>
                        <!-- <th><center>2</center></th>
                        <th><center>3</center></th>
                        <th><center>4</center></th>
                        <th><center>5</center></th>
                        <th><center>6</center></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $pcs=null;?>
                    <?php foreach($products as $p){ ?>
                        <tr style="background-color: #d6facd;">
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $p['kode_po']?></td>
                            <?php 
                                for($i=1;$i<=14;$i++){
                                    echo "<td></td>"; 
                                }        
                            ?>
                            <td align="center"><?php echo $p['total']?></td>
                            <td></td>
                        </tr>
                        <?php foreach($p['detail'] as $d){ ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td align="center"><?php echo $d['serian']?></td>
                            <?php for($s=0;$s<=$rangesize;$s++){ ?>
                            <?php $stok=$this->OnlineModel->getPcs($p['id'],$d['idserian'],$s); ?>
                            <td align="center" style="background-color: <?php echo ($stok == 0 ) ? '#ff9373':''; ?> ;"><?php echo $stok ?></td>
                            <?php } ?>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>