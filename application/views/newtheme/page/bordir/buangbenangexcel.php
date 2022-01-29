<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_gaji_buang_benang_bordir_".time().".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h3>Resume Upah Buang Benang Forboys</h3>
<h5>Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date('d F Y ',strtotime($tanggal2)) ?></h5>

<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
  <tr>
      <td>No</td>
      <td>Nama</td>
      <td>Upah (Rp)</td>
      <td>Pembulatan (Rp)</td>
      <td>Keterangan</td>
    </tr>
  <?php $nm=1;$tb=0;$tp=0;?>
  <?php foreach($rekap as $pk){?>
    <tr>
      <td><?php echo $nm++?></td>
      <td><?php echo $pk['nama_karyawan_benang']?></td>
      <td><?php echo $pk['total']?></td>
      <td><?php echo $pk['totalpembulatan']?></td>
      <td></td>
    </tr>
    <?php
        $tb+=($pk['total']);
        $tp+=($pk['totalpembulatan']);
    ?>
  <?php } ?>
  <tr>
    <td colspan="2"><b>Total Upah Buang Benang</b></td>
    <td><b><?php echo $tb?></b></td>
    <td><b><?php echo $tp?></b></td>
  </tr>
</table>
<br>
<h3>Perincian Upah Pekerja Buang Benang</h3>
<br>
<?php $total=0;?>
<?php foreach($pekerja as $pk){?>
<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
<thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>PO</th>
                  <th>Posisi</th>
                  <th>Size</th>
                  <th>Qty (Pcs)</th>
                  <th>Harga (Rp)</th>
                  <th>Jumlah (Rp)</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach($pk['products'] as $p){?>
                    <tr>
                      <!-- <td><?php echo $p['no']?></td> -->
                      <td><?php echo date('d/m/Y',strtotime($p['created_date']))?></td>
                      <td><?php echo $pk['pekerja']?></td>
                      <td><?php echo $p['kode_po']?></td>
                      <td><?php echo $p['bagian_buang_benang']?></td>
                      <td><?php echo $p['size_buang_benang']?></td>
                      <td><?php echo $p['qty_buang_benang']?></td>
                      <td><?php echo $p['harga_buang_benan']?></td>
                      <td><?php echo ($p['qty_buang_benang']*$p['harga_buang_benan'])?></td>
                    </tr>
                  <?php $total+=(($p['qty_buang_benang']*$p['harga_buang_benan']))?>
                <?php }?>
                <tr>
                      <td colspan="8">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="7"><b>Total Diterima <?php echo $pk['pekerja']?> (Rp)</b></td>
                      <td><b><?php echo $pk['total']?></b></td>
                    </tr>
                    <tr>
                      <td colspan="8">&nbsp;</td>
                    </tr>
              </tbody>
            </table>
<?php } ?>            
<table>
        <tr>
          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>
            <b>Jakarta, <?php echo date('d F Y',strtotime($tanggal2))?></b>
          <table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Disetujui</th>
                                            <th>Mengetahui</th>
                                            <th>Disusun</th>
                                        </tr>

                                        <tr align="center">
                                            <td><b>SPV</b></td>
                                            <td><b>Mandor</b></td>
                                            <td><b>Adm Prod Bordir</b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas)

                                            </td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>                                            

                                            </td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>                                            
                                                ( Tiara )
                                            </td>
                                        </tr>

                                    </table>
          </td>
        </tr>
      </table>