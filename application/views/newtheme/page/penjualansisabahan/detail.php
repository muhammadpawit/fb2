<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr>
                <th>Tanggal Penjualan</th>
                <td><?php echo date('d-m-Y', strtotime($master['tanggal'])) ?></td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><?php echo $master['keterangan'] ?></td>
            </tr>
            <tr>
                <th>Total Penjualan</th>
                <td>Rp <?php echo number_format($master['total_penjualan'], 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4>Detail Barang</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang / Item</th>
                    <th>Qty</th>
                    <th>Harga per Barang (Rp)</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($details as $d){ ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $d['nama_barang'] ?></td>
                    <td><?php echo $d['qty'] ?></td>
                    <td align="right"><?php echo number_format($d['harga'], 0, ',', '.') ?></td>
                    <td align="right"><?php echo number_format($d['total'], 0, ',', '.') ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Grand Total (Rp)</th>
                    <th class="text-right"><?php echo number_format($master['total_penjualan'], 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo $kembali ?>" class="btn btn-danger btn-sm">Kembali</a>
    </div>
</div>
