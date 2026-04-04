<table class="table table-bordered">
    <thead>
        <tr>
            <th>SIZE</th>
            <th>DZ(Lusin)</th>
            <th>PIECES</th>
            <th>BANGKE</th>
            <th>REJECT</th>
            <th>HILANG</th>
            <th>CLAIM</th>
            <th>KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['rincian_size'] ?></td>
                    <td><?php echo $item['rincian_lusin'] ?></td>
                    <td><?php echo $item['rincian_piece'] ?></td>
                    <td><?php echo $item['rincian_bangke'] ?></td>
                    <td><?php echo $item['rincian_reject'] ?></td>
                    <td><?php echo $item['rincian_hilang'] ?></td>
                    <td><?php echo $item['rincian_claim'] ?></td>
                    <td><?php echo $item['rincian_keterangan'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Data tidak ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
