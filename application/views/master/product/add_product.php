<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<div class="content">
    <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card-box table-responsive">
          <h4 class="m-t-0 header-title">Tambah Produk</h4>
          <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a onclick="cancel()" class="btn btn-danger">Cancel</a>
                           <a onclick="simpan()" class="btn btn-primary">Simpan</a>
                       </div>
                   </div>
                   <p class="text-muted font-14 m-b-30">

                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>
                   <table class="table">
                      <form method="post" action="<?php echo $action?>">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>Nama Item</label>
                              <input type="text" name="nama" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                              <label>Warna</label>
                              <input type="text" name="warna_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Ukuran Item</label>
                              <input type="text" name="ukuran_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Satuan Ukuran Item</label>
                              <select name="satuan_ukuran_item" class="form-control">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Satuan</label>
                              <select name="satuan" class="form-control">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Minimal Stok</label>
                              <input type="text" name="minstok" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Resiko</label>
                              <input type="text" name="resiko" class="form-control">
                            </div>
                          </div>
                        </div>
                      </form>
                   </table>
        </div>
      </div>
    </div>
  </div>
  
</div>

<script type="text/javascript">
  function simpan(){
    const c=confirm("Apakah yakin akan menyimpan?");
    if(c==true){
      $("form").submit();
    }else{
      return false;
    }
    
  }
  function cancel(){
    const url='<?php echo $url?>';
    window.location.replace(url);
  }
</script>

<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">