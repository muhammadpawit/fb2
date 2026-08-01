<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Permintaan Kasbon</th>
                  <th>Acc Kasbon</th>
                  <th>Potongan Warteg</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p){?>
                  <tr>
                    <td><?php echo !empty($p['tanggal']) ? formatTanggalIndo($p['tanggal']) : ''?></td>
                    <td><?php echo $p['nama']?></td>
                    <td><?php echo $p['divisi']?></td>
                    <td><?php echo $p['nominal']?></td>
                    <td><?php echo $p['nominal_acc']?></td>
                    <td><?php echo $p['potongan_warteg']?></td>
                    <td><?php echo $p['status']==0?'Diajukan':'Disetujui';?></td>
                    <td>
                      <a href="<?php echo $p['detail']?>" class="btn btn-warning btn-xs">Detail</a>
                      <?php if(aksesedit()==1){?>
                        <?php if (date('Y-m', strtotime($p['tanggal'])) == date('Y-m') || $this->session->userdata('id_user') == 11) { ?>
                        <a href="<?php echo $p['edit']?>" class="btn btn-primary btn-xs">Edit</a>
                        <?php } ?>
                      <?php } ?>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3"><b>Total Keseluruhan</b></td>
                  <td><b><?php echo number_format($totalrequest)?></b></td>
                  <td><b><?php echo number_format($totalkasbon)?></b></td>
                  <td><b><?php echo number_format($totalpotongan)?></b></td>
                  <td colspan="2"></td>
                </tr>
              </tfoot>
            </table>
  </div>
</div>