<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="text" name="tanggal1" value="<?php echo $tanggal1;?>" class="datepicker form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="text" name="tanggal2" value="<?php echo $tanggal2;?>" class="datepicker form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button onclick="filtertglonly()" class="btn btn-sm btn-primary">Filter</button>
            <a href="<?php echo $tambah ?>" class="btn btn-sm btn-primary">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered table-hover yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Mandor</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p){ ?>
                        <tr>
                            <td><?php echo $p['no']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['mandor']?></td>
                            <td><?php echo $p['shift']?></td>
                            <td><?php echo $p['status']?></td>
                            <td>
                                <a href="<?php echo $p['detail']?>" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>