<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <a onclick="stokpoonlineexcel()" class="btn btn-sm btn-success">Excel</a>
        </div>
    </div>
</div>

<div class="row" hidden>
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama PO</th>
                        <th>Serian</th>
                        <th>Size</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($products as $p){?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $p['kode_po']?></td>
                            <td><?php echo $p['serian']?></td>
                            <td><?php echo $p['id_size']?></td>
                            <td><?php echo $p['pcs']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row  table-responsive">
    <div class="col-md-12">
    
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
                    <tr>
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
                        <td align="center" style="background-color: <?php echo ($stok == 0 ) ? '#d6facd' : ($stok > 1 ? '' : '#ff9373');?>"><?php echo $stok ?></td>
                        <?php } ?>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>

              
        <table class="" border="1" style="border-collapse: collapse;width: 100%;" hidden>
            <thead>
                <tr>
                    <th rowspan="1">No</th>
                    <th rowspan="2">Nama PO</th>
                    <th rowspan="2">Serian</th>
                    <th rowspan="2" colspan="6">Size QTY</th>
                    <th rowspan="2">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                <?php //foreach($products as $p){ ?>
                    <!-- <tr>
                        <td rowspan="4"><?php //echo $no++ ?></td>
                        <td rowspan="4"><?php //echo $p['kode_po']?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                <?php //} ?>
                <tr>
                    <td rowspan="3">1</td>
                    <td rowspan="3">abcd</td>
                    <td>sat</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>du</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>tig</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="table-responsive">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered yessearch">
                <thead>
                    <tr>
                        <th>Nama PO</th>
                        <th>Size</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rekap as $r){ ?>
                        <tr>
                            <td><?php echo $r['kode_po']?></td>
                            <td><?php echo $r['id_size']?></td>
                            <td><?php echo $r['stok']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<script>
    function stokpoonlineexcel(){
        var url='?&excel=1';
        
        location =url;
    }
</script>