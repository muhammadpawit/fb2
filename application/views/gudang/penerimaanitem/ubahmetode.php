<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $results['id'] ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor SJ</label>
                            <input type="text" class="form-control" value="<?php echo $results['nosj'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Metode Pembayaran Saat Ini</label>
                            <input type="text" class="form-control" value="<?php echo $results['tipepembayaran'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ubah Metode Pembayaran Menjadi</label>
                            <select name="tipepembayaran" class="form-control select2bs4" required>
                                <option value="Cash" <?php echo ($results['tipepembayaran'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                                <option value="Transfer" <?php echo ($results['tipepembayaran'] == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
                                <option value="Tempo" <?php echo ($results['tipepembayaran'] == 'Tempo') ? 'selected' : ''; ?>>Tempo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info text-white">Simpan</button>
                            <a href="<?php echo BASEURL . 'Gudang/penerimaanitem'; ?>" class="btn btn-danger text-white">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
