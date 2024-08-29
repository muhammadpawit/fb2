<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Barangkeluar_".date('d F Y',strtotime($tanggal1)).' s.d '.date('d F Y',strtotime($tanggal2)).".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
    font-weight:bold;
    float: right;
  }
</style>            
            <table border="1" style="border-collapse:collapse">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nama PO</th>
                  <th>Nama Barang</th>
                  <th>Warna</th>
                  <th>Ukuran/Satuan</th>
                  <th>Jumlah/Satuan</th>
                  <th>Keterangan</th>
                  <th>Pengambil</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products)){?>
                  <?php foreach($products as $p){?>
                    <?php foreach($p['details'] as $d){?>
                      <tr>
                        <td><?php echo $p['no']?></td>
                        <td><?php echo $p['tanggal']?></td>
                        <td><?php echo $p['kode_po']?></td>
                        <td><?php echo $d['nama']?></td>
                        <td><?php echo $d['warna']?></td>
                        <td><?php echo $d['ukuran'].' '.$d['satuan_ukuran']?></td>
                        <td><?php echo $d['jumlah'].' '.$d['satuanJml']?></td>
                        <td><?php echo $p['keterangan']?></td>
                        <td><?php echo $p['pengambil']?></td>
                        <td></td>
                      </tr>
                    <?php } ?>
                  <?php }?>
                <?php } ?>
              </tbody>
            </table>