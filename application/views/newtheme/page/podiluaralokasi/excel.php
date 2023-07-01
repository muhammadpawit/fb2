<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=PoDiluarAlokasi.xls");
?>
<h3 style="text-align: center;text-decoration:underline">PO DILUAR ALOKASI</h3>
<table border="1" style="border-collapse: collapse;width: 100%" cellpadding="10">
<thead>
  <tr>
    <th class="tg-q6pl" rowspan="3">No</th>
    <th class="tg-q6pl" rowspan="3">NAMA PO</th>
    <th class="tg-q6pl" colspan="8">Rincian PO Kaos</th>
    <th class="tg-q6pl" rowspan="3">Jumlah</th>
    <th class="tg-q6pl" rowspan="3">Status</th>
    <th class="tg-1quo" rowspan="3"> Keterangan</th>
  </tr>
  <tr>
    <th class="tg-q6pl" colspan="2">Oblong (KD,FB&amp;HG)</th>
    <th class="tg-q6pl" colspan="2">Oblong (P &amp; 3/4)</th>
    <th class="tg-q6pl" rowspan="2">HUGO</th>
    <th class="tg-q6pl" rowspan="2">St KD/FB</th>
    <th class="tg-q6pl" rowspan="2">St Wangky</th>
    <th class="tg-q6pl" rowspan="2">Wangky</th>
    
  </tr>
  <tr>
    <th class="tg-q6pl">Biasa</th>
    <th class="tg-q6pl">Raglan</th>
    <th class="tg-q6pl">Biasa</th>
    <th class="tg-q6pl">Raglan</th>
  </tr>
</thead>
<tbody>
  <?php $jml=0;?>
  <?php 
    $oblongpdk_=0;
    $oblongpdkraglan_=0;
    $oblongpjg_=0;
    $hugo_=0;
    $stkd_=0;
    $stwangky_=0;
    $wangky_=0;
    $jumlah=0;
    $reglangpjg_=0;
  ?>
  <?php foreach($products as $p){?>
    <?php foreach($p['keterangan'] as $k){ ?>
      <?php
      
        $oblongpdk = $this->ReportModel->hitungALokasiPo_($p['idcmt'],array(5),$p['id'],$k['kode_po']);
				$oblongpdkraglan = $this->ReportModel->hitungALokasiPo_($p['idcmt'],array(9),$p['id'],$k['kode_po']);
				$oblongpjg =$this->ReportModel->hitungALokasiPo_($p['idcmt'],array(8),$p['id'],$k['kode_po']);
				$reglangpjg = $this->ReportModel->hitungALokasiPo_($p['idcmt'],array(30),$p['id'],$k['kode_po']);
				$hugo = $this->ReportModel->hitungALokasiPo_($p['idcmt'],array(6),$p['id'],$k['kode_po']);
				$stkd =$this->ReportModel->hitungALokasiPo_($p['idcmt'],array(2,19),$p['id'],$k['kode_po']);
				$stwangky = $this->ReportModel->hitungALokasiPo_($p['idcmt'],array(3,12),$p['id'],$k['kode_po']);
				$wangky =$this->ReportModel->hitungALokasiPo_($p['idcmt'],array(11),$p['id'],$k['kode_po']);
        
      ?>
  <tr align="center">
    <td class="tg-0pky"><?php echo $p['no']?></td>
    <td class="tg-0pky"><?php echo strtoupper($k['kode_po'])?></td>
    <td class="tg-0pky"><?php echo $oblongpdk?></td>
    <td class="tg-0pky"><?php echo $oblongpdkraglan?></td>
    <td class="tg-0pky"><?php echo $oblongpjg?></td>
    <td class="tg-0pky"><?php echo $reglangpjg?></td>
    <td class="tg-0pky"><?php echo $hugo?></td>
    <td class="tg-0pky"><?php echo $stkd?></td>
    <td class="tg-0pky"><?php echo $stwangky?></td>
    <td class="tg-0pky"><?php echo $wangky?></td>
    <td class="tg-0pky"><?php echo 1 ?></td>
    <td class="tg-0lax"><?php echo $k['nama']?></td>
  </tr>
  <?php 
    $oblongpdk_+=($oblongpdk);
    $oblongpdkraglan_+=($oblongpdkraglan);
    $oblongpjg_+=($oblongpjg);
    $reglangpjg_+=($reglangpjg);
    $hugo_+=($hugo);
    $stkd_+=($stkd);
    $stwangky_+=($stwangky);
    $wangky_+=($wangky);
    $jumlah++;
  ?>
  <?php } ?>
  <?php } ?>
</tbody>
<tfoot>
  <tr align="center">
    <td colspan="2" align="center"><b>Total</b></td>
    <td><?php echo $oblongpdk_ ?></td>
    <td><?php echo $oblongpdkraglan_ ?></td>
    <td><?php echo $oblongpjg_ ?></td>
    <td><?php echo $reglangpjg_ ?></td>
    <td><?php echo $hugo_ ?></td>
    <td><?php echo $stkd_ ?></td>
    <td><?php echo $stwangky_ ?></td>
    <td><?php echo $wangky_ ?></td>
    <td><?php echo $jumlah?></td>
    <td></td>
    <td></td>
  </tr>
</tfoot>
</table>
<br><br>
<br><br>
		<table>
        <tr>
          <td colspan="15" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
        </tr>
      </table>