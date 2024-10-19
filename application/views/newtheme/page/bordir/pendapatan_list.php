
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
    <table class="table table-bordered table-striped">
    <thead>
        <tr style="background-color:yellow">
            <th>No.Mesin</th>
            <th>Shift</th>
            <th>Stich</th>
            <th>0.15</th>
            <th>0.18</th>
            <?php foreach($luar as $l){ ?>
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
        $grand_total = 0; // Total keseluruhan pendapatan
        
        // Step 1: Hitung total per mesin untuk setiap shift pagi dan malam
        foreach ($products as $p) {
            if (!isset($total_per_mesin[$p['nomesin']])) {
                $total_per_mesin[$p['nomesin']] = 0;
            }

            // Tambahkan pendapatan shift ke total mesin
            $total_per_mesin[$p['nomesin']] += $p['pendapatan'];
        }
        
        $j = 0;
        foreach ($products as $p): 
            // Step 2: Menampilkan data di tabel
        ?>
            <tr>
                <td>Mesin <?php echo $p['nomesin']; ?></td>
                <td><?php echo $p['shift']; ?></td>
                <td align="right"><?php echo number_format($p['stich'])?></td>
                <td align="right"><?php echo number_format($p['0.15']); ?></td>
                <td align="right"><?php echo number_format($p['0.18'])?></td>
                
                <?php foreach($luar as $b): ?>
                    <td align="right">
                        <?php 
                            // Dapatkan data pendapatan luar jika ada
                            $hasil = json_encode($this->ReportModel->total02_array($p['nomesin'],$p['shift'],$p['tanggal1'],$p['tanggal2'],$b['idpemilik']));
                            $data = json_decode($hasil);
                            echo isset($data->data) ? number_format($data->data) : 0;
                        ?>
                    </td>
                <?php endforeach; ?>

                <td align="right"><?php echo number_format($p['pendapatan']); ?></td>
                
                <td align="right">
                    <?php 
                    // Step 3: Hanya tampilkan total pendapatan per mesin di shift malam
                    if ($p['shift'] == 'MALAM' && isset($total_per_mesin[$p['nomesin']])) {
                        echo number_format($total_per_mesin[$p['nomesin']]);
                        $grand_total += $total_per_mesin[$p['nomesin']]; // Tambahkan ke grand total
                    } else {
                        echo 0;
                    }
                    ?>
                </td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        
        <!-- Step 4: Tampilkan total keseluruhan di baris paling bawah -->
        <tr>
            <td colspan="7" align="right"><b>Total</b></td>
            <td align="right"><?php echo number_format($grand_total); ?></td>
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