<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kabon_Karyawan_".time().".xls");
?>

            <table style="width: 100%;" cellpadding="3">
              <tr>
                <td colspan="5" align="center"><h2>Kabon Karyawan Forboys Production</h2></td>
              </tr>
            </table>
            <label>
              <?php if(!empty($acc['tanggal'])){?>
                <?php echo hari(date('l',strtotime($acc['tanggal'])))?>,&nbsp;<?php echo date('d F Y',strtotime($acc['tanggal']))?>
              <?php }else{ ?>
                  <label class="alert alert-danger">Kasbon belum di acc</label>
              <?php } ?>
            </label>
            <table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="3">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jumlah Kasbon (Rp)</th>
                  <th>Jumlah Di ACC (Rp)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($detail as $d){?>
                  <tr>
                    <td><input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>"><?php echo $d['tanggal'];?></td>
                    <td><?php echo $d['nama'];?></td>
                    <td><?php echo $d['divisi'];?></td>
                    <td align="right">&nbsp;<?php echo ($d['nominal']);?></td>
                    <td align="right">&nbsp;<?php echo ($d['nominal_acc']);?></td>
                  </tr>
                  <?php $i++?>
                <?php } ?>
                <tr>
                  <td colspan="3" align="center"><label>Total</label></td>
                  <td align="right">&nbsp;<?php echo $ajuan?></td>
                  <td align="right">&nbsp;<?php echo $total?></td>
                </tr>
              </tbody>
            </table>