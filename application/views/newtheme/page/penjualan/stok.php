<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <a onclick="stokpoonlineexcel()" class="btn btn-sm btn-success">Excel</a>
        </div>
    </div>
</div>
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
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Serian</th>
                    <th>Size QTY</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    function stokpoonlineexcel(){
        var url='?&excel=1';
        
        location =url;
    }
</script>