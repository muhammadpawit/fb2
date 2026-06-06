<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pencil mr-2"></i> Edit Gaji Sablon Borongan</h3>
            </div>
            <form action="<?php echo $action ?>" method="POST">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo $p['tanggal']?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pilih CMT</label>
                                <select name="idcmt" class="select2bs4 form-control" required>
                                    <option value="">Pilih CMT</option>
                                    <?php foreach($cmt as $k){ ?>
                                        <option value="<?php echo $k['id_cmt']?>" <?php echo $p['idcmt']==$k['id_cmt']?'selected':''?>><?php echo $k['cmt_name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Pilih Karyawan</label>
                                <select name="id_karyawan_harian" class="select2bs4 kar form-control" required>
                                    <option value="">Pilih Karyawan</option>
                                    <?php foreach($kar as $k){ ?>
                                        <option value="<?php echo $k['id']?>" <?php echo $p['namatim']==$k['id']?'selected':''?>><?php echo $k['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped" id="item_table3">
                                <thead>
                                    <tr class="bg-warning">
                                        <th width="30%">Kode PO</th>
                                        <th>Gambar</th>
                                        <th>Model</th>
                                        <th width="10%">Lusin</th>
                                        <th width="10%">Putaran</th>
                                        <th width="15%">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control selectpicker" name="kodepo" data-live-search="true" data-size="5" required>
                                                <?php foreach ($po as $key => $value): ?>
                                                <option value="<?php echo $value['id_produksi_po'] ?>" <?php echo $p['idpo']==$value['id_produksi_po']?'selected':''?>><?php echo $value['kode_po'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="gambar" value="<?php echo $p['gambar']?>" required ></td>
                                        <td><input type="text" class="form-control" name="model" value="<?php echo $p['model']?>"></td>
                                        <td><input type="number" step="any" name="lusin" class="form-control" value="<?php echo $p['dz']?>" required></td>
                                        <td><input type="number" step="any" class="form-control" name="putaran" value="<?php echo $p['putaran']?>"></td>
                                        <td><input type="number" step="any" class="form-control" name="harga" value="<?php echo $p['harga']?>" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" onclick="return confirm('Apakah data yang diedit sudah benar?')" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    <a href="<?php echo $cancel ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
