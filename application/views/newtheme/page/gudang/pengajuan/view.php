<div class="row">
  <div class="col-md-12">
    <div class="form-group">
                          <p class="text-muted font-14 m-b-30">

                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>  
    </div>
  </div>
</div>
<div class="row">
      <div class="col-md-3">
          <label>Tanggal Awal</label>
          <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
      </div>
                <div class="col-md-3">
                  <label>Tanggal Akhir</label>
                  <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
                </div>
                <div class="col-md-3">
                    <label>Divisi / Cabang</label>
                    <select name="cat" id="cat" class="form-control select2bs4">
                        <option value="*">Semua</option>
                        <option value="3" <?php echo $cat==3?'selected':'';?>>Konveksi</option>
                        <option value="2" <?php echo $cat==2?'selected':'';?>>Bordir</option>
                        <option value="1" <?php echo $cat==1?'selected':'';?>>Sablon</option>
                         <option value="4" <?php echo $cat==4?'selected':'';?>>Sukabumi</option>
                    </select>
                </div>
                <div class="col-md-3">
                  <label>Action</label><br>
                  <button onclick="filter()" class="btn btn-info ">Filter</button>
                  <span><a href="<?php echo $tambah?>" class="btn  btn-info">Tambah</a></span>
                  <button onclick="excel()" class="btn btn-info ">Excel</button>
                </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="table-responsive">
              <table class="table table-bordered nosearch">

                        <thead>

                        <tr>


                            <th>Tanggal</th>

                            <th>Divisi / Cabang</th>

                            <th>Cash</th>

                            <th>Transfer</th>

                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Ttd</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Waktu dibuat</th>

                        </tr>

                        </thead>

                        <tbody>

                                <?php foreach ($harian as $key => $us): ?>

                            <tr>


                                <td><?php echo date('d F Y',strtotime($us['tanggal'])) ?></td>

                                <td>
                                  <?php 
                                  
                                  if ($us['kategori'] == 1) {
                                   echo "Sablon";
                                  }else if($us['kategori'] == 2) { 
                                    echo "Bordir"; 
                                  } else if($us['kategori'] == 3) {
                                    echo "Konveksi";
                                  }else if($us['kategori'] == 4) {
                                    echo "Sukabumi";
                                  }

                                  if(!empty($us['from_mingguan'])){
                                    echo ' Mingguan';
                                  }else{
                                    echo ' Harian';
                                  }
                                  ?>
                                
                              </td>

                                <td><?php echo number_format($us['cash'])?></td>
                                <td><?php echo number_format($us['transfer'])?></td>
                                <td><?php echo number_format($us['cash']+$us['transfer'])?></td>
                                <td>
                                  <?php echo strtolower($us['keterangan'])?>
                                </td>
                                <td>

                                <?php 
                                    if($us['status']==0){
                                        echo '<span class="badge bg-navy color-palette text-white">Diajukan</span>';
                                    }else if($us['status']==1){
                                        echo '<span class="badge bg-green color-palette text-white">Disetujui</span>';
                                    }else if($us['status']==3){
                                        echo '<span class="badge bg-red color-palette text-white">Revisi</span>';
                                    }else{
                                        echo '<span class="badge bg-red color-palette text-white">Ditolak</span>';
                                    }

                                ?>        

                                </td>
                                <td>
                                  <?php if($setujui==1){?>
                                      <a href="#" class="btn btn-primary text-white ttdDigital" data-id="<?php echo $us['id']; ?>" data-toggle="modal" data-target="#detailModalTtd"><i class="fa fa-pencil"></i></a>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if($us['kategori']==4){ ?>
                                      <a href="<?php echo BASEURL.'Gudang/pengajuancetak/'.$us['id']; ?>?&sukabumiforjkt=true" class="btn btn-info  text-white">Lihat</a>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>?&acc=true?&sukabumiforjkt=true" class="btn btn-warning  text-white">Edit</a>
                                    <?php }else{ ?>
                                      <a href="<?php echo BASEURL.'Gudang/pengajuancetak/'.$us['id']; ?>" class="btn btn-info  text-white">Lihat</a>
                                    <?php } ?>

                                    <?php if($setujui==1){?>
                                      <!-- <a href="#" class="btn btn-primary text-white modals" data-id="<?php echo $us['id']; ?>" data-toggle="modal" data-target="#detailModal">Ttd Digital</a> -->
                                    <?php } ?>
                                </td>
                                
                                <td>
                                  <?php if($us['status']==1 && !empty($us['from_mingguan']) OR $us['from_alat']){?>
                                    <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>?&acc=true" class="btn btn-warning  text-white">Edit</a>
                                    <?php }?>

                                    <?php if($us['status']==1){?>
                                    <!-- <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>?&acc=true" class="btn btn-warning  text-white">Edit</a> -->
                                    <?php if(akseshapus()==1){?>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanhapus/'.$us['id']; ?>" onclick="return confirm('Apakah yakin akan dibatalkan ?')" class="btn btn-danger  text-white">Batalkan</a>
                                    <?php } ?>
                                    <?php }?>
                                </td>
                                <td>
                                  <?php if($us['status']==0 OR $us['status']==3){?>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>" class="btn btn-warning  text-white">Edit</a>
                                    <?php } ?>
                                </td>                                
                                <td>
                                  <?php if($setujui==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/setujuiajuan/'.$us['id']; ?>" class="btn btn-success  text-white">Setujui</a>
                                    <?php } ?>

                                    <?php if($setujui==1){?>
                                      <a href="#" class="btn btn-primary text-white modals" data-id="<?php echo $us['id']; ?>" data-toggle="modal" data-target="#detailModal">Realisasi Penerimaan</a>
                                    <?php } ?>
                                </td>
                                <td>
                                  <?php if($setujui==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/pengajuandetail/'.$us['id']; ?>" class="btn btn-success  text-white">Komentar</a>
                                    <?php } ?>
                                </td>
                                <td>
                                  <?php if(akseshapus()==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanhapus/'.$us['id']; ?>" onclick="return confirm('Apakah yakin akan dibatalkan ?')" class="btn btn-danger  text-white">Hapus</a>
                                  <?php } ?>
                                </td>
                                <td><?php echo $us['dibuat']==null?'':date('d/m/Y H:i:s',strtotime($us['dibuat'])) ?></td>

                            </tr>

                                <?php endforeach ?>

                        </tbody>

                    </table>
            </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Data akan di-load di sini -->
                 <form action="">
                  <input type="text" id="idajuan">
                 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detailModalTtd" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Persetujuan Digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="signature" style="width: 100%; height: 300px; border: 1px solid #000;"></div>
            </div>
            <div class="modal-footer">
            
            <button id="clear_signature">Clear</button>
            <button id="save_signature">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="row" hidden>
  <div class="col-md-6">
    <div id="signatures"></div>
 
  </div>

  <div class="col-md-6">
  <button id="undo_signature">Undo</button>
  <button id="clear_signature">Clear</button>
  <button id="save_signature">Save Signature</button>
  </div>
</div>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
  $(document).ready(function() {
    $("#signature").jSignature();

      $('#clear_signature').click(function() {
           $("#signature").jSignature("reset");
       });
       $('#save_signature').click(function() {
           var datapair = $("#signature").jSignature("getData", "image");
           var imgData = datapair[1];
           $.ajax({
               url: "<?= BASEURL ?>Gudang/ttdsave",
               type: "POST",
               data: {image_data: imgData},
               success: function(response) {
                   alert('Signature saved successfully!');
               }
           });
        });
      
        $('.modals').on('click', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          $('#idajuan').val(id); // Masukkan ID ke input dalam modal

          // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
          // Contoh logika AJAX untuk mengambil data:
          $.ajax({
              url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetail', // Sesuaikan URL untuk mengambil data
              method: 'GET',
              data: { id: id },
              success: function(response) {
                  // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                  $('#detailModal .modal-body').html(response);
              },
              error: function() {
                  $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
              }
          });
        });

        $('.ttdDigital').on('click', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          $('#idajuan').val(id); // Masukkan ID ke input dalam modal

          // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
          // Contoh logika AJAX untuk mengambil data:
          $.ajax({
              url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetailTtd', // Sesuaikan URL untuk mengambil data
              method: 'GET',
              data: { id: id },
              success: function(response) {
                  // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                  // $('#detailModalTtd .modal-body').append(response);
              },
              error: function() {
                  $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
              }
          });
        });
});

</script>
<script type="text/javascript">
  
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }

  function excel(){
    var url='?excel=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }
</script>    