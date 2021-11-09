<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_kirimsetor_cmt.xls");
?>
<table border="1" style="width: 100%;border-collapse: collapse;">
	<thead style="text-align: center;">
		<tr>
			<th colspan="18">Laporan Kirim Setor CMT</th>
		</tr>
		<tr>
			<th colspan="18">Periode <?php echo date('d F Y',strtotime($tanggal1))?> sampai <?php echo date('d F Y',strtotime($tanggal2))?></th>
		</tr>
	</thead>
</table>
<br>
<table border="1" style="width: 100%;border-collapse: collapse;">
<thead style="text-align: center;">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama CMT</th>
            <th colspan="2">Stok Awal Kaos</th>
            <th colspan="2">Stok Awal Kemeja</th>
            <th colspan="2">Setor Kaos</th>
            <th colspan="2">Setor Kemeja</th>
            <th colspan="2">Kirim Kaos</th>
            <th colspan="2">Kirim Kemeja</th>
            <th colspan="2">Stok Akhir Kaos</th>
            <th colspan="2">Stok Akhir Kemeja</th>
          </tr>
          <tr>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $p){?>
            <tr>
              <td><?php echo $p['no']?></td>
              <td><?php echo $p['nama']?></td>
              <td><?php echo ($p['stokawalkaosjml'])?></td>
              <td><?php echo $p['stokawalkaosdz']>0?number_format($p['stokawalkaosdz']):'';?></td>
              <td><?php echo ($p['stokawalkemejajml'])?></td>
              <td><?php echo $p['stokawalkemejadz']>0?number_format($p['stokawalkemejadz']):'';?></td>
              <td><?php echo ($p['setorkaosjml'])?></td>
              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td>
              <td><?php echo ($p['setorkemejajml'])?></td>
              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td>
              <td><?php echo ($p['kirimkaosjml'])?></td>
              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz']):'';?></td>
              <td><?php echo ($p['kirimkemejajml'])?></td>
              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td>
              <td><?php echo ($p['stokakhirkaosjml'])?></td>
              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz']):'';?></td>
              <td><?php echo ($p['stokakhirkemejajml'])?></td>
              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td>
            </tr>
          <?php }?>
        </tbody>
    </table>