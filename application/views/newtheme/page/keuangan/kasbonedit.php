<form method="POST" action="<?php echo $action ?>">
    <div class="row">
  <div class="col-md-12">
<!--               <?php if(!empty($acc['tanggal'])){?>
                <?php echo hari(date('l',strtotime($acc['tanggal'])))?>,&nbsp;<?php echo date('d F Y',strtotime($acc['tanggal']))?>
              <?php }else{ ?>
                  <label class="alert alert-danger">Kasbon belum di acc</label>
              <?php } ?> -->
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jenis</th>
                  <th>Jumlah Kasbon</th>
                  <th>Jumlah Di ACC</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <form method="POST" action="<?php echo $action ?>">
                  <?php foreach($detail as $d){?>
                    <tr>
                      <td><input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>"><?php echo !empty($d['tanggal']) ? formatTanggalIndo($d['tanggal']) : ''?></td>
                      <td><?php echo $d['nama'];?></td>
                      <td><?php echo $d['divisi'];?></td>
                      <td>
                        <select name="products[<?php echo $i?>][jenis_pembayaran]" class="form-control">
                          <option value="Transfer" <?php echo (strtolower($d['jenis_pembayaran']) == 'transfer' ? 'selected' : ''); ?>>Transfer</option>
                          <option value="Cash" <?php echo (strtolower($d['jenis_pembayaran']) == 'cash' ? 'selected' : ''); ?>>Cash</option>
                        </select>
                      </td>
                      <td>Rp. 
                        <input type="number" name="products[<?php echo $i?>][nominal]" value="<?php echo ($d['nominal']);?>" class="form-control">
                        <input type="hidden" name="products[<?php echo $i?>][karyawan]" value="<?php echo ($d['nama']);?>" class="form-control">
                        <input type="hidden" name="products[<?php echo $i?>][nominal_old]" value="<?php echo ($d['nominal']);?>" class="form-control">
                    </td>
                      <td>Rp. <?php echo number_format($d['nominal_acc']);?></td>
                      <td><?php echo $d['keterangan'];?></td>
                    </tr>
                    <?php $i++?>
                  <?php } ?>
                </form>
                <tr>
                  <td colspan="4" align="center"><label>Total</label></td>
                  <td>Rp.&nbsp;<?php echo number_format($ajuan)?></td>
                  <td>Rp.&nbsp;<?php echo number_format($total)?></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <a href="<?php echo $kembali;?>" class="btn btn-danger text-white full">Kembali</a>
  </div>
  <div class="col-md-4">
    <button type="submit" class="btn btn-success text-white full" onclick="return confirm('Apakah data yang diinput sudah benar?')">Simpan</button>
  </div>
  <div class="col-md-4">

  </div>
</div>
</form>