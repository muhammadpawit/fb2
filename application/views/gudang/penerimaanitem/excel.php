<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penerimaan_Item.xls");
?>            
            <table border="1" cellpadding="5" style="border-collapse: collapse;border-width: 3px;width: 100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Bagian</th>
                  <th>Tanggal</th>
                  <th>Nama Supplier</th>
                  <th>No Surat Jalan / Nota</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($items as $i){?>
                  <tr style="background-color:#b0eaff ">
                    <td><?php echo $n++?></td>
                    <td>
                      <?php 
                        if($i['jenis']==1){
                          echo "Konveksi";
                        }else if($i['jenis']==2){
                          echo "Bordir";
                        }else if($i['jenis']==3){
                          echo "Alat-alat Konveksi";
                        }else if($i['jenis']==4){
                          echo "Sablon";
                        }else{
                          echo "Default";
                        }
                      ?>
                    </td>
                    <td><?php echo $i['tanggal']?></td>
                    <td><?php echo $i['supplier']?></td>
                    <td><?php echo $i['nosj']?></td>
                    <td><?php echo $i['keterangan']?></td>
                  </tr>
                  <?php foreach($i['prods'] as $p){?>
                  <tr>
                    <td></td>
                    <td><?php echo strtoupper($p['nama'])?></td>
                    <td><?php echo $p['ukuran']?> <?php echo $p['satuanukuran']?></td>
                    <td><?php echo $p['jumlah']?> <?php echo $p['satuanJml']?></td>
                    <td>harga <span style="float: right;"><?php echo ($p['harga'])?></span> </td>
                    <td>Total <span style="float: right;">
                      <?php if($i['jenis']==1){?>
                        <?php echo ($p['ukuran']*$p['harga'])?>
                      <?php }else{ ?>
                        <?php echo ($p['jumlah']*$p['harga'])?>
                      <?php } ?>
                        </span>
                    </td>
                  </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>