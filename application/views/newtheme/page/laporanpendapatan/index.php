<style>
.pendapatan-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.pendapatan-table th, .pendapatan-table td {
    border: 1px solid #ccc;
    padding: 6px 10px;
    vertical-align: middle;
}
.pendapatan-table th {
    background: #f4f6f9;
    font-weight: 700;
    text-align: center;
    text-transform: uppercase;
    font-size: 11px;
}
.pendapatan-table td.text-right {
    text-align: right;
}
.pendapatan-table td.text-center {
    text-align: center;
}
.row-subtotal {
    background: #fce4ec;
    font-weight: 700;
}
.row-subtotal td {
    border-top: 2px solid #999 !important;
}
</style>

<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
      <button class="btn btn-danger btn-sm" onclick="cetakpdf()">Cetak PDF</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <h4 class="text-center" style="font-weight:700; margin-bottom:15px;">HITUNGAN PENDAPATAN FINISHING</h4>
    <div style="overflow-x:auto;">
    <table class="pendapatan-table">
      <thead>
        <tr>
          <th>NO</th>
          <th>PERIODE</th>
          <th>JENIS</th>
          <th>PENDAPATAN LUSINAN</th>
          <th>PERKALIAN</th>
          <th>HASIL</th>
          <th>PENGELUARAN</th>
          <th>NOMINAL</th>
          <th>SALDO</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        $grand_total_dz = 0;
        $grand_total_hasil = 0;
        $grand_total_nominal = 0;
        $grand_total_saldo = 0;
        
        foreach($weeks as $week){ 
            $rows = $week['pendapatan'];
            $rowCount = count($rows);
            
            // Calculate pengeluaran items for this week
            $pengeluaran = array();
            $pengeluaran[] = array('label' => $week['nama_tabung_gas'], 'nominal' => $week['tabung_gas']);
            $pengeluaran[] = array('label' => 'Anak Harian', 'nominal' => $week['anak_harian']);
            $pengeluaran[] = array('label' => 'Anak Borongan', 'nominal' => $week['anak_borongan']);
            
            // Total rows = max(pendapatan rows, pengeluaran rows)
            $totalRows = max($rowCount, count($pengeluaran));
            
            $week_total_dz = 0;
            $week_total_hasil = 0;
            $week_total_nominal = 0;
            
            foreach($pengeluaran as $pe){
                $week_total_nominal += $pe['nominal'];
            }
            
            for($i = 0; $i < $totalRows; $i++){
        ?>
          <tr>
            <!-- NO -->
            <td class="text-center"><?php echo ($i < $rowCount) ? $no++ : ''; ?></td>
            
            <!-- PERIODE -->
            <?php if($i == 0){ ?>
            <td rowspan="<?php echo $totalRows; ?>" style="vertical-align:middle; text-align:center; font-weight:600;">
              <?php echo $week['label']; ?>
            </td>
            <?php } ?>
            
            <!-- JENIS -->
            <td><?php echo ($i < $rowCount) ? $rows[$i]['jenis_po'] : ''; ?></td>
            
            <!-- PENDAPATAN LUSINAN -->
            <td class="text-right"><?php 
              if($i < $rowCount){ 
                echo number_format($rows[$i]['total_dz'], 2);
                $week_total_dz += $rows[$i]['total_dz'];
              } 
            ?></td>
            
            <!-- PERKALIAN -->
            <td class="text-right"><?php 
              if($i < $rowCount && $rows[$i]['nominal_perkalian'] > 0){ 
                echo number_format($rows[$i]['nominal_perkalian']);
              } 
            ?></td>
            
            <!-- HASIL -->
            <td class="text-right"><?php 
              if($i < $rowCount){ 
                echo number_format($rows[$i]['total_pendapatan']);
                $week_total_hasil += $rows[$i]['total_pendapatan'];
              } 
            ?></td>
            
            <!-- PENGELUARAN -->
            <td class="text-center"><?php echo ($i < count($pengeluaran)) ? $pengeluaran[$i]['label'] : ''; ?></td>
            
            <!-- NOMINAL -->
            <td class="text-right"><?php echo ($i < count($pengeluaran) && $pengeluaran[$i]['nominal'] > 0) ? number_format($pengeluaran[$i]['nominal']) : ''; ?></td>
            
            <!-- SALDO (only on first row or leave empty) -->
            <td></td>
          </tr>
        <?php } ?>
        
        <!-- Week subtotal -->
        <tr class="row-subtotal">
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><?php echo number_format($week_total_dz, 2); ?></td>
          <td></td>
          <td class="text-right"><?php echo number_format($week_total_hasil); ?></td>
          <td></td>
          <td class="text-right"><?php echo number_format($week_total_nominal); ?></td>
          <?php $saldo = $week_total_hasil - $week_total_nominal; ?>
          <td class="text-right" style="font-weight:700; color:<?php echo $saldo < 0 ? '#c62828' : '#000000'; ?>;"><?php 
            echo number_format($saldo);
            $grand_total_dz += $week_total_dz;
            $grand_total_hasil += $week_total_hasil;
            $grand_total_nominal += $week_total_nominal;
            $grand_total_saldo += $saldo;
          ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr style="background:#e8eaf6; font-weight:800; font-size:13px;">
          <td colspan="3" class="text-right"><b>GRAND TOTAL</b></td>
          <td class="text-right"><b><?php echo number_format($grand_total_dz, 2); ?></b></td>
          <td></td>
          <td class="text-right"><b><?php echo number_format($grand_total_hasil); ?></b></td>
          <td></td>
          <td class="text-right"><b><?php echo number_format($grand_total_nominal); ?></b></td>
          <td class="text-right" style="color:<?php echo $grand_total_saldo < 0 ? '#c62828' : '#000000'; ?>;"><b><?php echo number_format($grand_total_saldo); ?></b></td>
        </tr>
      </tfoot>
    </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  function filtertglonly(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }
  function cetakpdf(){
    var url='?pdf=1';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    window.open(url, '_blank');
  }
</script>
