<?php
$namafile='Rincian_Potongan_Pinjaman_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<table border="1" style="width: 100%;border-collapse: collapse;">
	<thead>
			<tr>
                  <th colspan="5" align="center"><h2>History Potongan Pinjaman <?php echo $products['nama']?></h2></th>
              </tr>
	</thead>
</table>
<br>
			<table border="1" style="width: 100%;border-collapse: collapse;">
              <thead>
                <tr>
              
                  <th>Nominal Pinjaman</th>
                  <th>Nominal Potongan</th>
                  <th>Sisa</th>
                </tr>
              </thead>
              <tbody>
                    <tr>
                      <td><?php echo ($d['totalpinjaman'])?></td>
                      <td><?php echo ($d['totalpotongan'])?></td>
                      <td><?php echo ($d['totalpinjaman']-$d['totalpotongan'])?></td>
                    </tr>
              </tbody>
            </table>
            <br>
			<table border="1" style="width: 100%;border-collapse: collapse;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal Potongan</th>
                  <th>Nominal Potongan</th>
                  <th>Sisa</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if($details){?>
                  <?php foreach($details as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo date('d-m-Y',strtotime($p['tanggal'])) ?></td>
                      <td><?php echo ($p['totalpotongan'])?></td>
                      <td><?php echo ($p['sisa'])?></td>
                      <td><?php echo $p['keterangan']?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>