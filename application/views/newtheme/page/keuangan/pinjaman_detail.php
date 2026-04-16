<div class="row">
  <div class="col-md-12">
    <h3 class="card-title">Rincian Pinjaman <?php echo $products['nama']?></h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-hover">
              <thead >
                <tr>
                  <th colspan="5">History Potongan Pinjaman</th>
                </tr>
                <tr>
                  <th><center>No</center></th>
                  <th><center>Tanggal Potongan</center></th>
                  <th><center>Nominal Potongan</center></th>
                  <th><center>Keterangan</center></th>
                  <th><center>Action</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $total=0;?>
                <?php if($details){?>
                  <?php foreach($details as $p){?>
                    <tr>
                      <td align="center"><?php echo $n++?></td>
                      <td><?php echo format_tanggal($p['tanggal']) ?></td>
                      <td align="right"><?php echo format_angka($p['totalpotongan'])?></td>
                      <td><?php echo $p['keterangan']?></td>
                      <td align="center">
                        <a href="<?php echo BASEURL.'Keuangan/hapus_rincian_pinjaman/'.$p['id']?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
                      </td>
                    </tr>
                    <?php $total+=($p['totalpotongan']);?>
                  <?php }?>
                <?php }?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" align="center"><b>Total Potongan</b></td>
                  <td align="right"><b><?php echo format_angka($total)?></b></td>
                  <td>
                    
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><b>Total Pinjaman</b></td>
                  <td align="right"><b><?php echo format_angka($products['totalpinjaman'])?></b></td>
                  <td>
                    
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><b>Sisa Pinjaman</b></td>
                  <td align="right"><b><?php echo format_angka($products['totalpinjaman']-$total)?></b></td>
                  <td>
                    
                  </td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <a href="<?php echo $cancel?>" class="btn btn-info btn-sm text-white"><i class="fa fa-chevron-left"></i> Kembali</a>
  </div>
</div>