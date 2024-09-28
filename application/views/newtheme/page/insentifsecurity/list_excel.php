<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=InsentifSecurity_".date('d F Y',strtotime($tanggal1)).' s.d '.date('d F Y',strtotime($tanggal2)).".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>
<h1>Laporan <?php echo $title ?></h1>
<table border="1" style="border-collapse: collapse;width: 100%;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Hari / Tanggal</th>
                          <th>Kedisiplinan</th>
                          <th>Kebersihan</th>
                          <th>Kontrol Video Call</th>
                          <th>Foto Per 2 Jam</th>
                          <th>Ketentuan</th>
                          <th>Potongan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;$total=0; ?>
                        <?php foreach($karyawan as $p){ ?>
                          <tr>
                            <td><?php echo $no?></td>
                            <td><?php echo $p['nama']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php $tp=0;?>
                            <?php foreach($p['products'] as $p){?>
                              <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo $p['tanggal']?></td>
                                <td><?php echo $p['kedisiplinan']?></td>
                                <td><?php echo $p['kebersihan']?></td>
                                <td><?php echo $p['kontrol_vc']?></td>
                                <td><?php echo $p['foto']?></td>
                                <td><?php echo $p['ketentuan']?></td>
                                <td><?php echo ($p['totalpotongan'])?></td>
                              </tr>
                              <?php 
                                $total+=($p['totalpotongan']);
                                $tp+=($p['totalpotongan']);
                              ?>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td colspan="8" align="right"><b>Total</b></td>
                            <td><?php echo number_format($tp) ?></td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="8"><b>Total</b></td>
                          <td><?php echo ($total) ?></td>
                        </tr>
                        <tr>
                          <td colspan="10" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
                        </tr>
                      </tfoot>
                   </table>