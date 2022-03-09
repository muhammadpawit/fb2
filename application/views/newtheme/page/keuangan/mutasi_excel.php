<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=mutasi_kas_operasional.xls");
?>              
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>
              <table border="1" style="width: 100%;border-collapse: collapse;">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="100">Tanggal</th>
                  <th>Divisi</th>
                  <th>Keterangan</th>
                  <th>Saldomasuk</th>
                  <th>Saldokeluar</th>
                  <th>Sisa</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1?>
                <?php foreach($mutasi as $m){?>
                  <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo date('d-m-Y',strtotime($m['tanggal'])) ?></td>
                    <td>
                      <?php 
                        if($m['bagian']==1){
                          echo "Konveksi";
                        }else if($m['bagian']==2){
                          echo "Bordir";
                        }else if($m['bagian']==3){
                          echo "Sablon";
                        }else{
                          echo "Default";
                        }
                      ?>
                    </td>
                    <td><?php echo $m['keterangan']?></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo ($m['saldomasuk'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo ($m['saldokeluar'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo ($m['saldo'])?></p></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
<i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s') ?></i>            