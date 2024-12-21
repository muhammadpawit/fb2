<html>
  <head></head>
  <body>
    <div class="title">
      <center>
            <h3>Laporan Persediaan</h3>
      </center>
    </div>
    <div class="body">
            <table border="1" style="border-collapse: collapse;width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Quantity</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>          
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                        <tr>
                          <td align="center"><?php echo $i++?></td>
                          <td>
                            <?php if(!empty($p['foto'])){?>
                              <img src="<?php echo BASEURL.'uploads/persediaan/'.$p['foto'] ?>" height="100" width="150" >
                            <?php } ?>
                          </td>
                          <td><?php echo $p['kodebarang']?></td>
                          <td><?php echo $p['nama']?></td>
                          <td><?php echo $p['ukuran_item'].' '.$p['satuan_ukuran_item']?></td>
                          <td><?php echo $p['quantity'].' '.$p['satuanqty']?></td>
                          <td align="right"><?php echo $p['price']?></td>
                          <td align="right"><?php echo ($p['price']*$p['quantity'])?></td>
                        </tr>
                        <?php } ?>
                <?php }?>
              </tbody>
            </table>
    </div>
    <div class="registered">
        <i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
    </div>
  </body>
</html>