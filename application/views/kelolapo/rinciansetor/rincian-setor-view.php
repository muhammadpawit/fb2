 <style>   
    .loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        min-height: 300px;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border-radius: 6px;
    }
    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .loading-text {
        font-weight: bold;
        color: #3498db;
    }
</style>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Cari PO</label>
            <select name="kode_po" id="kode_po" class="form-control autopoid" data-live-search="true">
                <option value="*">Pilih</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Cari CMT</label>
            <select name="cmt" id="cmt" class="form-control select2" data-live-search="true">
                <option value="*">Pilih</option>
                <?php foreach($cmt as $c): ?>
                    <option value="<?php echo $c['id_cmt'] ?>"><?php echo $c['cmt_name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button class="btn btn-primary btn-sm" onclick="filter()">Cari</button>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-md-12">
          <table class="table table-bordered yessearch">
                         <thead>
                         <tr>
                             <th>NAMA PO</th>
                             <th>NAMA CMT & KAT CMT</th>
                             <th>PROGRESS</th>
                             <th>STATUS</th>
                             <th>Qty (Pcs)</th>
                             <th>CREATED</th>
                             <th>ACTION</th>
                         </tr>
                         </thead>
                         <tbody>
                                 <?php foreach ($rincian as $key => $sat): ?>
                             <tr>
                                 <td><?php echo $sat['kode_po'] ?></td>
                                 <td><?php echo $sat['nama_cmt'].' ('.$sat['kategori_cmt'].')' ?></td>
                                 <td><?php echo $sat['progress'] ?></td>
                                 <td style="<?php echo (empty($sat['rincianSetor'])?"background:#94121296;color:white":"background:#17941296;color:white") ?>"><?php echo (empty($sat['rincianSetor'])?"Belum Diproses":"Sudah Diproses") ?></td>
                                 <td><?php echo $sat['qty_tot_pcs'] ?></td>
                                 <td><?php echo $sat['created_date'] ?></td>
                                 <td>
                                     
                                     <?php if(!empty($sat['rincianSetor'])){ ?>
                                        <button type="button" class="btn btn-success btn-sm btn-detail" data-id="<?php echo $sat['idpo'] ?>"><i class="fa fa-eye"> Detail</i></button>
                                        <button type="button" class="btn btn-warning btn-sm btn-susulan" data-id="<?php echo $sat['idpo'] ?>"><i class="fa fa-pencil"> Susulan</i></button>
                                     <?php }else{ ?>
                                        <button type="button" class="btn btn-primary btn-sm btn-proses" data-idpo="<?php echo $sat['idpo'] ?>" data-kodepo="<?php echo $sat['kode_po'] ?>" data-idklo="<?php echo $sat['id_kelolapo_kirim_setor'] ?>"><i class="fa fa-pencil"> Proses</i></button>
                                     <?php } ?>
                                     <?php if(aksesedit()==1){?>
                                        <?php if(!empty($sat['rincianSetor'])){ ?>
                                            <button type="button" class="btn btn-info btn-sm btn-edit" data-id="<?php echo $sat['idpo'] ?>"><i class="fa fa-pencil"> Edit</i></button>
                                        <?php } ?>
                                     <?php } ?>

                                         <?php if(akseshapus()==1){?>
                                             <?php if(!empty($sat['rincianSetor'])){ ?>
                                                 <a href="<?php echo BASEURL.'finishing/editsetoran_hapus/'.$sat['idpo'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" onclick="return confirm('Apakah yakin akan mereset data ini ? Seluruh data penerimaan akan terhapus') " class="btn btn-danger btn-sm"><i class="fa fa-trash">Reset</i></a>
                                             <?php } ?>
                                         <?php } ?>
                                 </td>
                             </tr>
                                 <?php endforeach ?>
                         </tbody>
                     </table>
     </div>
</div>

<!-- Modals -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Rincian Setor</h4>
            </div>
            <div class="modal-body"><div id="detail-content"></div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-proses" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Proses Setoran Kaos CMT</h4>
            </div>
            <div class="modal-body"><div id="proses-content"></div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Rincian Setor</h4>
            </div>
            <div class="modal-body"><div id="edit-content"></div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-susulan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Setoran Susulan Kaos CMT</h4>
            </div>
            <div class="modal-body"><div id="susulan-content"></div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id');
            $('#modal-detail').modal('show');
            $('#modal-detail .loading-overlay').css('display', 'flex');
            $.get('<?php echo BASEURL . "Finishing/detail_setoran_modal/" ?>' + id, function(res) {
                $('#modal-detail .loading-overlay').hide();
                $('#detail-content').html(res);
            });
        });

        $('.btn-proses').on('click', function() {
            var idpo = $(this).data('idpo');
            var kodepo = $(this).data('kodepo');
            var idklo = $(this).data('idklo');
            $('#modal-proses').modal('show');
            $('#modal-proses .loading-overlay').css('display', 'flex');
            $.get('<?php echo BASEURL . "Finishing/produksikaoscmt_modal/" ?>' + idpo + '/' + kodepo + '/' + idklo, function(res) {
                $('#modal-proses .loading-overlay').hide();
                $('#proses-content').html(res);
            });
        });

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $('#modal-edit .loading-overlay').css('display', 'flex');
            $.get('<?php echo BASEURL . "Finishing/edit_setoran_modal/" ?>' + id, function(res) {
                $('#modal-edit .loading-overlay').hide();
                $('#edit-content').html(res);
            });
        });

        $('.btn-susulan').on('click', function() {
            var id = $(this).data('id');
            $('#modal-susulan').modal('show');
            $('#modal-susulan .loading-overlay').css('display', 'flex');
            $.get('<?php echo BASEURL . "Finishing/editsetoran_susulan_modal/" ?>' + id, function(res) {
                $('#modal-susulan .loading-overlay').hide();
                $('#susulan-content').html(res);
            });
        });

        // Tampilkan loader saat form disubmit
        $(document).on('submit', 'form', function() {
            $(this).closest('.modal-content').find('.loading-overlay').css('display', 'flex');
        });
    });

  function filter(){
    var url='?';
    var nomesin=$("#kode_po").val();
     var cmt=$("#cmt").val();

    if(nomesin!="*"){
      url+='&kode_po='+nomesin;
    }

    if(cmt!="*"){
      url+='&cmt='+cmt;
    }

    location=url;
  }
</script>