<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=ALokasisiapkirim.xls");
?>
<h3>Alokasi PO CMT</h3>
<table border="1" style="border-collapse: collapse;width: 100%" cellpadding="10">
<thead>
  <tr>
    <th class="tg-q6pl" rowspan="3">No</th>
    <th class="tg-q6pl" rowspan="3">CMT</th>
    <th class="tg-q6pl" colspan="8">Rincian PO Kaos</th>
    <th class="tg-q6pl" colspan="3">Jumlah PO</th>
    <th class="tg-q6pl" rowspan="3">Keterangan PO Katun</th>
    <th class="tg-1quo" rowspan="3"> Keterangan PO celana katun pengganti loreng</th>
  </tr>
  <tr>
    <th class="tg-q6pl" colspan="2">Oblong (KD,FB&amp;HG)</th>
    <th class="tg-q6pl" colspan="2">Oblong (P &amp; 3/4)</th>
    <th class="tg-q6pl" rowspan="2">HUGO</th>
    <th class="tg-q6pl" rowspan="2">St KD/FB</th>
    <th class="tg-q6pl" rowspan="2">St Wangky</th>
    <th class="tg-q6pl" rowspan="2">Wangky</th>
    <th class="tg-q6pl" rowspan="2">Jumlah PO Katun </th>
    <th class="tg-q6pl" rowspan="2">PO Pengganti</th>
    <th class="tg-q6pl" rowspan="2">Lusinan</th>
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
  <?php foreach($products as $p){?>
  <tr>
    <td class="tg-0pky"><?php echo $p['no']?></td>
    <td class="tg-0pky"><?php echo strtoupper($p['nama'])?></td>
    <td class="tg-0pky"><?php echo $p['oblongpdk']?></td>
    <td class="tg-0pky"><?php echo $p['oblongpdkraglan']?></td>
    <td class="tg-0pky"><?php echo $p['oblongpjg']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"><?php echo $p['hugo']?></td>
    <td class="tg-0pky"><?php echo $p['stkd']?></td>
    <td class="tg-0pky"><?php echo $p['stwangky']?></td>
    <td class="tg-0pky"><?php echo $p['wangky']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">
		<?php foreach($p['keterangan'] as $k){?>
			<?php echo $k['kode_po']?>,
		<?php } ?>
	</td>
    <td class="tg-0lax"></td>
  </tr>
  <?php } ?>
</tbody>
</table>
<br><br>
<h3>Stok PO CMT</h3>
<table border="1" style="border-collapse: collapse;width: 100%" cellpadding="10">
<thead>
  <tr>
    <th class="tg-q6pl" rowspan="3">No</th>
    <th class="tg-q6pl" rowspan="3">CMT</th>
    <th class="tg-q6pl" colspan="8">Rincian PO Kaos</th>
    <th class="tg-q6pl" colspan="3">Jumlah PO</th>
    <th class="tg-q6pl" rowspan="3">Keterangan PO Katun</th>
    <th class="tg-1quo" rowspan="3"> Keterangan PO celana katun pengganti loreng</th>
  </tr>
  <tr>
    <th class="tg-q6pl" colspan="2">Oblong (KD,FB&amp;HG)</th>
    <th class="tg-q6pl" colspan="2">Oblong (P &amp; 3/4)</th>
    <th class="tg-q6pl" rowspan="2">HUGO</th>
    <th class="tg-q6pl" rowspan="2">St KD/FB</th>
    <th class="tg-q6pl" rowspan="2">St Wangky</th>
    <th class="tg-q6pl" rowspan="2">Wangky</th>
    <th class="tg-q6pl" rowspan="2">Jumlah PO Katun </th>
    <th class="tg-q6pl" rowspan="2">PO Pengganti</th>
    <th class="tg-q6pl" rowspan="2">Lusinan</th>
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
  <?php foreach($stok as $p){?>
  <tr>
    <td class="tg-0pky"><?php echo $p['no']?></td>
    <td class="tg-0pky"><?php echo strtoupper($p['nama'])?></td>
    <td class="tg-0pky"><?php echo $p['oblongpdk']?></td>
    <td class="tg-0pky"><?php echo $p['oblongpdkraglan']?></td>
    <td class="tg-0pky"><?php echo $p['oblongpjg']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"><?php echo $p['hugo']?></td>
    <td class="tg-0pky"><?php echo $p['stkd']?></td>
    <td class="tg-0pky"><?php echo $p['stwangky']?></td>
    <td class="tg-0pky"><?php echo $p['wangky']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">
		<?php foreach($p['keterangan'] as $k){?>
			<?php echo $k['kode_po']?>,
		<?php } ?>
	</td>
    <td class="tg-0lax"></td>
  </tr>
  <?php } ?>
</tbody>
</table>
<br><br>
		<table>
        <tr>
          <td colspan="15" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
        </tr>
      </table>