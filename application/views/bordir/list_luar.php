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
    <div class="col-md-1">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" value="<?php echo $tanggalMulai?>" class="form-control" name="tanggalMulai">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control" name="tanggalEnd" value="<?php echo $tanggalEnd?>">
        </div>
    </div>
    <div class="col-md-2">
        <label>Nama PO</label>
        <select name="namaPo" class="form-control autopoluar" data-live-search="true">
            <option value="*">Semua</option>
        </select>
    </div>
    <div class="col-md-2">
        <label>Pemilik PO</label>
        <select name="pemilik" class="form-control select2bs4" required="required">
              <option value="*">Pilih</option>
              <?php foreach($pemilik as $p){?>
                <option value="<?php echo $p['id']?>" <?php echo $milik==$p['id']?'selected':'';?>><?php echo $p['nama']?></option>
              <?php } ?>
        </select>
    </div>
    <div class="col-md-2">
        <label>Nama Operator</label>
        <select name="oper" class="form-control select2bs4" data-live-search="true">
            <option value="*">Semua</option>
            <?php foreach($opt as $o){?>
                <option value="<?php echo $o['id_master_karyawan_bordir']?>"><?php echo $o['nama_karyawan_bordir']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Aksi</label><br>
        <a onclick="filter()" class="btn btn-info btn-sm text-white">Filter</a>
        <a onclick="exceldalam()" class="btn btn-info btn-sm text-white">Excel</a>
        <a href="<?php echo $tambah?>" class="btn btn-info btn-sm">Tambah</a>
        <a href="<?php echo $koreksi_gaji_bordir?>" class="btn btn-warning btn-sm">Koreksi Gaji Operator</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                    <table class="table table-bordered nosearch">
                        <thead>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Nama Operator</th>
                            <th>No Mesin</th>
                            <th>Nama Po</th>
                            <th>Pemilik</th>
                            <th>Posisi Bordir</th>
                            <th>Size</th>
                            <th>Stich</th>
                            <th>Qty</th>
                            <th>Total Stich</th>
                            <th>Perkalian</th>
                            <th>Tarif</th>
                            <th>Gaji</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($bordir)){?>
                        <?php foreach ($bordir as $bod): ?>
                        <tr>
                            <td><?php echo formatTanggalIndo($bod['created_date']) ?></td>
                            <td><?php echo $bod['operator'] ?></td>
                            <td><?php echo $bod['mesin'] ?></td>
                            <td><?php echo $bod['nama_po'] ?></td>
                            <td><?php echo $bod['pemilik'] ?></td>
                            <td><?php echo $bod['bagian_bordir'] ?></td>
                            <td><?php echo $bod['size'] ?></td>
                            <td><?php echo $bod['stich'] ?></td>
                            <td><?php echo $bod['jumlah_naik_mesin'] ?></td>
                            <td><?php echo ($bod['total_stich']) ?></td>
                            <td><?php echo ($bod['perkalian_tarif']) ?></td>
                            <td><?php echo ($bod['total_tarif']) ?></td>
                            <td><?php echo number_format($bod['gaji']) ?></td>
                            <td class="right">
                                <?php foreach ($bod['action'] as $action) { ?>
                                    <?php if(strtolower($action['text'])=='edit'){ ?>
                                        <a href="javascript:void(0)" onclick="edit_modal('<?php echo $action['href']; ?>')" class="badge waves-light waves-effect <?php echo $action['bg']; ?>"><?php echo $action['text']; ?></a>&nbsp;&nbsp;
                                    <?php } else { ?>
                                        <a href="<?php echo $action['href']; ?>" class="badge  waves-light waves-effect <?php echo $action['bg']; ?>"
                                        <?php if(strtolower($action['text'])=='hapus'){ ?> onclick="return confirm('Apakah yakin akan menghapus data ini ?') " <?php } ?>><?php echo $action['text']; ?></a>&nbsp;&nbsp;
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php } ?>
                        </tbody>
                    </table>
    </div>
</div>

<script type="text/javascript">

    function filter(){
        url='<?php echo $url;?>';
        
        var filter_date_start = $('input[name=\'tanggalMulai\']').val();

        if (filter_date_start) {
            url += '&tanggalMulai=' + encodeURIComponent(filter_date_start);
        }

      var filter_date_end = $('input[name=\'tanggalEnd\']').val();

        if (filter_date_end) {
            url += '&tanggalEnd=' + encodeURIComponent(filter_date_end);
        }

        var filter_status = $('select[name=\'namaPo\']').val();

            if (filter_status != '*') {
                url += '&namaPo=' + encodeURIComponent(filter_status);
            }

        var pemilik = $('select[name=\'pemilik\']').val();

            if (pemilik != '*') {
                url += '&pemilik=' + encodeURIComponent(pemilik);
            }

        var opt = $('select[name=\'oper\']').val();

        if (opt != '*') {
            url += '&oper=' + encodeURIComponent(opt);
        }
        location =url;
        
    }


    function exceldalam(){
        url='<?php echo $url;?>&excel=1';
        
        var filter_date_start = $('input[name=\'tanggalMulai\']').val();

        if (filter_date_start) {
            url += '&tanggalMulai=' + encodeURIComponent(filter_date_start);
        }

      var filter_date_end = $('input[name=\'tanggalEnd\']').val();

        if (filter_date_end) {
            url += '&tanggalEnd=' + encodeURIComponent(filter_date_end);
        }

    var filter_status = $('select[name=\'namaPo\']').val();

        if (filter_status != '*') {
            url += '&namaPo=' + encodeURIComponent(filter_status);
        }

        var pemilik = $('select[name=\'pemilik\']').val();

            if (pemilik != '*') {
                url += '&pemilik=' + encodeURIComponent(pemilik);
            }

        var opt = $('select[name=\'oper\']').val();

        if (opt != '*') {
            url += '&oper=' + encodeURIComponent(opt);
        }
        location =url;
        
    }

    
        $(document).ready(function() {
            
            //$('.select2').select2();

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                "searching": false,
                //buttons: ['copy', 'excel', 'pdf']
            });
            if ($.isFunction(table.buttons)) {
                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            }
        } );

    </script>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 90%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Edit Harian Mesin Bordir Luar</h4>
      </div>
      <div class="modal-body" id="modal-body-edit">
        ...
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function edit_modal(url){
        var modal_url = url.replace('mesinharian_edit_luar', 'mesinharian_edit_modal_luar');
        $('#modal-body-edit').load(modal_url, function(){
            $('#modal-edit').modal('show');
            $('#modal-body-edit a.btn-danger').attr('href', 'javascript:void(0)').attr('data-dismiss', 'modal').removeAttr('onclick');
            
            if($.isFunction($.fn.datepicker)) {
                $('.datepicker').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                });
            }

            if($.isFunction($.fn.select2)) {
                $('.select2bs4').select2();
            }

            $('#modal-body-edit form').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();
                var btn = form.find('button[type="submit"], .btn-success');
                var oldText = btn.html();

                btn.html('<i class="fa fa-spinner fa-spin"></i> Memproses...').attr('disabled', true);

                $.post(url, data, function(response){
                    $('#modal-edit').modal('hide');
                    
                    Sweetalert2({
                      title: 'Data berhasil disimpan',
                      type: 'success',
                      timer: 2000,
                      showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    }, function(dismiss) {
                        if (dismiss === 'timer') {
                            location.reload();
                        }
                    });

                }).fail(function(){
                    Sweetalert2({
                      title: 'Oops...',
                      text: 'Gagal menyimpan data. Silakan coba lagi.',
                      type: 'error'
                    });
                    btn.html(oldText).attr('disabled', false);
                });
            });
        });
    }
</script>