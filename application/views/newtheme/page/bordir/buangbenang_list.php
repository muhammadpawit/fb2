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
                      <?php if(aksesedit()==1){?>
                        <a href="javascript:void(0)" onclick="edit_modal('<?php echo $p['edit']?>')" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                      <?php } ?>

                      <?php if(akseshapus()==1){?>
                        <a href="<?php echo $p['hapus']?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></a>
                      <?php } ?>
                    </td>
                  </tr>

                <?php }?>
              </tbody>
            </table>
  </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 90%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Edit Buang Benang Bordir</h4>
      </div>
      <div class="modal-body" id="modal-body-edit">
        ...
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function edit_modal(url){
        var modal_url = url.replace('buangbenangedit', 'buangbenangedit_modal');
        $('#modal-body-edit').load(modal_url, function(){
            $('#modal-edit').modal('show');
            $('#modal-body-edit a.btn-danger').attr('href', 'javascript:void(0)').attr('data-dismiss', 'modal').removeAttr('onclick');
            
            $('#modal-body-edit form').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();
                var btn = form.find('button[type="submit"], .btn-primary');
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

    function filtertglonly(){
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      location = "<?php echo BASEURL?>Bordir/buangbenang?&tanggal1="+tgl1+"&tanggal2="+tgl2;
    }
</script>