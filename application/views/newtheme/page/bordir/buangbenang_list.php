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
      <!-- <button class="btn btn-info btn-sm" onclick="excel()">Excel</button> -->
      <a href="<?php echo $tambah?>" class="btn btn-sm btn-info">&nbsp;Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>PO</th>
                  <th>Bagian</th>
                  <th>Size</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p){?>
                  <tr>
                    <td><?php echo $n++?></td>
                    <td><?php echo $p['tanggal']?></td>
                    <td><?php echo $p['pekerja']?></td>
                    <td><?php echo $p['kode_po']?></td>
                    <td><?php echo $p['bagian']?></td>
                    <td><?php echo $p['size']?></td>
                    <td><?php echo $p['qty']?></td>
                    <td><?php echo $p['harga']?></td>
                    <td><?php echo $p['keterangan']?></td>
                    <td>
                      <?php //if(akseshapus()==1){?>
                        <a href="<?php echo $p['hapus']?>" class="btn btn-danger btn-sm">Hapus</a>
                      <?php //} ?>
                    </td>
                  </tr>

                <?php }?>
              </tbody>
            </table>
  </div>
</div>