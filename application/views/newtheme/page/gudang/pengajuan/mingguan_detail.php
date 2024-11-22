<div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table table-bordered">
        <tr>
          <td colspan="11" align="center"><b>Kebutuhan <?php echo $k['kebutuhan']?></b></td>
        </tr>
        <!-- <tr>
          <td colspan="11" align="center"><b><?php echo $k['keterangan2']?></b></td>
        </tr> -->
        <tr>
          <td colspan="11">Tanggal : <?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
        </tr>
        <tr>
          <?php 
            $supplier=null;
            $cek = $this->GlobalModel->GetDataRow('master_supplier',array('id' => $k['supplier_id']));
          ?>
          <td colspan="11">Supplier : <?php echo isset($supplier['nama']) ? $supplier['nama'] : '' ?></td>
        </tr>
        <tr>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Nama PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Rincian PO</b></td>
          <td colspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td colspan="3" style="vertical-align: middle;text-align: center;"><b>Ajuan </b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket.Satuan</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket</b></td>
        </tr>
        <tr>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">PCS</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">DZ</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Kebutuhan</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Stok</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ajuan</td>
        </tr>
        <?php $i=0;$pcs=0;$dz=0;$jmlpo=0;?>
        <?php foreach($kd as $d){?>
          <tr>
            <td><?php echo $n++?></td>
            <td><?php echo $d['kode_po']?></td>
            <td><?php echo $d['jumlah_po']?> PO</td>
            <td><?php echo $d['rincian_po']?></td>
            <td><?php echo number_format($d['jml_pcs'],1)?></td>
            <td><?php echo number_format($d['jml_dz'],1)?></td>
            <td valign="middle" style="vertical-align: middle !important;text-align: center !important;"><?php echo ($d['jumlah_po']*$d['jml_pcs'])?></td>
            <?php if(0==$i){?>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['stok']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['jml_ajuan']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['keterangan2']?></td>
            <?php } ?>
            <!-- <td>lusinan <?php echo number_format($d['jml_dz'])?></td> -->
            <td><?php echo ($d['keterangan'])?></td>
          </tr>
          <?php $i++?>
          <?php 
            $pcs+=$d['jml_pcs'];
            $dz+=$d['jml_dz'];
            $jmlpo+=($d['jumlah_po']);
          ?>
        <?php } ?>
          <tr style="background-color: #ffe0fb">
            <td colspan="2"><b>Total</b></td>
            <td><b><?php echo $jmlpo?></b></td>
            <td></td>
            <td><b><?php echo $pcs?></b></td>
            <td><b><?php echo $dz?></b></td>
            <td align="center"><b><?php echo $k['ajuan_kebutuhan']?></b></td>
            <td><b><?php //echo $k['stok']?></b></td>
            <td><b><?php //echo $k['jml_ajuan']?></b></td>
            <td></td>
            <td></td>
          <tr>
            <td colspan="11" align="right"><b>Registered by Forboys Production System</b></td>
          </tr>
      </table>
    </div>
</div>
<form method="POST" action="<?php echo $acc?>">
  <input type="hidden" name="id" value="<?php echo $k['id']?>">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Jumlah Acc</label>
        <input type="text" name="jml_acc" value="<?php echo $k['jml_acc']?>" class="form-control">
      </div>
      <div class="form-group">
        <label></label>
        <button type="submit" class="btn btn-success full">Setujui</button>
      </div>
    </div>
    <div class="col-md-3">
      
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm no-print text-white">Cancel</a>
        <button class="btn btn-default btn-sm no-print" onclick="window.print()">Cetak</button>
        <a href="<?php echo $excel?>" class="btn btn-success btn-sm no-print text-white">Excel</a>
      </div>
    </div>
  </div>
</form>
<div class="row">
</div>