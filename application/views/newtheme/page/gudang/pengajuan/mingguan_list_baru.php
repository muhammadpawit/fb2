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
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
              <div class="form-group">
                <label>Bagian</label>
                <select name="jenis" class="form-control select2bs4" required="required">
                  <option value="">Pilih</option>
                  <option value="1" <?php echo $cat==1?'selected':''; ?>>Konveksi</option>
                  <option value="2" <?php echo $cat==2?'selected':''; ?>>Bordir</option>
                  <option value="3" <?php echo $cat==3?'selected':''; ?>>Sablon</option>
                </select>
              </div>
            </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filterwithbagian()">Filter</button>
      <button class="btn btn-info btn-sm" onclick="excelnya()">Excel</button>
      <!-- <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a> -->
      <button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#tambahModal">Tambah</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Lapisan</th>
                  <!-- <th>Jumlah Dz </th>
                  <th>Jumlah Per Baju </th>
                  <th>Jumlah Per Cons</th>
                  <th>Rincian</th> -->
                  <th>Kebutuhan</th>
                  <th>Stok</th>
                  <th>Ajuan</th>
                  <!-- <th>Rincian</th> -->
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1;?>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtolower($p['nama_produk'])?></td>
                      <td><?php echo strtolower($p['jumlah_lapisan'])?></td>
                      <!-- <td><?php echo ($p['jumlah_dz'])?></td>
                      <td><?php echo $p['jumlah_per_baju']?></td>
                      <td><?php echo $p['jumlah_per_cons']?></td>
                      <td><?php echo $p['rincian']?></td> -->
                      <td><?php echo strtolower($p['kebutuhan'])?></td>
                      <td><?php echo strtolower($p['stok'])?></td>
                      <td><?php echo strtolower($p['ajuan'])?></td>
                      <!-- <td><?php echo strtolower($p['rincian_ajuan'])?></td> -->
                      <td>
                        <a href="<?php echo BASEURL?>Ajuankemejabaru/delete/<?php echo $p['id']?>" onclick="return confirm('Apakah yakin?')"><i class="fa fa-trash text-red"></i></a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>
<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah Ajuan Kemeja Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="tambahForm" method="POST" action="<?php echo $tambah_action; ?>">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d')?>" name="tanggal" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Barang</label>
                <!-- <input type="text" class="form-control" name="nama_barang" required> -->
                 <select name="nama_barang" id="nama_barang" class="form-control select2bs4 prod" style="width: 100%;">
                  <option value="">Pilih</option>
                  <?php foreach($item as $i){?>
                    <option value="<?php echo $i['product_id']?>" data-item="<?php echo $i['product_id']?>"><?php echo $i['nama']?></option>
                  <?php } ?>
                 </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jumlah Lapisan</label>
                <input type="number" class="form-control" name="jumlah_lapisan" id="jumlah_lapisan" value="0" onblur="kebutuhans()" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jumlah Dz</label>
                <input type="number" class="form-control" name="jumlah_dz" id="jumlah_dz" value="0" onblur="kebutuhans()" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jumlah Per Baju</label>
                <input type="number" class="form-control" name="jumlah_per_baju" id="jumlah_per_baju" value="0" onblur="kebutuhans()" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jumlah Per Cons</label>
                <input type="number" class="form-control" name="jumlah_per_cons" id="jumlah_per_cons" value="0" onblur="kebutuhans()" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Rincian</label>
                <textarea class="form-control" name="rincian" required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kebutuhan</label>
                <input type="number" class="form-control" name="kebutuhan" id="kebutuhan" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Stok</label>
                <input type="number" class="form-control stok" name="stok" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Ajuan</label>
                <input type="number" class="form-control" name="ajuan" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Rincian Ajuan</label>
                <textarea class="form-control" name="rincian_ajuan" required></textarea>
              </div>
            </div>
            <!-- <div class="col-md-6">
              
            </div>
            <div class="col-md-6">
              
            </div>
            <div class="col-md-6">
              
            </div> -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="tambahForm">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

         $(document).on('change', '#nama_barang', function(e){
            var dataItem = $(this).find(':selected').data('item');
            $.get( "<?php echo BASEURL.'Ajuankemejabaru/cariproduct' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                if(obj.stock==0){
                    $(".stok").val(obj.stock);
                    $(".stok").attr('readonly',true);
                }else{
                    $(".stok").val(obj.stock);
                    $(".stok").attr('readonly',true);
                }
            });
        });

        function kebutuhans(){
          var jumlah_lapisan  = $("#jumlah_lapisan").val();
          var jumlah_dz       = $("#jumlah_dz").val();
          var jumlah_per_baju  = $("#jumlah_per_baju").val();
          var jumlah_per_cons  = $("#jumlah_per_cons").val();
          var total  = jumlah_lapisan*jumlah_dz / jumlah_per_baju*jumlah_per_cons;
          
          $("#kebutuhan").val(total.toFixed(1));
        }
  
  function filterwithbagian(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

     var filter_status = $('select[name=\'jenis\']').val();

        if (filter_status != '*') {
            url += '&cat=' + encodeURIComponent(filter_status);
        }

      //console.log(filter_status);

    location =url;
  }

  function excelnya(){
    var url='';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

     var filter_status = $('select[name=\'jenis\']').val();

        if (filter_status != '*') {
            url += '&cat=' + encodeURIComponent(filter_status);
        }

      //console.log(filter_status);

    location =url;
  }
</script>