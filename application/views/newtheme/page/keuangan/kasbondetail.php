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
                  <th>Jumlah Kasbon</th>
                  <th>Jumlah Di ACC</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($detail as $d){?>
                  <tr>
                    <td><input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>"><?php echo $d['tanggal'];?></td>
                    <td><?php echo $d['nama'];?></td>
                    <td><?php echo $d['divisi'];?></td>
                    <td>Rp. <?php echo number_format($d['nominal']);?></td>
                    <td>Rp. <?php echo number_format($d['nominal_acc']);?></td>
                  </tr>
                  <?php $i++?>
                <?php } ?>
                <tr>
                  <td colspan="3" align="center"><label>Total</label></td>
                  <td>Rp.&nbsp;<?php echo number_format($ajuan)?></td>
                  <td>Rp.&nbsp;<?php echo number_format($total)?></td>
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
    <a href="<?php echo $pdf;?>" target="_blank" class="btn btn-primary text-white full">Print Nota Kasbon</a>
  </div>
  <div class="col-md-4">
    <a href="<?php echo $excel;?>" class="btn btn-success text-white full">Excel</a>
  </div>
</div>