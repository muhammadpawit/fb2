<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Laporan Laba Rugi</h3>
      </div>
      <div class="card-body">
        <form method="get" action="<?php echo BASEURL.'Pelaporankeuangan/laba_rugi' ?>">
        <div class="row">
          <div class="col-md-3">
            <input type="date" name="tgl1" class="form-control" value="<?php echo $tgl1 ?>">
          </div>
          <div class="col-md-3">
            <input type="date" name="tgl2" class="form-control" value="<?php echo $tgl2 ?>">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-info">Filter</button>
          </div>
        </div>
        </form>
        <hr>
        <div class="row justify-content-center">
          <div class="col-md-10">
            <h4 class="text-center">Laporan Laba Rugi</h4>
            <p class="text-center"><?php echo date('d M Y', strtotime($tgl1)) ?> - <?php echo date('d M Y', strtotime($tgl2)) ?></p>
            <br>
            <table class="table table-borderless">
              <tr style="background-color: #f4f4f4; font-weight: bold;">
                <th colspan="2">PENDAPATAN</th>
              </tr>
              <?php 
                $total_pendapatan = 0;
                foreach($pendapatan as $p): 
                  $total_pendapatan += $p['total'];
              ?>
              <tr>
                <td><?php echo $p['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$p['total'], 0, ',', '.') ?></td>
              </tr>
              <?php endforeach; ?>
              
              <!-- Pendapatan Kirim Gudang H. Sholeh -->
              <tr>
                <td>Kirim Gudang (H. Sholeh)</td>
                <td align="right"><?php echo number_format($pendapatan_haji_sholeh, 0, ',', '.') ?></td>
              </tr>
              <?php $total_pendapatan += $pendapatan_haji_sholeh; ?>

              <!-- Pendapatan Kirim Gudang Lainnya -->
              <tr>
                <td>Kirim Gudang (Tanah Abang & Lainnya)</td>
                <td align="right"><?php echo number_format($pendapatan_gudang_lainnya, 0, ',', '.') ?></td>
              </tr>
              <?php $total_pendapatan += $pendapatan_gudang_lainnya; ?>

              <tr style="font-weight: bold; border-top: 2px solid #000;">
                <td>TOTAL PENDAPATAN</td>
                <td align="right"><?php echo number_format($total_pendapatan, 0, ',', '.') ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>

              <!-- ===== BEBAN (dari jurnal akuntansi) ===== -->
              <tr style="background-color: #f4f4f4; font-weight: bold;">
                <th colspan="2">BEBAN (Jurnal Akuntansi)</th>
              </tr>
              <?php 
                $total_beban = 0;
                foreach($beban as $b): 
                  $total_beban += $b['total'];
              ?>
              <tr>
                <td><?php echo $b['nama_akun'] ?></td>
                <td align="right"><?php echo number_format((float)$b['total'], 0, ',', '.') ?></td>
              </tr>
              <?php endforeach; ?>
              <tr style="font-weight: bold; border-top: 1px solid #ccc;">
                <td>TOTAL BEBAN</td>
                <td align="right"><?php echo number_format($total_beban, 0, ',', '.') ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>

              <!-- ===== PENGELUARAN DIVISI KONVEKSI ===== -->
              <tr style="background-color: #1e3a5f; color: #fff; font-weight: bold;">
                <th colspan="2">PENGELUARAN DIVISI KONVEKSI</th>
              </tr>

              <!-- a. Ajuan Harian Konveksi (kecuali Sinar Hadi) -->
              <tr style="background-color: #eaf2ff;">
                <td colspan="2"><strong>a. Ajuan Harian Konveksi</strong> <small class="text-muted">(kecuali Sinar Hadi)</small></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Ajuan Harian (Kategori Konveksi)</td>
                <td align="right"><?php echo number_format($konveksi_ajuan_harian, 0, ',', '.') ?></td>
              </tr>

              <!-- b. Kasbon & Gaji Bulanan Konveksi -->
              <tr style="background-color: #eaf2ff;">
                <td colspan="2"><strong>b. Kasbon &amp; Gaji Bulanan Konveksi</strong></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Kasbon Karyawan Konveksi</td>
                <td align="right"><?php echo number_format($konveksi_kasbon, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Gaji Bulanan Karyawan Konveksi</td>
                <td align="right"><?php echo number_format($konveksi_gaji_bulanan, 0, ',', '.') ?></td>
              </tr>

              <!-- c. Gaji Gudang, KLO, Finishing -->
              <tr style="background-color: #eaf2ff;">
                <td colspan="2"><strong>c. Gaji Gudang, KLO &amp; Finishing</strong></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Gaji Karyawan Harian (Gudang, KLO, Finishing)</td>
                <td align="right"><?php echo number_format($konveksi_gaji_finishing, 0, ',', '.') ?></td>
              </tr>

              <!-- d. Uang Makan Security & Insentif -->
              <tr style="background-color: #eaf2ff;">
                <td colspan="2"><strong>d. Uang Makan Security &amp; Insentif</strong></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Uang Makan Security</td>
                <td align="right"><?php echo number_format($konveksi_uang_makan_security, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Insentif Security</td>
                <td align="right"><?php echo number_format($konveksi_insentif_security, 0, ',', '.') ?></td>
              </tr>

              <!-- e. Gaji Karyawan Sukabumi -->
              <tr style="background-color: #eaf2ff;">
                <td colspan="2"><strong>e. Gaji Karyawan Sukabumi</strong></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;Gaji &amp; Operasional Karyawan Sukabumi</td>
                <td align="right"><?php echo number_format($konveksi_gaji_sukabumi, 0, ',', '.') ?></td>
              </tr>

              <!-- Total Pengeluaran Konveksi -->
              <tr style="font-weight: bold; border-top: 2px solid #1e3a5f; background-color: #d0e4ff;">
                <td>TOTAL PENGELUARAN KONVEKSI</td>
                <td align="right"><?php echo number_format($total_pengeluaran_konveksi, 0, ',', '.') ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>

              <!-- ===== LABA / RUGI BERSIH ===== -->
              <tr style="background-color: #007bff; color: #fff; font-weight: bold;">
                <th>LABA / RUGI BERSIH</th>
                <th style="text-align: right;"><?php echo number_format($total_pendapatan - $total_beban - $total_pengeluaran_konveksi, 0, ',', '.') ?></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
