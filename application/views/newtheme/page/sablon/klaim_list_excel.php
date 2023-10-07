<?php
 $namafile='Laporan_Potongan_Klaim_CMT_Sablon'.time();
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=".$namafile.time().".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h4>Potongan Claim CMT Sablon</h4>
<table border="1" style="width: 100%;border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama CMT</th>
            <th>Nominal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1;?>
        <?php foreach ($prods as $data): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['tanggal']; ?></td>
            <td><?php echo $data['namacmt']; ?></td>
            <td><?php echo ($data['harga']); ?></td>
            <td><?php echo $data['keterangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
	        <td colspan="5" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
	      </tr>
    </tfoot>
</table>