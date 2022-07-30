<form method="post" action="<?php echo $action ?>">
  <input type="hidden" name="id" value="<?php echo $k['id']?>">
  <input type="hidden" name="tanggal" value="<?php echo $k['tanggal']?>">
  <input type="hidden" name="jenis" value="<?php echo $k['jenis']?>">
  <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <tr>
            <td colspan="10" align="center"><b>Kebutuhan <?php echo $k['kebutuhan']?></b></td>
          </tr>
          <tr>
            <td colspan="10" align="center"><b>Untuk 1 Minggu</b></td>
          </tr>
          <tr>
            <td colspan="10">Tanggal : <?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
          </tr>
          <tr>
            <!-- <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td> -->
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Nama PO</b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Rincian PO</b></td>
            <td colspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
            <td colspan="3" style="vertical-align: middle;text-align: center;"><b>Ajuan </b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket</b></td>
          </tr>
          <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">PCS</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">DZ</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Kebutuhan</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Stok</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ajuan</td>
          </tr>
          <?php $i=0;$pcs=0;$dz=0;?>
          <?php foreach($kd as $d){?>
            <tr>
              <!-- <td></td> -->
              <td>
                <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>">
                <input type="text" name="products[<?php echo $i?>][kode_po]" value="<?php echo $d['kode_po']?>">
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jumlah_po]" size="5" value="<?php echo $d['jumlah_po']?>">
              </td>
              <td>
                <textarea name="products[<?php echo $i?>][rincian_po]"><?php echo $d['rincian_po']?></textarea>
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jml_pcs]" size="5" value="<?php echo ($d['jml_pcs'])?>">
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jml_dz]" size="5" value="<?php echo ($d['jml_dz'])?>">
              </td>
              <td valign="middle" style="vertical-align: middle !important;text-align: center !important;"><?php echo ($d['jumlah_po']*$d['jml_pcs'])?></td>
              <?php if(0==$i){?>
              <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['stok']?></td>
              <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['jml_ajuan']?> .</td>
              <?php } ?>
              <td>
                <textarea name="products[<?php echo $i ?>][keterangan]"><?php echo ($d['keterangan'])?></textarea>
              </td>
            </tr>
            <?php $i++?>
            <?php 
              $pcs+=$d['jml_pcs'];
              $dz+=$d['jml_dz'];
            ?>
          <?php } ?>
            <tr style="background-color: #ffe0fb">
              <td colspan="4"><b>Total</b></td>
              <td><b><?php echo $pcs?></b></td>
              <td><b><?php echo $dz?></b></td>
              <td align="center"><b><?php echo $k['ajuan_kebutuhan']?></b></td>
              <td><b><?php //echo $k['stok']?></b></td>
              <td><b><?php //echo $k['jml_ajuan']?></b></td>
              <td></td>
            <tr>
              <td colspan="10" align="right"><b>Registered by Forboys Production System</b></td>
            </tr>
        </table>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <button class="btn btn-success btn-sm full">Simpan</button>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
      </div>
    </div>
  </div>
</form>