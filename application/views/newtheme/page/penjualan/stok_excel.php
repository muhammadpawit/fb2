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
<div class="row">
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
</div>
<br><br>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table border="1" style="border-collapse: collapse;width: 100%;">
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