<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1 ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2 ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Aksi</label><br>
            <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
            <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm text-white">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-margin" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Total Penjualan (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($results as $r) { ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo date('d-m-Y', strtotime($r['tanggal'])) ?></td>
                            <td><?php echo $r['keterangan'] ?></td>
                            <td align="right"><?php echo number_format($r['total_penjualan'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?php echo BASEURL . 'Penjualansisabahan/detail/' . $r['id'] ?>" class="btn btn-info btn-xs">Detail</a>
                                <a href="<?php echo BASEURL . 'Penjualansisabahan/edit/' . $r['id'] ?>" class="btn btn-warning btn-xs">Edit</a>
                                <a href="<?php echo BASEURL . 'Penjualansisabahan/hapus/' . $r['id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>