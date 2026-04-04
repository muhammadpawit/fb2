
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
                   <form action="<?php echo BASEURL.'finishing/kirimgudangforProd' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>No Faktur</label>
                                <input type="text" class="form-control" name="noFaktur" value="<?php echo generateReferenceNumber(); ?>" >
                            </div>
                            <div class="form-group col-2">
                                <label>Nama Penerima</label>
                                <input type="text" class="form-control" name="namaPenerima" value="Gudang Forboys"  required>
                            </div>
                            <div class="form-group col-2">
                                <label>Tujuan </label>
                                <input type="text" class="form-control"  name="tujuanItem" value="Tanah Abang">
                            </div>
                            <div class="form-group col-2">
                                <label>Tanggal</label>
                                <input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d')?>"  name="tanggalKirim">
                            </div>
                            <div class="form-group col-2">
                                <label>Proggress</label>
                                <select class="form-control selectpicker" name="proggress" title="Pilih PO" >
                                    <?php foreach ($proggres as $key => $prog): ?>
                                        <option value="<?php echo $prog['id_proggresion_po'] ?>" <?php echo $prog['id_proggresion_po']==11?'selected':''; ?>><?php echo $prog['nama_progress'] ?></option>   
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label>Po Susulan</label>
                                <select name="susulan" class="form-control" id="susulan">
                                    <option value="1">Ya</option>
                                    <option value="2" selected>Bukan</option>
                                </select>
                            </div>
                            
                            
                            <table class="table table-bordered" id="addkirimgudang">
                                <tr>
                                    <th>Nama PO</th>
                                    <th>Artikel</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah Pcs(PO)</th>
                                    <th>Jumlah (Rp)</th>
                                    <th>Keterangan</th>
                                    <th>Rincian</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm addkirimgudang"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>                             <hr>
                         </div>
 
                         <button type="submit" class="btn btn-info">Simpan</button>
                         <a href="<?php echo BASEURL.'Finishing/pengirimangudang';?>" class="btn btn-danger text-white">Batal</a>
                    </form>
 
                 </div>
 
             </div>
 
         </div>
         <!-- end row -->
 
     </div> <!-- container -->
 
 <!-- Modal Rincian Size -->
 <div class="modal fade" id="modal-rincian-size" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Rincian Size Penerimaan</h4>
             </div>
             <div class="modal-body">
                 <div id="rincian-size-content"></div>
             </div>
         </div>
     </div>
 </div>
  
  <script type="text/javascript">
 $(document).ready(function(){
     $(document).on('click', '.addkirimgudang', function(){
         var html = '';
         html += '<tr>';
         html += '<td><select type="text" class="form-control selectpicker kodepo" name="kodepo[]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($rincian as $key => $po) { ?><option value="<?php echo $po['id_produksi_po'] ?>" data-item="<?php echo $po['id_produksi_po'] ?>"><?php echo $po['kode_po'] ?></option><?php } ?></select></td>';
         html += '<td><input type="text" class="form-control artikel" name="artikel[]"  required value="" readonly></td>';
         html += '<td><input type="number" class="form-control hargasatuan"  name="hargasatuan[]" required value="" readonly></td>';
         html += '<td><input type="number" class="form-control jumlah" name="jumlahRinci[]" required></td>';
         html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required></td>';
         html += '<td><input type="text" class="form-control keterangan" name="keterangan[]" required ></td>';
         html += '<td><button type="button" class="btn btn-info btn-sm btn-lihat-rincian" disabled><i class="fa fa-eye"></i></button></td>';
         html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
         $('#addkirimgudang').append(html);
         //$('.selectpicker').selectpicker('refresh');
         $('.selectpicker').select2();
      });
 
     $(document).on('click', '.remove', function(){
         $(this).closest('tr').remove();
     });
     
     $(document).on('change', '.selectpicker', function(e){
         var dataItem = $(this).find(':selected').data('item');
         var dai = $(this).closest('tr');
         var jumlahItem = $('#piecesPo').val();
         $.get( "<?php echo BASEURL.'finishing/kirimgudangsendRincinan' ?>", { kodepo: dataItem } )
           .done(function( data ) {
             var obj = JSON.parse(data);
             console.log(obj);
             if(obj.harga_satuan==0){
                 alert("PO Belum dibuat HPP. Silahkan buat HPPnya terlebih dahulu."); 
                  dai.remove();
                 return  false;
             }
             dai.find(".artikel").val(obj.kode_artikel);
             dai.find(".hargasatuan").val(Math.round(obj.harga_satuan));
             dai.find(".jumlah").val(obj.jumlah_pcs_po);
             dai.find(".jumlahRp").val(obj.jumlah_pcs_po * Math.round(obj.harga_satuan));
             dai.find(".keterangan").val(obj.jumlah_item);
             
             // Simpan data rincian di button
             dai.find(".btn-lihat-rincian").prop('disabled', false).data('rincian', obj.rincian_size);
         });
     });
 
     $(document).on('click', '.btn-lihat-rincian', function() {
         var rincian = $(this).data('rincian');
         var html = '<table class="table table-bordered">';
         html += '<thead><tr class="bg-light"><th>Size</th><th>Lusin</th><th>Pcs</th></tr></thead><tbody>';
         if(rincian && rincian.length > 0) {
             $.each(rincian, function(i, v) {
                 html += '<tr><td>' + v.rincian_size + '</td><td>' + v.lusin + '</td><td>' + v.piece + '</td></tr>';
             });
         } else {
             html += '<tr><td colspan="3" class="text-center">Tidak ada rincian ditemukan</td></tr>';
         }
         html += '</tbody></table>';
         $('#rincian-size-content').html(html);
         $('#modal-rincian-size').modal('show');
     });
 });

 </script>
