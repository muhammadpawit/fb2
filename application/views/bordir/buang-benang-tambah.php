<!-- Start Page content -->
<!-- Modal -->
<div id="myModalK" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Karyawan Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $savepekerja?>">
          <div class="form-group">
            <label>Nama </label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<div class="content">

    <div class="container-fluid">



        <div class="row">

            <div class="col-md-12">



                <div class="card-box">

                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                    <?php } ?>

                    <div class="row">

                        <div class="col-6">


                        </div>

                        <div class="col-6 text-right">

<!--                             <a href="<?php echo BASEURL.'bordir/harianbuangbenangdetail/'.$project['kode_po'] ?>" class="btn btn-info" target="_blank">Detail Buang Benang</a> -->

                        </div>

                    </div>

                    <hr>

                   <form action="<?php echo BASEURL.'bordir/harianbuangbenangAct' ?>" method="POST">

                            

                        <div class="row">

                            

                            <div class="form-group col-md-3">

                                <label>Nama Pekerja</label>

                                <select class="form-control select2bs4" name="namaPekerja" required data-live-search="true">
                                    <option value="">Mohon dipilih</option>
                                    <?php foreach ($karyawan as $key => $per): ?>

                                        <option value="<?php echo $per['id_master_karyawan_benang'] ?>"><?php echo $per['nama_karyawan_benang'] ?></option>

                                    <?php endforeach ?>

                                </select>


                            </div>      

                            <div class="form-group col-md-3">
                                    <br>
                                    <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#myModalK">Tambah Nama</button>
                                </div>                      

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="text" name="tgl" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="col-12">

                                <table class="table table-bordered" id="bbbordir">

                                    <tr>

                                        <!-- <th>Tanggal</th> -->
                                        <th>Nama PO</th>

                                        <th>Bagian Buang</th>

                                        <th>Size</th>

                                        <th>Qty</th>

                                        <th>Harga</th>

                                        <th>Keterangan</th>

                                        <th><button type="button" name="addbbbordir" class="btn btn-success btn-sm addbbbordir"><i class="fa fa-plus"></i></button></th>

                                    </tr>

                                </table>

                               

                            </div>

                            <hr>

                        </div>



                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Kembali</a>

                   </form>



                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->

 <script type="text/javascript">

$(document).ready(function(){

$( "#perkalianTarif" ).keyup(function() {

    var total = $('#totalStich').val();

    var perkali = $('#perkalianTarif').val();

    var tarif = total * perkali;

    $('#tarif').val(tarif);

});

$(document).on('click', '.addbbbordir', function(){

    var html = '';

    html += '<tr>';

    //html += '<td><input type="date" class="form-control" name="tanggal[]" step=0.01 required></td>';

    html += '<td width="200"><select name="namaPO[]" class="form-control select2bs4" data-live-search="true"><?php foreach($po as $p){?><option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option><?php } ?></select></td>';

    html += '<td><input type="text" class="form-control selectpicker" name="bagianBuang[]" required></td>';

    html += '<td><input type="text" class="form-control" name="size[]" ></td>';

    html += '<td><input type="number" class="form-control" name="qty[]" required></td>';

    html += '<td><input type="number" class="form-control" name="harga[]" step=0.01 required></td>';

    html += '<td><input type="text" class="form-control" name="keterangan[]" step=0.01 required></td>';



    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

   

    $('#bbbordir').append(html);
    //$('.select2bs4').select2();
    $('.select2bs4').selectpicker('refresh');

 });



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});

 </script>