<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <input type="hidden" name="idclaim" value="<?php echo $prods['id']?>">
    <input type="hidden" name="type" value="<?php echo $prods['type']?>">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Tanggal Potongan</label>
            <input type="text" value="<?php echo date('Y-m-d') ?>" name="tanggal" class="form-control datepicker" readonly>
        </div>
        <div class="form-group">
            <label for="">Nominal Potongan</label>
            <input type="text" name="nominal" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-xs full btn-success">Simpan</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <table class="table table-bordered yessearch">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Claim Awal</th>
                        <th>Nominal Potongan</th>
                    </tr>
                </thead>
                <tr>
                    <td><?php echo date('d F Y',strtotime($prods['tanggal'])) ?></td>
                    <td><?php echo number_format($prods['harga']) ?></td>
                    <td></td>
                </tr>
                <?php foreach($history as $h){ ?>
                <tr>
                    <td><?php echo date('d F Y',strtotime($h['tanggal'])) ?></td>
                    <td></td>
                    <td><?php echo number_format($h['nominal'])?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>