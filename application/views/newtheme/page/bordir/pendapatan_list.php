
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
            <th>0.18</th>
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

        foreach($products as $p) {
            echo '<tr>';
            echo '<td>Mesin ' . $p['nomesin'] . '</td>';
            echo '<td>' . $p['shift'] . '</td>';
            echo '<td align="right">' . number_format($p['stich']) . '</td>';
            echo '<td align="right">' . number_format($p['0.15']) . '</td>';
            echo '<td align="right">' . number_format($p['0.18']) . '</td>';

            $jumlah_permesin = $p['0.18']; // Mulai dengan nilai dari 0.18
            foreach($luar as $index => $b) {
                // Ambil nilai kolom dinamis
                $hasil = json_encode($this->ReportModel->total02_array($p['nomesin'], $p['shift'], $p['tanggal1'], $p['tanggal2'], $b['idpemilik']));
                $data = json_decode($hasil);
                $nilaiData = isset($data->data) ? $data->data : 0;
                $jumlah_permesin += $nilaiData; // Tambahkan nilai dinamis ke jumlah per mesin
                echo '<td align="right">' . number_format($nilaiData) . '</td>';

                // Tambahkan nilai ke total kolom luar
                $total_jumlah_luar[$index] += $nilaiData; 
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

            // Tambahkan pendapatan dari setiap shift
            $pendapatan_total_per_mesin[$p['nomesin']] += $p['pendapatan'];

            if ($p['shift'] == 'MALAM') {
                // Tampilkan total pendapatan pagi + malam pada baris shift malam
                // echo $p['nomesin'];
                echo number_format($this->ReportModel->totalpermesin($p['nomesin'],$tanggal1,$tanggal2));
                // echo number_format($pendapatan_total_per_mesin[$p['nomesin']]);
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
            <td align="right"><b><?php echo number_format($this->ReportModel->totalpermesin(null,$tanggal1,$tanggal2)); ?></b></td>
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
</script>