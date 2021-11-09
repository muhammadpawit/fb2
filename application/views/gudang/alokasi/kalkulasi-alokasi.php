<div class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card-box">
              <table width="300" border="1" class="text-center">
                <tr>
                  <td>JENIS PO</td>
                  <td>: <?php echo $alokasi['nama_jenis_po'] ?></td>
                </tr>
                <tr>
                  <td>SIZE PO</td>
                  <td>: <?php echo $alokasi['nama_size'] ?></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="card-box">
              <form action="<?php echo BASEURL.'alokasi/kalkulasiAlokasi/'.$alokasi['id_alokasi'] ?>" method="GET">
                <div class="form-group">
                  <label>Lusin(DZ)</label>
                  <input type="number" class="form-control" name="lusin" required>
                  <p style="color: red;font-size: 15pt" class=" mt-2">Masukan berapa lusin untuk di kalkulasi</p>
                </div>
                <button class="btn btn-info" type="submit">SUBMIT</button>
              </form>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card-box">
               <div class="row">
                   <div class="col-md-12">
                        <h3 class="text-center">ALAT PERLUSIN</h3>
                       <table class="table table-bordered">
                           <tr>
                               <th>Nama Item</th>
                               <th>Jumlah Item</th>
                               <th>Satuan Item</th>
                           </tr>
                           <?php foreach ($itemKalkulasi as $key => $kal): ?>
                            <tr>
                                <td><?php echo $kal['nama_item'] ?></td>
                                <td><?php echo $kal['qty_alokasi_po'] ?></td>
                                <td><?php echo $kal['satuan_jumlah_item'] ?></td>
                            </tr>
                           <?php endforeach ?>
                       </table>
                   </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card-box">
               <div class="row">
                   <div class="col-md-12">
                        <h3 class="text-center">PERSEDIAAN ALAT</h3>
                       <table class="table table-bordered">
                           <tr>
                               <th>Nama Item</th>
                               <th>Jumlah Item</th>
                               <th>Satuan Item</th>
                           </tr>
                            <?php foreach ($itemKalkulasi as $key => $kal): ?>
                            <tr>
                                <td><?php echo $kal['nama_item'] ?></td>
                                <td><?php echo $kal['jumlah_item'] ?></td>
                                <td><?php echo $kal['satuan_jumlah_item'] ?></td>
                            </tr>
                           <?php endforeach ?>
                       </table>
                   </div>
               </div>
           </div>
          </div>

          <div class="col-md-12">
            <div class="card-box">
               <div class="row">
                   <div class="col-md-12">
                    <h4>Kebutuhan untuk : <?php echo $lusin ?> Lusin (Dz)</h4>
                        <h3 class="text-center">KALKULASI ALAT</h3>
                       <table class="table table-bordered">
                           <tr>
                               <th>Nama Alat</th>
                               <th>Qty Alat Persediaan</th>
                               <th>Kebutuhan Alat</th>
                               <th>-/+ Stock Alat</th>
                               <th>Satuan Alat</th>
                           </tr>
                            <?php foreach ($itemKalkulasi as $key => $kal): ?>
                            <tr>
                                <td><?php echo $kal['nama_item'] ?></td>
                                <td><?php echo $kal['jumlah_item'] ?></td>
                                <td><?php echo $lusin*$kal['qty_alokasi_po'] ?></td>
                                <td><?php echo $kal['jumlah_item']-($lusin*$kal['qty_alokasi_po']) ?></td>
                                <td><?php echo $kal['satuan_jumlah_item'] ?></td>
                            </tr>
                           <?php endforeach ?>
                       </table>
                   </div>
               </div>
           </div>
          </div>

    </div>
  </div>
</div>