<div class="row">
  <div class="col-md-12">
    <h3 class="card-title">Rincian Pinjaman <?php echo $products['nama']?></h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th colspan="4">History Potongan Pinjaman</th>
                </tr>
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
                      <td><?php echo number_format($p['totalpotongan'])?></td>
                      <td><?php echo number_format($p['sisa'])?></td>
                      <td><?php echo $p['keterangan']?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <a href="<?php echo $cancel?>" class="btn btn-info btn-sm text-white full"><i class="fa fa-chevron-left"></i> Kembali</a>
  </div>
  <div class="col-md-6">
    <a onclick="excelwithtgl()" class="btn btn-success text-white btn-sm full">Excel</a>
  </div>
</div>