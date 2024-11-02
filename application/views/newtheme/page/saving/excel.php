<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Saving_".date('d F Y',strtotime($tanggal1)).' s.d '.date('d F Y',strtotime($tanggal2)).".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>
<h1>Laporan Saving Pembayaran Tim Potong</h1>
<table border="1" style="border-collapse: collapse;width: 100%;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Periode</th>
          <th>Jumlah (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($products as $p){?>
          <tr>
            <td><?php echo $p['no']?></td>
            <td><?php echo $p['nama']?></td>
            <td><?php echo $p['periode']?></td>
            <td><?php echo ($p['jumlah'])?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><b>Total</b></td>
          <td><?php echo ($total)?></td>
        </tr>
      </tfoot>
    </table><br><br>
                                <table border="1" style="border-collapse: collapse;width: 100%;">

                                        <tr>
                                            <th colspan="1"></th>
                                            <th>Menyetujui</th>
                                            <th>Di Periksa oleh:</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td colspan="1"></td>
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>
                                            <td colspan="1"></td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas )

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Mia )

                                            </td>
                                            <td height="100" align="center">
                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Ifah )

                                            </td>

                                        </tr>
                                    </table>    
    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s') ?></i>