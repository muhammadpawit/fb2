<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_gaji_buang_benang_bordir_".time().".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }

  .besar {font-size: 18px;}
</style>
<table>
  <tr>
    <td colspan="5" align="center">
      <h3>Resume Upah Buang Benang Forboys</h3>
    </td>
  </tr>
</table>
<h5>Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date('d F Y ',strtotime($tanggal2)) ?></h5>

<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
  <tr style="background-color: pink">
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
  <tr style="background-color: yellow;font-weight: bold !important;">
    <td colspan="2"><b class="besar">Total Upah Buang Benang</b></td>
    <td><b class="besar"><?php echo $tb?></b></td>
    <td><b class="besar"><?php echo $tp?></b></td>
  </tr>
</table>
<b class="besar"r>
  <table>
        <tr>
          <td colspan="2" align="right"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td>
            <b class="besar">Jakarta, <?php echo date('d F Y',strtotime($tanggal2))?></b>
          <table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Disetujui</th>
                                            <th>Mengetahui</th>
                                            <th>Disusun</th>
                                        </tr>

                                        <tr align="center">
                                            <td><b class="besar">SPV</b></td>
                                            <td><b class="besar">Mandor</b></td>
                                            <td><b class="besar">Adm Prod Bordir</b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                ( Muchlas)

                                            </td>
                                            <td height="100" align="center">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>                                            

                                            </td>
                                            <td height="100" align="center">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>                                            
                                                ( Tria )
                                            </td>
                                        </tr>

                                    </table>
          </td>
        </tr>
      </table>
<h3>Perincian Upah Pekerja Buang Benang</h3>
<b class="besar"r>
<?php $total=0;?>
<?php foreach($pekerja as $pk){?>
<table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="5">
<thead>
                <tr style="background-color: yellow;">
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
                    <tr style="background-color: yellow;font-weight: bold;">
                      <td colspan="7"><b class="besar">Total Diterima <?php echo $pk['pekerja']?> (Rp)</b></td>
                      <td><b class="besar"><?php echo $pk['total']?></b></td>
                    </tr>
                    <tr>
                      <td colspan="8">
                        <b class="besar"r>
                        <table border="1" style="width: 100%;border-collapse: collapse;" cellpadding="4">
                          <thead>
                            <tr style="background-color: green;color:white">
                              <th colspan="4">PO Yang dibuang benang <?php echo $pk['pekerja']?></th>
                            </tr>
                            <tr>
                              <th>No</th>
                              <th>Nama PO</th>
                              <th>Bagian</th>
                              <th>Jumlah</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nor2=1;?>
                            <?php $tor2=0;?>
                            <?php foreach($pk['rek2'] as $rt){?>
                              <tr>
                                <td><?php echo $nor2++ ?></td>
                                <td><?php echo $rt['kode_po']?></td>
                                <td><?php echo $rt['bagian_buang_benang']?></td>
                                <td><?php echo $rt['total']?></td>
                              </tr>
                              <?php $tor2+=($rt['total']);?>
                            <?php } ?>
                            <tr style="background-color: green">
                              <td align="center" colspan="3"><b class="besar">Total</b></td>
                              <td><b class="besar"><?php echo $tor2;?></b></td>
                            </tr>
                          </tbody>
                        </table>
                        <b class="besar"r>
                      </td>
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
        </tr>
      </table>