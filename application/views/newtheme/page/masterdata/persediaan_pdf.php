<style type="text/css">
  body{text-transform:capitalize;font-size: 12px;font-family: 'Roboto';-webkit-print-color-adjust: exact !important;color:blue !important;}
  table{
    font-family: 'Roboto';font-size: 13px !important;width: 100% !important;margin-top: 15px !important;
    border: 1px #8b948d black;border-collapse: collapse;
  }
  .clear{
    clear: both;
  }
  .print{ display:none !important}
  h1{
    text-align: center;
  }

  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
          <h1>Laporan Persediaan </h1>
            <table cellpadding="3" border="1">
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
                              <img src="<?php echo BASEURL.'uploads/persediaan/'.$p['foto'] ?>" height="100" >
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
              <tfoot>
                <tr>
                      <td colspan="8" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
                    </tr>
              </tfoot>
            </table>