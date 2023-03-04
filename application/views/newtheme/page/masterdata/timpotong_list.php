<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Tim Potong Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>" id="formId">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required="required">
          </div>
          <br>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>  

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
      <button type="button" class="btn btn-info btn-sm full" data-toggle="modal" data-target="#myModal" onclick="clears()"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtolower($p['nama'])?></td>
                      <td>
                      <button type="button" class="btn btn-warning btn-sm full" data-toggle="modal" data-target="#myModal" onclick="detail(<?php echo $p['id']?>)"><i class="fa fa-pencil"></i>&nbsp;</button>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>

  <script>
    function detail(id){
      //alert(id);
      var url = '<?php echo BASEURL?>Masterdata/detailtimpot';
      var edit = '<?php echo BASEURL?>Masterdata/edittimpotong';
      data = {
        id:id,
      }
      $.ajax({     
          type: "POST",
          url: url,
          data: data,
          success: function (data) {
            var obj = JSON.parse(data);
              $("#id").val(obj.id);
              $("#nama").val(obj.nama);   
              $('#formId').attr('action', edit);
              $(".modal-title").html("Edit Nama Tim Potong");
          },
      });
    }

    function clears(){
      $("#id").hide();
      $("#nama").val('');   
      $('#formId').attr('action', '<?php echo $action ?>');
      $(".modal-title").html("Tambah Tim Potong");
    }
  </script>