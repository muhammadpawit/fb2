<!-- Modal Tambah Potongan langsung dari halaman detail -->
<?php if(($products['totalpinjaman'] - $products['totalpotongan']) > 0){ ?>
<div id="modalTambahPotonganDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title">Tambah Potongan Pinjaman - <?php echo strtoupper($products['nama'])?></h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo BASEURL.'Keuangan/potonganpinjamankaryawanhariansave'?>">
          <input type="hidden" name="redirect_to" value="rincian">
          <input type="hidden" name="idkaryawan" value="<?php echo $products['idkaryawan']?>">
          <input type="hidden" name="listpinjaman" value="<?php echo $products['id']?>">
          <div class="form-group">
            <label>Tanggal Potongan</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required="required">
          </div>
          <div class="form-group">
            <label>Sisa Pinjaman Saat Ini</label>
            <input type="text" class="form-control" value="Rp <?php echo number_format($products['totalpinjaman'] - $products['totalpotongan'])?>" readonly>
          </div>
          <div class="form-group">
            <label>Jumlah Potongan</label>
            <input type="number" name="totalpotongan" class="form-control" max="<?php echo ($products['totalpinjaman'] - $products['totalpotongan'])?>" required="required">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" required="required" name="keterangan"></textarea>
          </div>
          <button type="submit" class="btn btn-success">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>

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

<div class="row" style="margin-bottom: 10px;">
  <div class="col-md-8">
    <h3 class="card-title">Rincian Pinjaman <?php echo $products['nama']?></h3>
  </div>
  <div class="col-md-4 text-right">
    <?php if(($products['totalpinjaman'] - $products['totalpotongan']) > 0){ ?>
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPotonganDetail"><i class="fa fa-plus"></i> Tambah Potongan</button>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-hover">
      <thead>
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
                <a href="<?php echo BASEURL.'Keuangan/hapus_rincian_pinjaman_harian/'.$p['id']?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
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
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><b>Total Pinjaman</b></td>
          <td align="right"><b><?php echo format_angka($products['totalpinjaman'])?></b></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><b>Sisa Pinjaman</b></td>
          <td align="right"><b><?php echo format_angka($products['totalpinjaman']-$total)?></b></td>
          <td></td>
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

