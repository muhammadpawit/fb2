<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_potongan.xls");
?>
            <table>
              <thead style="text-align: center;">
                <tr>
                  <th colspan="13">Monitoring Gambar dan Potongan Bahan (MGPB)</th>
                </tr>
                <tr>
                  <th colspan="13">PO Produksi Forboys</th>
                </tr>
              </thead>
            </table><br><br>
<label>Periode : <?php echo date('d F Y',strtotime($tanggal1)) ?> - <?php echo date('d F Y',strtotime($tanggal2))?></label>            
<table border="1" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Tim Potong</th>
                  <th>Nama PO</th>
                  <th>Roll Bahan</th>
                  <th>Panjang Gelaran</th>
                  <th>Pemakaian Bahan Kaos</th>
                  <th>Pemakaian Bahan Celana</th>
                  <th>Size</th>
                  <th>Jml PO (Dz)</th>
                  <th>Jml PO (Pcs)</th>
                  <th>Paraf Pimpinan</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo $p['timpotong']?></td>
                      <td><?php echo $p['kode_po']?></td>
                      <td align="center"><?php echo $p['roll_utama']?> Roll</td>
                      <td align="center"><?php echo $p['panjang_gelaran_potongan_utama']?><?php echo $p['panjang_gelaran_variasi']?></td>
                      <td align="center"><?php echo $p['pemakaian_bahan_utama']?></td>
                      <td align="center"><?php echo $p['jumlah_pemakaian_bahan_variasi']?></td>
                      <td align="center">'<?php echo $p['size_potongan']?></td>
                      <td><?php echo number_format($p['lusin'],2)?></td>
                      <td><?php echo $p['pcs']?></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php } ?>
                    <tr>
                      <td colspan="8" align="center"><b>Total</b></td>
                      <td></td>
                      <td><?php echo number_format($totaldz,2)?></td>
                      <td><?php echo $totalpcs?></td>
                      <td></td>
                      <td></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table><br><br>
            <table>
              <thead style="text-align: center;">
                <tr>
                  <th colspan="3">Yang Mengecek</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th colspan="3">Yang Membuat</th>
                </tr>
              </thead>
            </table>     