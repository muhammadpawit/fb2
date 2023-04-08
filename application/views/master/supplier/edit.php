            <form method="post" action="<?php echo $action?>">
                <input type="hidden" name="id" value="<?php echo $products['id']?>">
                <div class="form-group">
                  <label>Nama Supplier</label>
                  <input type="text" name="nama" class="form-control" value="<?php echo $products['nama']?>">
                </div>
                <div class="form-group">
                  <label>PIC Supplier</label>
                  <input type="text" name="pic" class="form-control" value="<?php echo $products['pic']?>">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="alamat" class="form-control"><?php echo $products['alamat']?></textarea>
                </div>
                <div class="form-group">
                  <label>No.Telephone</label>
                  <input type="text" name="telephone" class="form-control" value="<?php echo $products['telephone']?>">
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="category" class="form-control select2bs4">
                    <option value=""></option>
                    <option value="1">Konveksi</option>
                    <option value="2">Bordir</option>
                    <option value="3">Sablon</option>
                    <option value="4">Bahan</option>
                  </select>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>