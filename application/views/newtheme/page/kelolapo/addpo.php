<form action="<?php echo $action ?>" method="post">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
                            <label>Kode PO</label>
                            <input type="text" class="form-control kodePO" name="kodePO" value="" required>
                        </div>
                        <div class="form-group">
                          <label>Nama PO</label>
                            <select class="form-control selectpicker select2bs4" name="namaPO" data-title="Pilih Jenis PO" data-live-search="true">
                            <?php foreach ($JenisPo as $key => $jenis): ?>
                                <option value="<?php echo $jenis['nama_jenis_po'] ?>"><?php echo $jenis['nama_jenis_po'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis PO</label>
                            <select class="form-control selectpicker select2bs4" name="jenisPo" data-live-search="true" data-size="4" data-title="Pilih Jenis" required>
                                <?php foreach ($jenisKaos as $key => $jen): ?>
                                <option value="<?php echo $jen['nama_jenis_kaos'] ?>"><?php echo $jen['nama_jenis_kaos'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Tanggal Produksi</label>
                            <input type="text" class="form-control datepicker" name="tanggalProd" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Po</label>
                            <select class="form-control select2bs4 kategoriPo" name="kategoriPo" title="select jenis po" required >
                                <option value="DALAM">DALAM</option>
                                <option value="LUAR">LUAR</option>
                            </select>
                        </div>
                        <div class="form-group pemilikPO hide">
                            <label>Pemilik PO</label>
                            <input type="text" class="form-control pemilikPO" name="pemilikPO" value="-" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Artikel</label>
                            <input type="text" class="form-control artikel" name="artikel" value="" required >
                        </div>
                        <!--
                        <div class="form-group">
                            <label>Progress</label>
                            <select class="form-control" name="progress">
                                <?php foreach ($progress as $key => $prog): ?>
                                <option value="<?php echo $prog['id_proggresion_po'] ?>"><?php echo $prog['nama_progress'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>-->
                        <a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Batal</a>
                        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
    </div>
</div>
</form>