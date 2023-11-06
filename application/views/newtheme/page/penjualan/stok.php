<div class="row">
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