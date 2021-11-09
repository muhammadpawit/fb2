<!-- Potongan -->
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="alert" style="background-color: #1E5128 !important;color: white">Update Potongan Mingguan<br><?php echo $tanggalm1?> - <?php echo $tanggalm2?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekappotm as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'])?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- end potongan -->

<!-- Kirim Gudang -->
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="alert" style="background-color: #3D6AA2 !important;color: white">Update Kirim Gudang Tanah Abang Mingguan<br><?php echo $tanggalm1?> - <?php echo $tanggalm2?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Jumlah Nilai (Rp)</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekapkgmingguan as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'])?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                    <td><?php echo number_format($r['total'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                    $total+=($r['total']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Nilai Total (Rp)</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                    <td><b><?php echo number_format($total)?></b></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- End Kirim Gudang -->