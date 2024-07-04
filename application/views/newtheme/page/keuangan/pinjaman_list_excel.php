<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Pinjaman.xls");
?>             

<h2>Pinjaman Karyawan</h2>
              <table border="1" style="width: 100%;border-collapse: collapse;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Jumlah Pinjaman</th>
                  <th>Jumlah Potongan</th>
                  <th>Sisa Pinjaman</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo ucwords($p['nama'])?></td>
                      <td><?php echo $p['totalpinjaman']?></td>
                      <td><?php echo $p['totalpotongan']?></td>
                      <td><?php echo $p['sisa'];?></td>
                      <td><?php echo $p['keterangan'];?></td>
                      <td>
                        <?php
                          if($p['status']==1 OR $p['status']==2){
                            echo "<span class='badge bg-red'>Belum Lunas</span>";
                          }else{
                            echo "<span class='badge bg-green'>Lunas</span>";
                          }

                        ?>
                      </td>
                      
                    </tr>
                  <?php }?>
                <?php }?>
                <tr>
                  <td colspan="8"></td>
                </tr>
                <tr>
                  <td colspan="8" align="right"><b>Registered by Forboys Production System</b></td>
                </tr>
              </tbody>
            </table>