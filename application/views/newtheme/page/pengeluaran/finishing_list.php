<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
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
            <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
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
        <table class="table table-bordered table-striped" id="datatable">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Nominal (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; $total=0; foreach($products as $p){?>
                <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo formatTanggalIndo($p['tanggal'])?></td>
                    <td><?php echo $p['keterangan']?></td>
                    <td><?php echo number_format($p['nominal'])?></td>
                    <td>
                        <a href="<?php echo BASEURL?>Pengeluaran/finishing_edit/<?php echo $p['id']?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                        <a href="<?php echo BASEURL?>Pengeluaran/finishing_delete/<?php echo $p['id']?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah yakin akan menghapus data ini ?')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php $total += $p['nominal']; }?>
            </tbody>
            <tfoot>
                <tr style="background:#e8eaf6; font-weight:800; font-size:13px;">
                    <td colspan="3" class="text-right">GRAND TOTAL</td>
                    <td colspan="2"><b>Rp <?php echo number_format($total)?></b></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
  function filtertglonly(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }
</script>
