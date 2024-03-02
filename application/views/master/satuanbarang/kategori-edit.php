<div class="row">
    <div class="col-md-12">
        <div class="form-group">
                    <form action="<?php echo BASEURL.'masterdata/kategoribarangOnCreateEdit' ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
                        <div class="form-group">
                        	<label>Nama Kategori</label>
                        	<input type="text" class="form-control" value="<?php echo $prods['nama']?>" name="nama" required>
                        </div>

                        <div class="form-group">
                        	<label>Jumlah Pengiriman PO</label>
                        	<input type="number" class="form-control" value="<?php echo $prods['variabel_pengirimanpo']?>" name="variabel_pengirimanpo" required>
                        </div>

                        <div class="form-group">
                        	<label>Rata-rata Dz</label>
                        	<input type="number" class="form-control" value="<?php echo $prods['rata_rata_dz']?>" name="rata_rata_dz" required>
                        </div>

                        <div class="form-group">
                        	<label>Tampilkan Di warning Sistem Atas</label>
                        	<select name="spesial_warning" class="form-control select2bs4">
                                <option value="Tidak" <?php echo ($prods['spesial_warning']=='Tidak') ? 'selected' :'' ?>>Tidak</option>
                                <option value="Ya" <?php echo ($prods['spesial_warning']=='Ya') ? 'selected' :'' ?>>Ya</option>
                            </select>
                        </div>

                        <div class="form-group">
                        	<label>Tampilkan Di warning Sistem Bawah </label>
                        	<select name="in_warning" class="form-control select2bs4">
                                <option value="0" <?php echo $prods['in_warning']=='0' ? 'selected' :'' ?>>Tidak</option>
                                <option value="1" <?php echo $prods['in_warning']=='1' ? 'selected' :'' ?>>Ya</option>
                            </select>
                        </div>

                        
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                   </form>
        </div>
    </div>
</div>