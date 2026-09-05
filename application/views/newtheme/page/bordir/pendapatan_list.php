
<div class="row">
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>No.Mesin</label>
              <select name="nomesin" class="form-control select2bs4" id="nomesin">
                <option value="*">Semua</option>
                <?php for($i=1;$i<=10;$i++){?>
                  <option value="<?php echo $i?>" <?php echo $nomesin==$i?'selected':'';?>>Mesin <?php echo $i?></option>
                <?php } ?>
              </select>
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Action</label><br>
              <button class="btn btn-info" onclick="filter()">Filter</button>
              <button class="btn btn-info" onclick="excel()">Excel</button>
              <button class="btn btn-info" onclick="pdf()">PDF</button>
          </div>
      </div>
</div>
<div class="row table-responsive">
  <div class="col-md-12">
    <div class="form-group">
    <table class="table table-bordered table-striped table-hover">
    <thead>
        <tr style="background-color:yellow">
            <th>No.Mesin</th>
            <th>Shift</th>
            <th>Stich</th>
            <th>0.15</th>
            <th><?php echo isset($label_tarif_dalam) ? $label_tarif_dalam : '0.18'; ?></th>
            <?php foreach($luar as $l) { ?>
                <th><?php echo $l['perkalian'] .' '.$l['nama']?></th>
            <?php } ?>
            <th>Jml Per Mesin (Rp)</th>
            <th>Pendapatan Per Mesin (Rp)</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_per_mesin = [];
        $grand_total = 0; // Total pendapatan keseluruhan
        $total_jumlah_per_mesin = 0; // Total jumlah per mesin keseluruhan
        $pendapatan_total_per_mesin = []; // Total pendapatan pagi + malam untuk setiap mesin

        // Hitung total pendapatan per mesin untuk setiap shift pagi dan malam
        foreach ($products as $p) {
            if (!isset($total_per_mesin[$p['nomesin']])) {
                $total_per_mesin[$p['nomesin']] = 0;
            }
            // Tambahkan pendapatan shift ke total mesin
            $total_per_mesin[$p['nomesin']] += $p['pendapatan'];
        }

        // Inisialisasi total kolom
        $total_stich = 0;
        $total_0_15 = 0;
        $total_0_18 = 0;
        $total_jumlah_luar = array_fill(0, count($luar), 0); // Total untuk kolom luar
        $nilai_terhitung=[];
        $special_rates = [
            4 => 900, // ID Pemilik 4 Dedi: Rp 900 per Qty
        ];

        foreach($products as $p) {
            echo '<tr>';
            echo '<td>Mesin ' . $p['nomesin'] . '</td>';
            echo '<td>' . $p['shift'] . '</td>';
            echo '<td align="right">' . number_format($p['stich']) . '</td>';
            echo '<td align="right">' . number_format($p['0.15']) . '</td>';
            echo '<td align="right">' . number_format($p['0.18']) . '</td>';

            $jumlah_permesin = $p['0.18']; // Mulai dengan nilai dari 0.18
            foreach ($luar as $index => $b) {
              $key = $b['idpemilik'] . '_' . $b['perkalian'];
              $dataItem = isset($p['dynamic'][$key]) ? $p['dynamic'][$key] : ['total' => 0, 'qty' => 0];
              
              // Cek apakah pemilik ini memiliki tarif khusus per Qty
              if (isset($special_rates[$b['idpemilik']])) {
                  $nilaiData = $dataItem['qty'] * $special_rates[$b['idpemilik']];
              } else {
                  $nilaiData = $dataItem['total'];
              }
          
              $jumlah_permesin += $nilaiData; // Tambahkan nilai dinamis ke jumlah per mesin
              $total_jumlah_luar[$index] += $nilaiData; // Tambahkan nilai ke total kolom luar
          
              // Tampilkan nilai di kolom tabel
              echo '<td align="right">' . number_format($nilaiData) . '</td>';
          }
            // Tampilkan jumlah per mesin
            echo '<td align="right">' . number_format($jumlah_permesin) . '</td>';
            $total_jumlah_per_mesin += $jumlah_permesin; // Hitung total jumlah per mesin

            // Pendapatan Per Mesin, tampilkan hanya di shift "MALAM" setelah menjumlahkan PAGI dan MALAM
            echo '<td align="right">';
            if (!isset($pendapatan_total_per_mesin[$p['nomesin']])) {
                // Inisialisasi pendapatan total per mesin
                $pendapatan_total_per_mesin[$p['nomesin']] = 0;
            }

            // Tambahkan pendapatan dari setiap shift (menggunakan jumlah_permesin agar sinkron)
            $pendapatan_total_per_mesin[$p['nomesin']] += $jumlah_permesin;

            if ($p['shift'] == 'MALAM') {
                // Tampilkan total pendapatan pagi + malam pada baris shift malam
                echo number_format($pendapatan_total_per_mesin[$p['nomesin']]);
                $grand_total += $pendapatan_total_per_mesin[$p['nomesin']]; // Tambahkan ke grand total
            } else {
                // Kosongkan kolom untuk shift "PAGI"
                echo '';
            }
            echo '</td>';
            echo '<td></td>'; // Keterangan
            echo '</tr>';

            // Tambahkan nilai untuk total kolom tetap
            $total_stich += $p['stich'];
            $total_0_15 += $p['0.15'];
            $total_0_18 += $p['0.18'];
        }
        ?>

        <!-- Tampilkan total di footer -->
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td align="right"><b><?php echo number_format($total_stich); ?></b></td>
            <td align="right"><b><?php echo number_format($total_0_15); ?></b></td>
            <td align="right"><b><?php echo number_format($total_0_18); ?></b></td>
            <?php 
            foreach($total_jumlah_luar as $total_luar) {
                echo '<td align="right"><b>' . number_format($total_luar) . '</b></td>';
            }
            ?>
            <td align="right"><b><?php echo number_format($total_jumlah_per_mesin); ?></b></td>
            <td align="right"><b><?php echo number_format($grand_total); ?></b></td>
            <td></td>
        </tr>
    </tbody>
</table>

    </div>
  </div>
</div>

<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }

   function excel(){
    var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }

  function pdf(){
    var url='?pdf=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    $('#pdfLoading').show();
    $('#pdfIframe').hide();
    $('#pdfIframe').attr('src', url);
    $('#pdfModal').modal('show');
    
    $('#pdfIframe').on('load', function(){
        $('#pdfLoading').hide();
        $('#pdfIframe').show();
    });
  }
  // Reset iframe saat modal ditutup
  $(document).ready(function(){
      $("#pdfModal").on("hidden.bs.modal", function () {
          $("#pdfIframe").attr("src", "");
      });
  });
</script>
<!-- Modal PDF Preview -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 98%; max-width: 98%; height: 95vh; margin: 1vh auto;">
        <div class="modal-content" style="height: 95vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel"><i class="fa fa-file-pdf"></i> Preview Laporan Pendapatan Mesin Bordir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; height: calc(95vh - 120px);">
                <div id="pdfLoading" style="display:flex; justify-content:center; align-items:center; height:100%;">
                    <div style="text-align:center;">
                        <i class="fa fa-spinner fa-spin fa-3x"></i>
                        <p style="margin-top:10px;">Memuat PDF...</p>
                    </div>
                </div>
                <iframe id="pdfIframe" style="width: 100%; height: 100%; border: none; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
