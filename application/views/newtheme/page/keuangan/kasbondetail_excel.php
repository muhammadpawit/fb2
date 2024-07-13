<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kabon_Karyawan_".time().".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h2>Kabon Karyawan Forboys Production</h2>            
            <table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="3">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jumlah Kasbon (Rp)</th>
                  <th>Jumlah Di ACC (Rp)</th>
                  <th>Keterangan</th>
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
                    <td align="right">&nbsp;<?php echo ($d['keterangan']);?></td>
                  </tr>
                  <?php $i++?>
                <?php } ?>
                <tr>
                  <td colspan="3" align="center"><label>Total</label></td>
                  <td align="right">&nbsp;<?php echo $ajuan?></td>
                  <td align="right">&nbsp;<?php echo $total?></td>
                  <td></td>
                </tr>
                <tr>
            <td colspan="5"></td>
            </tr>
            <tr>
              <td colspan="5" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
            </tr>
              </tbody>
            </table>