<div class="row">
  <div class="col-md-12">
    <div class="form-group">
    </div>
  </div>
</div>
<div class="row table-responsive">
    <div class="col-md-12">
        <div class="form-group">
            <label>Penjualan Online Minggu Ini </label>
            <table style="border-collapse:collapse;width:100%" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PO</th>
                        <th>Serian</th>
                        <th>Size</th>
                        <th>Quantity (Pcs)</th>
                        <th>Harga (Rp)</th>
                        <th>Marketplace</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prods as $c){ ?>
                        <tr align="center">
                            <td><?php echo $c['no']?></td>
                            <td><?php echo $c['nama_po']?></td>
                            <td><?php echo $c['serian']?></td>
                            <td><?php echo $c['size']?></td>
                            <td><?php echo $c['quantity']?></td>
                            <td align="right"><?php echo number_format($c['harga'])?></td>
                            <td><?php echo $c['marketplace']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Penjualan Online Bulan Ini <?php echo date('F Y') ?> </label>
            <table style="border-collapse:collapse;width:100%" border="1">
                <thead>
                    <tr>
                        <th>Total Quantity</th>
                        <th>Total Penjualan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                        <td align="center"><?php echo $qty_bulan ?></td>
                        <td align="right"><?php echo number_format($total_bulan) ?></td>
                   </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Penjualan Online Bulan Kemarin <?php echo date('F Y',strtotime("-1 month")) ?> </label>
            <table style="border-collapse:collapse;width:100%" border="1">
                <thead>
                    <tr>
                        <th>Total Quantity</th>
                        <th>Total Penjualan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                        <td align="center"><?php echo $qty_bulan_lalu ?></td>
                        <td align="right"><?php echo number_format($total_bulan_lalu) ?></td>
                   </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>