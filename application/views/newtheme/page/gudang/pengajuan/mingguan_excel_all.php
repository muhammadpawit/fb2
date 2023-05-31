<?php
$namafile='Laporan_Ajuan_Alat-alat_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
      
      <table  class="table table-bordered" border="1" style="border-collapse: collapse;width: 100%">
        <tr>
          <th colspan="8" align="center">AJUAN ALAT - ALAT PO</th>
        </tr>
      </table>
      <table  class="table table-bordered" border="1" style="border-collapse: collapse;width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>NAMA BARANG</th>
            <th>KEBUTUHAN</th>
            <th>STOK</th>
            <th>AJUAN</th>
            <th>Satuan</th>
            <th>Tanggal Ajuan</th>
            <th>ACC SPV</th>
            <th>KET</th>
          </tr>
        </thead>
        <tbody>
          <?php $nomor=1; ?>
          <?php foreach($prods as $p){ ?>
              <?php foreach($p['ajuan'] as $a ) { ?>
                  <?php $satuan=$this->GlobalModel->QueryManualRow("SELECT * FROM product WHERE hapus=0 AND LOWER(nama)='".strtolower($a['kebutuhan'])."' "); ?>
                  <tr>
                    <td><?php echo $nomor++;?></td>
                    <td><?php echo $a['kebutuhan']?></td>
                    <td align="center"><?php echo $a['ajuan_kebutuhan']?></td>
                    <td align="center"><?php echo $a['stok']?></td>
                    <td align="center"><?php echo $a['jml_ajuan']?></td>
                    <td align="center"><?php echo $satuan['satuan'] ?></td>
                    <td align="center"><?php echo date('d-m-Y',strtotime($a['tanggal']))?></td>
                    <td align="center"><?php echo $a['jumlah_acc']?></td>
                    <td align="center"><?php echo $a['keterangan2']?></td>
                  </tr>
              <?php } ?>
          <?php } ?>
        </tbody>
      </table>
      <br>
      <table  class="table table-bordered" border="1" style="border-collapse: collapse;width: 100%">
        <tr>
          <td align="center" colspan="2">
            Menyetujui,<br>
            SPV
            <br>
            <br>
            <br>
            <br>
            <br>
            (MUCHLAS)
          </td>
          <td align="center" colspan="2">
            Dicek oleh,<br>
            ADM KEU
            <br>
            <br>
            <br>
            <br>
            <br>
            (DINDA)
          </td>
          <td align="center" colspan="2">
            Di cek oleh,<br>
            Mandor Admin
            <br>
            <br>
            <br>
            <br>
            <br>
            (AGUS)
          </td>
          <td align="center" colspan="2">
            Dibuat Oleh,<br>
            ADM GUDANG
            <br>
            <br>
            <br>
            <br>
            <br>
            (IFAH)
          </td>
        </tr>
      </table>
      <br>
      <br>
      <?php foreach($prods as $p){?>
        <?php foreach($p['ajuan'] as $k){?>
          <?php 
            $kd=$this->GlobalModel->getData('ajuan_mingguan_detail',array('hapus'=>0,'idajuan'=>$k['id']));
          ?>
          <table  class="table table-bordered" border="1" style="border-collapse: collapse;width: 100%">
            <tr>
              <td colspan="10" align="center"><b>Kebutuhan <?php echo $k['kebutuhan']?></b></t>
            </tr>
            <tr>
              <td colspan="10" align="center"><b><?php echo $k['keterangan2']?></b></t>
            </tr>
            <tr>
              <td colspan="10">Tanggal : <?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
            </tr>
            <tr>
              <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td>
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
                <?php } ?>
                <td><?php echo ($d['keterangan'])?></td>
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
          </table>
          <br><br>
    <?php } ?>
    <?php } ?>
    <table>
      <tr>
        <td colspan="10" align="right">
          <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
        </td>
      </tr>
    </table>